<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
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
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'phone'    => 'nullable|string',
            'country'  => 'nullable|string',
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
        try {
            $this->configureMailer();
            Mail::to($user->email, $user->name)->send(new WelcomeEmail($user));
        } catch (\Throwable $e) {
            Log::error('Registration welcome email failed', [
                'user'  => $user->id,
                'email' => $user->email,
                'error' => $e->getMessage(),
            ]);
        }

        // Admin notification
        try {
            $adminEmail = Setting::get('contact_email') ?: Setting::get('mail_from_address');
            if ($adminEmail) {
                $fromName = Setting::get('mail_from_name', '7AI');
                $fromAddr = Setting::get('mail_from_address', 'hello@7ai.africa');
                Mail::send('emails.admin-new-user', ['user' => $user], function ($msg) use ($adminEmail, $fromName, $fromAddr, $user) {
                    $msg->to($adminEmail)
                        ->from($fromAddr, $fromName)
                        ->subject('New user registered: ' . $user->name);
                });
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
