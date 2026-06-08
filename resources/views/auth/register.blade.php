<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Create Account — 7AI</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Inter',sans-serif;background:#f8fafc;display:flex;min-height:100vh;align-items:center;justify-content:center;padding:40px 20px;}
    .auth-card{background:#fff;border-radius:20px;padding:48px;width:100%;max-width:460px;box-shadow:0 4px 24px rgba(0,0,0,0.08);}
    .auth-logo{display:flex;align-items:center;gap:10px;margin-bottom:32px;}
    .auth-logo-mark{width:36px;height:36px;background:#0B4F6C;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:14px;}
    .auth-logo-text{font-size:18px;font-weight:700;color:#0B4F6C;}
    h1{font-size:24px;font-weight:700;color:#0d1b2a;margin-bottom:8px;}
    p.sub{font-size:14px;color:#6b7280;margin-bottom:32px;}
    label{display:block;font-size:13px;font-weight:500;color:#374151;margin-bottom:6px;}
    input[type=text],input[type=email],input[type=password]{width:100%;padding:12px 16px;border:1.5px solid #e5e7eb;border-radius:10px;font-size:14px;font-family:inherit;outline:none;transition:border-color 0.2s;}
    input:focus{border-color:#0B4F6C;}
    .form-group{margin-bottom:20px;}
    .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    .btn{width:100%;padding:13px;background:#0B4F6C;color:#fff;border:none;border-radius:10px;font-size:15px;font-weight:600;cursor:pointer;font-family:inherit;transition:background 0.2s;}
    .btn:hover{background:#093d56;}
    .error{background:#fef2f2;border:1px solid #fecaca;color:#dc2626;padding:12px 16px;border-radius:8px;font-size:13px;margin-bottom:20px;}
    .link{text-align:center;margin-top:20px;font-size:14px;color:#6b7280;}
    .link a{color:#0B4F6C;font-weight:500;text-decoration:none;}
    .field-error{font-size:12px;color:#dc2626;margin-top:4px;}
  </style>
</head>
<body>
<div class="auth-card">
  <div class="auth-logo">
    <div class="auth-logo-mark">7A</div>
    <div class="auth-logo-text">7AI</div>
  </div>
  <h1>Create your account</h1>
  <p class="sub">Get started with 7AI today</p>

  @if($errors->any())
    <div class="error">{{ $errors->first() }}</div>
  @endif

  <form method="POST" action="{{ route('register.submit') }}">
    @csrf
    <div class="grid-2">
      <div class="form-group">
        <label>First name</label>
        <input type="text" name="first_name" value="{{ old('first_name') }}" required>
        @error('first_name')<div class="field-error">{{ $message }}</div>@enderror
      </div>
      <div class="form-group">
        <label>Last name</label>
        <input type="text" name="last_name" value="{{ old('last_name') }}" required>
        @error('last_name')<div class="field-error">{{ $message }}</div>@enderror
      </div>
    </div>
    <div class="form-group">
      <label>Email address</label>
      <input type="email" name="email" value="{{ old('email') }}" required>
      @error('email')<div class="field-error">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
      <label>Company (optional)</label>
      <input type="text" name="company" value="{{ old('company') }}">
    </div>
    <div class="form-group">
      <label>Password</label>
      <input type="password" name="password" required>
      @error('password')<div class="field-error">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
      <label>Confirm password</label>
      <input type="password" name="password_confirmation" required>
    </div>
    <button type="submit" class="btn">Create account</button>
  </form>
  <div class="link">Already have an account? <a href="{{ route('login') }}">Sign in</a></div>
</div>
</body>
</html>
