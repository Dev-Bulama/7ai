<?php

namespace App\Services;

use App\Models\EmailTemplate;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SmtpMailService
{
    /**
     * Apply admin SMTP settings from DB to the Laravel mail config at runtime.
     * Returns true if SMTP host was found and config was applied; false otherwise.
     */
    public static function configure(): bool
    {
        $host = Setting::get('mail_host');

        if (!$host) {
            Log::warning('[MAIL] mail_host is not set in admin settings — falling back to .env mail driver');
            return false;
        }

        $port       = (int) Setting::get('mail_port', 587);
        $username   = Setting::get('mail_username', '');
        $encryption = Setting::get('mail_encryption', 'tls');
        $fromName   = Setting::get('mail_from_name', '7AI');
        $fromAddr   = Setting::get('mail_from_address', 'hello@7ai.africa');

        Config::set('mail.mailers.smtp.transport',  'smtp');
        Config::set('mail.mailers.smtp.host',        $host);
        Config::set('mail.mailers.smtp.port',        $port);
        Config::set('mail.mailers.smtp.username',    $username);
        Config::set('mail.mailers.smtp.password',    Setting::get('mail_password', ''));
        Config::set('mail.mailers.smtp.encryption',  $encryption);
        Config::set('mail.from.name',                $fromName);
        Config::set('mail.from.address',             $fromAddr);
        Config::set('mail.default',                  'smtp');

        // Purge cached mailer so next send creates a fresh transport from the new config
        app('mail.manager')->purge('smtp');

        Log::info('[MAIL] SMTP configured from DB settings', [
            'host'       => $host,
            'port'       => $port,
            'username'   => $username ?: '(not set)',
            'encryption' => $encryption,
            'from'       => "$fromName <$fromAddr>",
        ]);

        return true;
    }

    /**
     * Send the user registration welcome email synchronously.
     * Never throws — all errors are caught and logged.
     */
    public static function sendWelcomeEmail(User $user): bool
    {
        Log::info('[MAIL] Attempting registration welcome email', [
            'type'  => 'user_welcome',
            'to'    => $user->email,
        ]);

        self::configure();

        Log::info('[MAIL] Active mailer config', [
            'mailer'     => config('mail.default'),
            'host'       => config('mail.mailers.smtp.host'),
            'port'       => config('mail.mailers.smtp.port'),
            'encryption' => config('mail.mailers.smtp.encryption'),
            'from'       => config('mail.from.address'),
        ]);

        $fromName   = Setting::get('mail_from_name', '7AI');
        $fromAddr   = Setting::get('mail_from_address', 'hello@7ai.africa');
        $vars       = self::userVars($user);

        try {
            $tpl = null;
            try {
                $tpl = EmailTemplate::getByKey('user_welcome');
            } catch (\Throwable $e) {
                Log::warning('[MAIL] Could not load user_welcome template — using fallback mailable', [
                    'error' => $e->getMessage(),
                ]);
            }

            if ($tpl) {
                $subject = $tpl->renderSubject($vars);
                $body    = $tpl->render($vars);
                Mail::html($body, function ($msg) use ($user, $subject, $fromName, $fromAddr) {
                    $msg->to($user->email, $user->name)
                        ->from($fromAddr, $fromName)
                        ->subject($subject);
                });
            } else {
                Mail::to($user->email, $user->name)
                    ->send(new \App\Mail\WelcomeEmail($user));
            }

            Log::info('[MAIL] Registration welcome email sent', ['to' => $user->email]);
            return true;

        } catch (\Throwable $e) {
            Log::error('[MAIL] Registration welcome email failed', [
                'to'    => $user->email,
                'error' => $e->getMessage(),
                'file'  => $e->getFile() . ':' . $e->getLine(),
            ]);
            return false;
        }
    }

    /**
     * Send admin new-user notification synchronously.
     * Never throws.
     */
    public static function sendAdminNewUserNotification(User $user): bool
    {
        $adminEmail = Setting::get('contact_email') ?: Setting::get('mail_from_address');
        if (!$adminEmail) {
            Log::info('[MAIL] No admin email configured — skipping admin new-user notification');
            return false;
        }

        $fromName = Setting::get('mail_from_name', '7AI');
        $fromAddr = Setting::get('mail_from_address', 'hello@7ai.africa');
        $vars     = array_merge(self::userVars($user), ['login_url' => url('/admin/users')]);

        try {
            $tpl = null;
            try {
                $tpl = EmailTemplate::getByKey('admin_new_user');
            } catch (\Throwable $e) {
                // template table not migrated yet — skip silently
            }

            if (!$tpl) {
                Log::info('[MAIL] admin_new_user template not found — skipping admin notification');
                return false;
            }

            Mail::html($tpl->render($vars), function ($msg) use ($adminEmail, $fromName, $fromAddr, $tpl, $vars) {
                $msg->to($adminEmail)
                    ->from($fromAddr, $fromName)
                    ->subject($tpl->renderSubject($vars));
            });

            Log::info('[MAIL] Admin new-user notification sent', ['to' => $adminEmail]);
            return true;

        } catch (\Throwable $e) {
            Log::error('[MAIL] Admin new-user notification failed', [
                'to'    => $adminEmail,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Send the admin SMTP test email. Returns ['ok' => bool, 'message' => string].
     */
    public static function sendTestEmail(string $to): array
    {
        $configured = self::configure();

        $fromName = Setting::get('mail_from_name', '7AI');
        $fromAddr = Setting::get('mail_from_address', 'hello@7ai.africa');
        $siteName = Setting::get('site_name', '7AI');

        Log::info('[MAIL] Attempting SMTP test email', [
            'type'       => 'test_email',
            'to'         => $to,
            'mailer'     => config('mail.default'),
            'host'       => config('mail.mailers.smtp.host'),
            'port'       => config('mail.mailers.smtp.port'),
            'encryption' => config('mail.mailers.smtp.encryption'),
            'from'       => config('mail.from.address'),
        ]);

        if (!$configured) {
            return [
                'ok'      => false,
                'message' => 'SMTP host is not configured in Admin → Settings → Email. Please save your SMTP credentials first.',
            ];
        }

        try {
            $body = '<div style="font-family:sans-serif;max-width:500px;margin:40px auto;padding:32px;background:#f9fafb;border-radius:8px;border:1px solid #e5e7eb;">'
                . '<h2 style="color:#0b4f6c;margin-bottom:12px;">✓ SMTP Test Email</h2>'
                . '<p style="color:#374151;line-height:1.6;">This is a test email from <strong>' . e($siteName) . '</strong>.</p>'
                . '<p style="color:#374151;line-height:1.6;">If you received this, your SMTP settings are working correctly.</p>'
                . '<p style="font-size:12px;color:#9ca3af;margin-top:24px;">Sent from: ' . e($fromAddr) . '</p>'
                . '</div>';

            Mail::html($body, function ($msg) use ($to, $fromAddr, $fromName) {
                $msg->to($to)->from($fromAddr, $fromName)->subject('7AI — SMTP Test Email');
            });

            Log::info('[MAIL] SMTP test email sent', ['to' => $to]);
            return ['ok' => true, 'message' => "Test email sent successfully to {$to}."];

        } catch (\Throwable $e) {
            $errorMsg = $e->getMessage();
            Log::error('[MAIL] SMTP test email failed', [
                'to'    => $to,
                'error' => $errorMsg,
            ]);
            return ['ok' => false, 'message' => $errorMsg];
        }
    }

    /**
     * Run SMTP diagnostics — returns a structured status array (no passwords).
     */
    public static function diagnostics(): array
    {
        $host       = Setting::get('mail_host');
        $port       = Setting::get('mail_port');
        $username   = Setting::get('mail_username');
        $password   = Setting::get('mail_password');
        $encryption = Setting::get('mail_encryption');
        $fromAddr   = Setting::get('mail_from_address');

        $checks = [
            'mail_host'         => ['value' => $host,       'ok' => (bool) $host,     'label' => 'SMTP Host'],
            'mail_port'         => ['value' => $port,       'ok' => (bool) $port,     'label' => 'SMTP Port'],
            'mail_username'     => ['value' => $username,   'ok' => (bool) $username, 'label' => 'SMTP Username'],
            'mail_password'     => ['value' => $password ? '(set)' : '(empty)', 'ok' => (bool) $password, 'label' => 'SMTP Password'],
            'mail_from_address' => ['value' => $fromAddr,   'ok' => (bool) $fromAddr, 'label' => 'From Address'],
            'mail_encryption'   => ['value' => $encryption ?: 'tls (default)', 'ok' => true, 'label' => 'Encryption'],
        ];

        $allOk = collect($checks)->every(fn($c) => $c['ok']);

        return [
            'all_ok' => $allOk,
            'checks' => $checks,
        ];
    }

    // ── Private helpers ────────────────────────────────────────────────────────

    private static function userVars(User $user): array
    {
        return [
            'name'          => $user->name,
            'email'         => $user->email,
            'login_url'     => url('/dashboard'),
            'site_name'     => Setting::get('site_name', '7AI'),
            'support_email' => Setting::get('support_email') ?: Setting::get('contact_email', 'hello@7ai.africa'),
            'current_year'  => date('Y'),
        ];
    }
}
