<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ $title ?? 'Dashboard' }} — 7AI</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Inter',sans-serif;background:#f8fafc;color:#0d1b2a;}
    .layout{display:flex;min-height:100vh;}
    .sidebar{width:240px;background:#0B4F6C;display:flex;flex-direction:column;flex-shrink:0;position:sticky;top:0;height:100vh;overflow-y:auto;}
    .sidebar-logo{padding:24px 20px;border-bottom:1px solid rgba(255,255,255,0.1);}
    .sidebar-logo-wrap{display:flex;align-items:center;gap:10px;}
    .logo-mark{width:32px;height:32px;background:rgba(255,255,255,0.15);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:13px;}
    .logo-text{color:#fff;font-weight:700;font-size:16px;}
    .sidebar-nav{flex:1;padding:16px 0;}
    .nav-label{font-size:10px;font-weight:600;color:rgba(255,255,255,0.35);letter-spacing:0.08em;text-transform:uppercase;padding:12px 20px 6px;}
    .nav-item{display:flex;align-items:center;gap:10px;padding:10px 20px;color:rgba(255,255,255,0.75);font-size:14px;font-weight:500;text-decoration:none;border-radius:0;transition:background 0.15s,color 0.15s;}
    .nav-item:hover,.nav-item.active{background:rgba(255,255,255,0.12);color:#fff;}
    .nav-item svg{opacity:0.7;flex-shrink:0;}
    .nav-item.active svg{opacity:1;}
    .sidebar-footer{padding:16px 20px;border-top:1px solid rgba(255,255,255,0.1);}
    .user-info{display:flex;align-items:center;gap:10px;margin-bottom:12px;}
    .user-avatar{width:32px;height:32px;background:rgba(62,224,127,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#3EE07F;font-size:12px;font-weight:700;flex-shrink:0;}
    .user-name{font-size:13px;font-weight:500;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
    .user-role{font-size:11px;color:rgba(255,255,255,0.5);}
    .logout-btn{display:block;text-align:center;padding:8px;background:rgba(255,255,255,0.08);color:rgba(255,255,255,0.7);border-radius:8px;font-size:13px;text-decoration:none;transition:background 0.15s;}
    .logout-btn:hover{background:rgba(255,255,255,0.15);color:#fff;}
    .main{flex:1;min-width:0;}
    .topbar{background:#fff;border-bottom:1px solid #e5e7eb;padding:0 32px;height:64px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:10;}
    .topbar-title{font-size:17px;font-weight:600;color:#0d1b2a;}
    .topbar-actions{display:flex;align-items:center;gap:12px;}
    .btn-sm{padding:8px 16px;background:#0B4F6C;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:500;cursor:pointer;font-family:inherit;text-decoration:none;display:inline-flex;align-items:center;gap:6px;}
    .btn-sm:hover{background:#093d56;}
    .content{padding:32px;}
    .alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;padding:12px 16px;border-radius:8px;font-size:13px;margin-bottom:20px;}
    .alert-error{background:#fef2f2;border:1px solid #fecaca;color:#dc2626;padding:12px 16px;border-radius:8px;font-size:13px;margin-bottom:20px;}
    @media(max-width:768px){.sidebar{display:none;}.content{padding:20px;}}
  </style>
</head>
<body>
<div class="layout">
  <aside class="sidebar">
    <div class="sidebar-logo">
      <div class="sidebar-logo-wrap">
        <div class="logo-mark">7A</div>
        <div class="logo-text">7AI</div>
      </div>
    </div>
    <nav class="sidebar-nav">
      <div class="nav-label">My Account</div>
      <a href="{{ route('customer.dashboard') }}" class="nav-item {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        Dashboard
      </a>
      <a href="{{ route('customer.projects') }}" class="nav-item {{ request()->routeIs('customer.projects') ? 'active' : '' }}">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
        My Projects
      </a>
      <a href="{{ route('customer.invoices') }}" class="nav-item {{ request()->routeIs('customer.invoices') ? 'active' : '' }}">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        Invoices
      </a>
      <a href="{{ route('customer.tickets.index') }}" class="nav-item {{ request()->routeIs('customer.tickets.*') ? 'active' : '' }}">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3m0 4h.01"/></svg>
        Support Tickets
      </a>
    </nav>
    <div class="sidebar-footer">
      <div class="user-info">
        <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}</div>
        <div>
          <div class="user-name">{{ auth()->user()->name }}</div>
          <div class="user-role">Client</div>
        </div>
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn" style="width:100%;border:none;cursor:pointer;">Sign out</button>
      </form>
    </div>
  </aside>
  <div class="main">
    <div class="topbar">
      <div class="topbar-title">{{ $title ?? 'Dashboard' }}</div>
      <div class="topbar-actions">{{ $actions ?? '' }}</div>
    </div>
    <div class="content">
      @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
      @endif
      {{ $slot }}
    </div>
  </div>
</div>
</body>
</html>
