<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>{{ $title ?? 'Admin' }} — 7AI Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root{--teal:#0B4F6C;--teal-dark:#083A50;--green:#3EE07F;--dark:#0D1B2A;--gray-50:#F8FAFC;--gray-100:#F1F5F9;--gray-200:#E2E8F0;--gray-400:#94A3B8;--gray-500:#64748B;--gray-600:#475569;--gray-700:#334155;--white:#fff;}
    *{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:'Inter',sans-serif;background:var(--gray-50);color:var(--dark);display:flex;min-height:100vh;-webkit-font-smoothing:antialiased;}
    /* Sidebar */
    .sidebar{width:240px;flex-shrink:0;background:var(--teal-dark);color:#fff;display:flex;flex-direction:column;position:fixed;top:0;left:0;height:100vh;overflow-y:auto;z-index:50;}
    .sidebar-logo{padding:20px 20px 16px;border-bottom:1px solid rgba(255,255,255,0.08);}
    .sidebar-logo img{height:28px;}
    .sidebar-logo span{display:block;font-size:11px;color:rgba(255,255,255,0.4);margin-top:4px;letter-spacing:0.06em;text-transform:uppercase;}
    .sidebar-nav{padding:16px 0;flex:1;}
    .nav-section{font-size:10px;font-weight:700;color:rgba(255,255,255,0.3);letter-spacing:0.1em;text-transform:uppercase;padding:16px 20px 8px;}
    .nav-item{display:flex;align-items:center;gap:10px;padding:9px 20px;font-size:13.5px;font-weight:500;color:rgba(255,255,255,0.7);text-decoration:none;border-left:3px solid transparent;transition:all 0.15s;}
    .nav-item:hover,.nav-item.active{color:#fff;background:rgba(255,255,255,0.08);border-left-color:var(--green);}
    .nav-item svg{opacity:0.7;flex-shrink:0;}
    .sidebar-user{padding:16px 20px;border-top:1px solid rgba(255,255,255,0.08);}
    .sidebar-user .name{font-size:13px;font-weight:600;color:#fff;}
    .sidebar-user .role{font-size:11px;color:rgba(255,255,255,0.5);margin-top:2px;}
    /* Main */
    .main{margin-left:240px;flex:1;display:flex;flex-direction:column;min-height:100vh;}
    .topbar{background:var(--white);border-bottom:1px solid var(--gray-200);padding:0 32px;height:60px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40;}
    .topbar h1{font-size:18px;font-weight:700;color:var(--dark);}
    .topbar-right{display:flex;align-items:center;gap:16px;}
    .content{padding:32px;flex:1;}
    /* Cards */
    .card{background:var(--white);border:1px solid var(--gray-200);border-radius:12px;padding:24px;}
    .stat-card{background:var(--white);border:1px solid var(--gray-200);border-radius:12px;padding:20px 24px;}
    .stat-card .label{font-size:13px;color:var(--gray-500);font-weight:500;margin-bottom:8px;}
    .stat-card .value{font-size:30px;font-weight:700;color:var(--dark);letter-spacing:-0.02em;}
    .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:16px;margin-bottom:28px;}
    /* Table */
    .table-wrap{overflow-x:auto;}
    table{width:100%;border-collapse:collapse;}
    th{text-align:left;font-size:11px;font-weight:700;color:var(--gray-500);letter-spacing:0.06em;text-transform:uppercase;padding:10px 16px;border-bottom:1px solid var(--gray-200);background:var(--gray-50);}
    td{padding:12px 16px;font-size:14px;color:var(--gray-700);border-bottom:1px solid var(--gray-100);}
    tr:last-child td{border-bottom:none;}
    tr:hover td{background:var(--gray-50);}
    /* Badges */
    .badge{display:inline-flex;align-items:center;padding:2px 10px;border-radius:100px;font-size:11px;font-weight:600;}
    .badge-green{background:rgba(62,224,127,0.15);color:#15803D;}
    .badge-teal{background:rgba(11,79,108,0.1);color:var(--teal);}
    .badge-yellow{background:rgba(234,179,8,0.15);color:#A16207;}
    .badge-red{background:rgba(239,68,68,0.15);color:#B91C1C;}
    .badge-gray{background:var(--gray-100);color:var(--gray-600);}
    /* Buttons */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:7px;font-size:13px;font-weight:600;text-decoration:none;border:none;cursor:pointer;transition:all 0.15s;}
    .btn-primary{background:var(--teal);color:#fff;} .btn-primary:hover{background:var(--teal-dark);}
    .btn-outline{border:1.5px solid var(--gray-200);color:var(--gray-700);background:#fff;} .btn-outline:hover{border-color:var(--teal);color:var(--teal);}
    .btn-danger{background:rgba(239,68,68,0.1);color:#B91C1C;} .btn-danger:hover{background:rgba(239,68,68,0.2);}
    .btn-sm{padding:5px 12px;font-size:12px;border-radius:6px;}
    /* Forms */
    .form-group{margin-bottom:16px;}
    .form-label{display:block;font-size:12px;font-weight:600;color:var(--gray-700);margin-bottom:6px;letter-spacing:0.02em;}
    .form-input{width:100%;padding:9px 13px;border:1.5px solid var(--gray-200);border-radius:7px;font-size:13.5px;color:var(--dark);outline:none;transition:border-color 0.15s;}
    .form-input:focus{border-color:var(--teal);box-shadow:0 0 0 3px rgba(11,79,108,0.1);}
    textarea.form-input{resize:vertical;min-height:100px;}
    select.form-input{cursor:pointer;}
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    /* Alert */
    .alert{padding:12px 16px;border-radius:8px;font-size:13.5px;margin-bottom:20px;}
    .alert-success{background:rgba(62,224,127,0.12);border:1px solid rgba(62,224,127,0.3);color:#15803D;}
    .alert-error{background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);color:#B91C1C;}
    /* Section header */
    .section-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;}
    .section-title{font-size:16px;font-weight:700;color:var(--dark);}
    /* Pagination */
    .pagination{display:flex;gap:4px;margin-top:20px;} .pagination a,.pagination span{padding:6px 12px;border-radius:6px;font-size:13px;border:1px solid var(--gray-200);color:var(--gray-600);text-decoration:none;} .pagination a:hover{border-color:var(--teal);color:var(--teal);} .pagination .active{background:var(--teal);color:#fff;border-color:var(--teal);}
    /* Search bar */
    .search-bar{position:relative;} .search-bar input{padding-left:36px;} .search-bar .icon{position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--gray-400);}
    /* Toolbar */
    .toolbar{display:flex;align-items:center;gap:10px;margin-bottom:20px;flex-wrap:wrap;}
  </style>
</head>
<body>
<aside class="sidebar">
  <div class="sidebar-logo">
    <img src="/images/logo-white.svg" alt="7AI">
    <span>Admin Panel</span>
  </div>
  <nav class="sidebar-nav">
    <div class="nav-section">Overview</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg> Dashboard
    </a>
    <a href="{{ route('admin.leads.index') }}" class="nav-item {{ request()->routeIs('admin.leads.*') ? 'active' : '' }}">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg> Leads / CRM
    </a>
    <a href="{{ route('admin.tickets.index') }}" class="nav-item {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/></svg> Support Tickets
    </a>

    <div class="nav-section">Content</div>
    <a href="{{ route('admin.pages.index') }}" class="nav-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h20v18H2z"/><path d="M2 9h20"/></svg> Pages
    </a>
    <a href="{{ route('admin.posts.index') }}" class="nav-item {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg> Blog Posts
    </a>
    <a href="{{ route('admin.media.index') }}" class="nav-item {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21,15 16,10 5,21"/></svg> Media Library
    </a>

    <div class="nav-section">Email Marketing</div>
    <a href="{{ route('admin.campaigns.index') }}" class="nav-item {{ request()->routeIs('admin.campaigns.*') ? 'active' : '' }}">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg> Campaigns
    </a>
    <a href="{{ route('admin.subscribers.index') }}" class="nav-item {{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg> Subscribers
    </a>

    <div class="nav-section">System</div>
    <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg> Users
    </a>
    <a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/></svg> Settings
    </a>
  </nav>
  <div class="sidebar-user">
    <div class="name">{{ auth()->user()->name }}</div>
    <div class="role">{{ auth()->user()->getRoleNames()->first() ?? 'Admin' }}</div>
    <form method="POST" action="{{ route('logout') }}" style="margin-top:10px;">
      @csrf <button type="submit" style="background:rgba(255,255,255,0.1);border:none;color:rgba(255,255,255,0.7);padding:6px 12px;border-radius:6px;font-size:12px;cursor:pointer;width:100%;">Sign Out</button>
    </form>
  </div>
</aside>

<div class="main">
  <div class="topbar">
    <h1>{{ $title ?? 'Dashboard' }}</h1>
    <div class="topbar-right">
      <a href="{{ route('customer.dashboard') }}" class="btn btn-outline btn-sm">Client View</a>
      <span style="font-size:13px;color:var(--gray-500);">{{ auth()->user()->name }}</span>
    </div>
  </div>
  <div class="content">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
    @endif
    @if($errors->any())
    <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif
    {{ $slot }}
  </div>
</div>
</body>
</html>
