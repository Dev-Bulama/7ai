<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
use App\Models\EmailTemplate;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Normalize email before validation — prevents User@Email.com and user@email.com as separate accounts
        $request->merge(['email' => strtolower(trim($request->input('email', '')))]);

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => 'required|min:8|confirmed',
            'phone'    => 'nullable|string|max:30',
            'country'  => 'nullable|string',
        ], [
            'email.unique' => 'This email address is already registered. Please log in instead.',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'phone'    => $data['phone'] ?? null,
            'country'  => $data['country'] ?? null,
        ]);

        $user->assignRole('customer');
        Auth::login($user);

        $this->sendWelcomeEmail($user);

        return redirect()->route('customer.dashboard');
    }

    private function sendWelcomeEmail(User $user): void
    {
        Log::info('[7AI Register] Welcome email triggered', ['user_id' => $user->id, 'email' => $user->email]);

        // Step 1 — check email notifications setting
        $notifEnabled = Setting::get('email_notifications', '1');
        Log::info('[7AI Register] email_notifications setting: ' . $notifEnabled);
        if ($notifEnabled === '0') {
            Log::info('[7AI Register] Skipped — email notifications disabled in settings.');
            return;
        }

        // Step 2 — load SMTP settings from DB and configure mailer
        $host       = Setting::get('mail_host');
        $port       = (int) Setting::get('mail_port', 587);
        $username   = Setting::get('mail_username');
        $password   = Setting::get('mail_password');
        $encryption = Setting::get('mail_encryption', 'tls');
        $fromName   = Setting::get('mail_from_name', '7AI');
        $fromAddr   = Setting::get('mail_from_address', 'hello@7ai.africa');

        Log::info('[7AI Register] SMTP config from DB', [
            'host'       => $host ?: '(not set)',
            'port'       => $port,
            'username'   => $username ?: '(not set)',
            'encryption' => $encryption,
            'from'       => "$fromName <$fromAddr>",
        ]);

        if ($host) {
            Config::set('mail.mailers.smtp.transport', 'smtp');
            Config::set('mail.mailers.smtp.host',       $host);
            Config::set('mail.mailers.smtp.port',       $port);
            Config::set('mail.mailers.smtp.username',   $username);
            Config::set('mail.mailers.smtp.password',   $password);
            Config::set('mail.mailers.smtp.encryption', $encryption);
            Config::set('mail.from.name',               $fromName);
            Config::set('mail.from.address',            $fromAddr);
            Config::set('mail.default',                 'smtp');
            // Purge cached mailer so next send picks up fresh config values
            app('mail.manager')->purge('smtp');
            Log::info('[7AI Register] SMTP configured and mailer purged — will use smtp driver');
        } else {
            Log::warning('[7AI Register] mail_host not set in DB — falling back to .env mail driver (may be log)');
        }

        // Step 3 — build vars for template substitution
        $vars = [
            'name'          => $user->name,
            'email'         => $user->email,
            'login_url'     => url('/dashboard'),
            'site_name'     => Setting::get('site_name', '7AI'),
            'support_email' => Setting::get('support_email') ?: Setting::get('contact_email', 'hello@7ai.africa'),
            'current_year'  => date('Y'),
        ];

        // Step 4 — send welcome email to user
        try {
            $tpl = null;
            try {
                $tpl = EmailTemplate::getByKey('user_welcome');
                Log::info('[7AI Register] user_welcome template ' . ($tpl ? 'found (id=' . $tpl->id . ')' : 'not found — using fallback mailable'));
            } catch (\Throwable $e) {
                Log::warning('[7AI Register] Could not query email_templates table — using fallback mailable', ['error' => $e->getMessage()]);
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
                // Fallback: use WelcomeEmail mailable (sends synchronously via send())
                Mail::to($user->email, $user->name)->send(new WelcomeEmail($user));
            }

            Log::info('[7AI Register] Welcome email sent successfully', ['to' => $user->email]);
        } catch (\Throwable $e) {
            Log::error('[7AI Register] Welcome email FAILED — registration still succeeded', [
                'user_id' => $user->id,
                'email'   => $user->email,
                'error'   => $e->getMessage(),
                'file'    => $e->getFile() . ':' . $e->getLine(),
            ]);
        }

        // Step 5 — admin notification (best-effort, never breaks registration)
        try {
            $adminEmail = Setting::get('contact_email') ?: Setting::get('mail_from_address');
            if ($adminEmail) {
                $adminVars = array_merge($vars, ['login_url' => url('/admin/users')]);
                $adminTpl  = null;
                try {
                    $adminTpl = EmailTemplate::getByKey('admin_new_user');
                } catch (\Throwable $e) {
                    // template table missing — skip silently
                }
                if ($adminTpl) {
                    Mail::html($adminTpl->render($adminVars), function ($msg) use ($adminEmail, $fromName, $fromAddr, $adminTpl, $adminVars) {
                        $msg->to($adminEmail)->from($fromAddr, $fromName)->subject($adminTpl->renderSubject($adminVars));
                    });
                    Log::info('[7AI Register] Admin notification sent', ['to' => $adminEmail]);
                }
            }
        } catch (\Throwable $e) {
            Log::error('[7AI Register] Admin notification failed', ['error' => $e->getMessage()]);
        }
    }
}
