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
        // Normalize email before validation to catch case/whitespace duplicates
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
        // Skip if email notifications disabled
        if (Setting::get('email_notifications', '1') === '0') return;

        $this->configureMailer();

        $vars = [
            'name'          => $user->name,
            'email'         => $user->email,
            'login_url'     => url('/dashboard'),
            'site_name'     => Setting::get('site_name', '7AI'),
            'support_email' => Setting::get('support_email') ?: Setting::get('contact_email', 'hello@7ai.africa'),
            'current_year'  => date('Y'),
        ];

        $fromName = Setting::get('mail_from_name', '7AI');
        $fromAddr = Setting::get('mail_from_address', 'hello@7ai.africa');

        // Welcome email to user
        Log::info('Registration welcome email: attempting', ['user' => $user->id, 'email' => $user->email]);
        try {
            // Isolate template lookup — DB error (e.g. table not migrated yet) must not
            // prevent the fallback mailable from sending.
            $tpl = null;
            try {
                $tpl = EmailTemplate::getByKey('user_welcome');
            } catch (\Throwable $e) {
                Log::warning('Could not load user_welcome template, using fallback', ['error' => $e->getMessage()]);
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
                Mail::to($user->email, $user->name)->send(new WelcomeEmail($user));
            }

            Log::info('Registration welcome email: sent', ['user' => $user->id, 'email' => $user->email]);
        } catch (\Throwable $e) {
            Log::error('Registration welcome email: failed', [
                'user'  => $user->id,
                'email' => $user->email,
                'error' => $e->getMessage(),
            ]);
        }

        // Admin notification
        try {
            $adminEmail = Setting::get('contact_email') ?: Setting::get('mail_from_address');
            if ($adminEmail) {
                $adminVars = array_merge($vars, ['login_url' => url('/admin/users')]);
                $adminTpl  = null;
                try {
                    $adminTpl = EmailTemplate::getByKey('admin_new_user');
                } catch (\Throwable $e) {
                    Log::warning('Could not load admin_new_user template', ['error' => $e->getMessage()]);
                }
                if ($adminTpl) {
                    $subject = $adminTpl->renderSubject($adminVars);
                    $body    = $adminTpl->render($adminVars);
                    Mail::html($body, function ($msg) use ($adminEmail, $fromName, $fromAddr, $subject) {
                        $msg->to($adminEmail)->from($fromAddr, $fromName)->subject($subject);
                    });
                    Log::info('Admin new user notification sent', ['to' => $adminEmail]);
                }
            }
        } catch (\Throwable $e) {
            Log::error('Admin new user notification failed', ['error' => $e->getMessage()]);
        }
    }

    private function configureMailer(): void
    {
        $host = Setting::get('mail_host');
        if (!$host) return;

        Config::set('mail.mailers.smtp.transport', 'smtp');
        Config::set('mail.mailers.smtp.host', $host);
        Config::set('mail.mailers.smtp.port', (int) Setting::get('mail_port', 587));
        Config::set('mail.mailers.smtp.username', Setting::get('mail_username'));
        Config::set('mail.mailers.smtp.password', Setting::get('mail_password'));
        Config::set('mail.mailers.smtp.encryption', Setting::get('mail_encryption', 'tls'));
        Config::set('mail.from.name', Setting::get('mail_from_name', '7AI'));
        Config::set('mail.from.address', Setting::get('mail_from_address', 'hello@7ai.africa'));
        Config::set('mail.default', 'smtp');

        app('mail.manager')->purge('smtp');
    }
}
