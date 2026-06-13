<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SmtpMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Normalize email — prevents User@Email.com and user@email.com becoming separate accounts
        $request->merge(['email' => strtolower(trim($request->input('email', '')))]);

        // The register form sends first_name + last_name; merge into 'name' if needed
        if (!$request->filled('name') && $request->filled('first_name')) {
            $request->merge([
                'name' => trim($request->input('first_name') . ' ' . $request->input('last_name')),
            ]);
        }

        $data = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'name'       => 'required|string|max:255',
            'email'      => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'   => 'required|min:8|confirmed',
            'phone'      => 'nullable|string|max:30',
            'company'    => 'nullable|string|max:255',
            'country'    => 'nullable|string',
        ], [
            'name.required' => 'Please enter your name.',
            'email.unique'  => 'This email address is already registered. Please log in instead.',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'phone'    => $data['phone']    ?? null,
            'company'  => $data['company']  ?? null,
            'country'  => $data['country']  ?? null,
        ]);

        Log::info('[Registration] New user created', ['id' => $user->id, 'email' => $user->email]);

        $user->assignRole('customer');
        Auth::login($user);

        // Send welcome email — never breaks registration if it fails
        SmtpMailService::sendWelcomeEmail($user);
        SmtpMailService::sendAdminNewUserNotification($user);

        return redirect()->route('customer.dashboard');
    }
}
