<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>New User Registration</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f9;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f9;padding:40px 0;">
  <tr><td align="center">
    <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;">
      <tr>
        <td style="background:#0b4f6c;border-radius:8px 8px 0 0;padding:28px 40px;">
          <div style="font-size:13px;font-weight:600;color:rgba(255,255,255,0.6);text-transform:uppercase;letter-spacing:0.1em;">7AI Admin Notification</div>
          <h2 style="color:#ffffff;font-size:22px;margin:8px 0 0;">New user registered</h2>
        </td>
      </tr>
      <tr>
        <td style="background:#ffffff;padding:36px 40px;">
          <p style="font-size:15px;color:#4a5568;line-height:1.7;margin:0 0 24px;">
            A new user has created an account on 7AI.
          </p>
          <table width="100%" cellpadding="0" cellspacing="0" style="background:#f7fafc;border-radius:6px;padding:0;overflow:hidden;margin-bottom:28px;">
            <tr style="border-bottom:1px solid #e2e8f0;">
              <td style="padding:12px 20px;font-size:13px;font-weight:600;color:#718096;width:140px;">Name</td>
              <td style="padding:12px 20px;font-size:14px;color:#2d3748;">{{ $user->name }}</td>
            </tr>
            <tr style="border-bottom:1px solid #e2e8f0;">
              <td style="padding:12px 20px;font-size:13px;font-weight:600;color:#718096;">Email</td>
              <td style="padding:12px 20px;font-size:14px;color:#2d3748;">{{ $user->email }}</td>
            </tr>
            <tr style="border-bottom:1px solid #e2e8f0;">
              <td style="padding:12px 20px;font-size:13px;font-weight:600;color:#718096;">Phone</td>
              <td style="padding:12px 20px;font-size:14px;color:#2d3748;">{{ $user->phone ?? '—' }}</td>
            </tr>
            <tr style="border-bottom:1px solid #e2e8f0;">
              <td style="padding:12px 20px;font-size:13px;font-weight:600;color:#718096;">Country</td>
              <td style="padding:12px 20px;font-size:14px;color:#2d3748;">{{ $user->country ?? '—' }}</td>
            </tr>
            <tr>
              <td style="padding:12px 20px;font-size:13px;font-weight:600;color:#718096;">Registered at</td>
              <td style="padding:12px 20px;font-size:14px;color:#2d3748;">{{ $user->created_at->format('d M Y, H:i') }} UTC</td>
            </tr>
          </table>
          <div style="text-align:center;">
            <a href="{{ url('/admin/users') }}" style="display:inline-block;background:#0b4f6c;color:#ffffff;font-size:13px;font-weight:600;text-decoration:none;padding:12px 28px;border-radius:4px;">View in Admin Panel →</a>
          </div>
        </td>
      </tr>
      <tr>
        <td style="background:#0a1628;border-radius:0 0 8px 8px;padding:20px 40px;text-align:center;">
          <p style="font-size:12px;color:rgba(255,255,255,0.4);margin:0;">7AI Admin · This is an automated notification.</p>
        </td>
      </tr>
    </table>
  </td></tr>
</table>
</body>
</html>
