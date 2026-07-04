<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Your Staff Portal Credentials</title></head>
<body style="font-family:Arial,sans-serif;background:#f4f4f4;padding:40px 20px;">
  <div style="max-width:500px;margin:0 auto;background:#fff;border-radius:8px;padding:40px;box-shadow:0 2px 8px rgba(0,0,0,0.1);">
    <h2 style="color:#0a1628;margin-top:0;">Staff Portal Access</h2>
    <p>Hello {{ $user->name }},</p>
    <p>Your staff portal account has been created. Use the credentials below to log in:</p>
    <div style="background:#f8f9fa;border-radius:4px;padding:20px;margin:24px 0;">
      <p style="margin:0 0 8px;"><strong>Login URL:</strong> <a href="{{ route('login') }}">{{ route('login') }}</a></p>
      <p style="margin:0 0 8px;"><strong>Staff Portal:</strong> <a href="{{ $portal_url ?? route('login') }}">{{ $portal_url ?? route('login') }}</a></p>
      <p style="margin:0 0 8px;"><strong>Email:</strong> {{ $user->email }}</p>
      <p style="margin:0;"><strong>Password:</strong> <code>{{ $plain_password }}</code></p>
    </div>
    <p style="color:#e53e3e;font-size:13px;">⚠ Please change your password after your first login.</p>
    <p style="color:#718096;font-size:13px;margin-bottom:0;">If you did not expect this email, please ignore it.</p>
  </div>
</body>
</html>
