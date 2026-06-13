<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Welcome to 7AI</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f9;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f9;padding:40px 0;">
  <tr><td align="center">
    <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;">

      <!-- Header -->
      <tr>
        <td style="background:#0a1628;border-radius:8px 8px 0 0;padding:36px 40px;text-align:center;">
          <div style="font-family:'Georgia',serif;font-size:28px;font-weight:900;color:#ffffff;letter-spacing:-0.5px;">
            7<span style="color:#3ee07f;">AI</span>
          </div>
          <div style="font-family:'Courier New',monospace;font-size:10px;letter-spacing:0.2em;text-transform:uppercase;color:rgba(255,255,255,0.4);margin-top:4px;">African Intelligence, Amplified</div>
        </td>
      </tr>

      <!-- Body -->
      <tr>
        <td style="background:#ffffff;padding:40px 40px 32px;">
          <h1 style="font-size:26px;font-weight:700;color:#0a1628;margin:0 0 8px;">Welcome, {{ $user->name }}!</h1>
          <p style="font-size:16px;color:#4a5568;line-height:1.7;margin:0 0 24px;">
            We're delighted to have you on board. Your 7AI account has been created and you're ready to get started.
          </p>

          <div style="background:#f7fafc;border-left:4px solid #3ee07f;border-radius:0 6px 6px 0;padding:20px 24px;margin-bottom:28px;">
            <div style="font-size:13px;font-weight:600;color:#0b4f6c;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">Your account details</div>
            <div style="font-size:15px;color:#2d3748;"><strong>Name:</strong> {{ $user->name }}</div>
            <div style="font-size:15px;color:#2d3748;margin-top:4px;"><strong>Email:</strong> {{ $user->email }}</div>
            <div style="font-size:15px;color:#2d3748;margin-top:4px;"><strong>Registered:</strong> {{ now()->format('d M Y, H:i') }} UTC</div>
          </div>

          <p style="font-size:15px;color:#4a5568;line-height:1.7;margin:0 0 28px;">
            7AI builds intelligent technology infrastructure for Africa — from smart home automation to AI-powered business solutions. We're glad you're part of this journey.
          </p>

          <div style="text-align:center;margin-bottom:32px;">
            <a href="{{ url('/dashboard') }}" style="display:inline-block;background:#0b4f6c;color:#ffffff;font-size:14px;font-weight:600;text-decoration:none;padding:14px 32px;border-radius:4px;letter-spacing:0.05em;">Access Your Dashboard →</a>
          </div>

          <div style="border-top:1px solid #e2e8f0;padding-top:24px;">
            <p style="font-size:14px;color:#718096;line-height:1.6;margin:0;">
              If you have any questions, reach out to us at
              <a href="mailto:{{ \App\Models\Setting::get('contact_email', 'hello@7ai.africa') }}" style="color:#0b4f6c;text-decoration:none;">{{ \App\Models\Setting::get('contact_email', 'hello@7ai.africa') }}</a>.
              We're always happy to help.
            </p>
          </div>
        </td>
      </tr>

      <!-- Footer -->
      <tr>
        <td style="background:#0a1628;border-radius:0 0 8px 8px;padding:24px 40px;text-align:center;">
          <p style="font-size:12px;color:rgba(255,255,255,0.4);margin:0;">
            © {{ date('Y') }} {{ \App\Models\Setting::get('site_name', '7AI Technologies') }}. All rights reserved.<br>
            <a href="{{ url('/') }}" style="color:#3ee07f;text-decoration:none;">7ai.africa</a>
          </p>
        </td>
      </tr>

    </table>
  </td></tr>
</table>
</body>
</html>
