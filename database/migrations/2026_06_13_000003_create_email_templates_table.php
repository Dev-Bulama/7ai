<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key')->unique();
            $table->string('subject');
            $table->longText('body');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Seed defaults
        DB::table('email_templates')->insert([
            [
                'name'       => 'User Registration Welcome Email',
                'key'        => 'user_welcome',
                'subject'    => 'Welcome to {{site_name}}',
                'body'       => '<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;padding:32px 24px;background:#0a1628;color:#ffffff;border-radius:8px;">
  <h1 style="font-size:26px;color:#3ee07f;margin:0 0 8px;">Welcome, {{name}}!</h1>
  <p style="font-size:16px;color:rgba(255,255,255,0.8);line-height:1.7;margin:0 0 20px;">Your account on <strong>{{site_name}}</strong> has been created successfully.</p>
  <p style="font-size:15px;color:rgba(255,255,255,0.7);line-height:1.7;margin:0 0 28px;">You can now log in and explore our AI-powered solutions, smart automation tools, and digital services.</p>
  <div style="text-align:center;margin-bottom:32px;">
    <a href="{{login_url}}" style="display:inline-block;background:#0b4f6c;color:#ffffff;font-size:14px;font-weight:600;text-decoration:none;padding:14px 32px;border-radius:4px;">Access Your Dashboard →</a>
  </div>
  <p style="font-size:14px;color:rgba(255,255,255,0.5);line-height:1.6;margin:0;">If you need support, contact us at <a href="mailto:{{support_email}}" style="color:#3ee07f;">{{support_email}}</a>.</p>
  <p style="margin-top:32px;font-size:13px;color:rgba(255,255,255,0.3);">Thank you,<br>The {{site_name}} Team · © {{current_year}}</p>
</div>',
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Admin New User Notification',
                'key'        => 'admin_new_user',
                'subject'    => 'New user registered: {{name}}',
                'body'       => '<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;padding:32px 24px;background:#f4f6f9;border-radius:8px;">
  <h2 style="color:#0b4f6c;margin:0 0 16px;">New User Registration</h2>
  <p style="color:#374151;">A new user has registered on <strong>{{site_name}}</strong>.</p>
  <table style="width:100%;background:#fff;border-radius:6px;margin:16px 0;border-collapse:collapse;">
    <tr><td style="padding:10px 16px;font-size:13px;color:#6b7280;width:120px;">Name</td><td style="padding:10px 16px;font-size:14px;color:#111;">{{name}}</td></tr>
    <tr style="border-top:1px solid #f0f0f0;"><td style="padding:10px 16px;font-size:13px;color:#6b7280;">Email</td><td style="padding:10px 16px;font-size:14px;color:#111;">{{email}}</td></tr>
    <tr style="border-top:1px solid #f0f0f0;"><td style="padding:10px 16px;font-size:13px;color:#6b7280;">Registered</td><td style="padding:10px 16px;font-size:14px;color:#111;">{{current_year}}</td></tr>
  </table>
  <a href="{{login_url}}" style="display:inline-block;background:#0b4f6c;color:#fff;font-size:13px;font-weight:600;text-decoration:none;padding:10px 24px;border-radius:4px;">View in Admin →</a>
</div>',
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};
