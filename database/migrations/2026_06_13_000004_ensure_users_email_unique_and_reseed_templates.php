<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Ensure users.email has a unique index (safe — original migration already adds it,
        //    but this guards against any environment where it was dropped).
        if (Schema::hasTable('users')) {
            $indexes = collect(DB::select("SHOW INDEX FROM users WHERE Column_name = 'email'"))
                ->pluck('Key_name')->toArray();

            if (empty($indexes)) {
                // Check for duplicates before adding unique index
                $dupes = DB::table('users')
                    ->select('email', DB::raw('COUNT(*) as cnt'))
                    ->groupBy('email')
                    ->having('cnt', '>', 1)
                    ->pluck('email')
                    ->toArray();

                if (!empty($dupes)) {
                    Log::warning('Duplicate emails found before adding unique index — keeping oldest account', [
                        'emails' => $dupes,
                    ]);
                    // For each duplicate, keep the oldest row and delete the rest
                    foreach ($dupes as $email) {
                        $ids = DB::table('users')
                            ->where('email', $email)
                            ->orderBy('id')
                            ->pluck('id')
                            ->toArray();
                        $keep = array_shift($ids);
                        DB::table('users')->whereIn('id', $ids)->delete();
                    }
                }

                Schema::table('users', function (Blueprint $table) {
                    $table->unique('email');
                });
            }
        }

        // 2. Re-seed email_templates defaults if the table exists but is empty.
        //    This handles the case where migration 000003 ran but seeds were skipped.
        if (Schema::hasTable('email_templates')) {
            $existing = DB::table('email_templates')->pluck('key')->toArray();

            $templates = [
                'user_welcome' => [
                    'name'    => 'User Registration Welcome Email',
                    'subject' => 'Welcome to {{site_name}}',
                    'body'    => '<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;padding:32px 24px;background:#0a1628;color:#ffffff;border-radius:8px;">
  <h1 style="font-size:26px;color:#3ee07f;margin:0 0 8px;">Welcome, {{name}}!</h1>
  <p style="font-size:16px;color:rgba(255,255,255,0.8);line-height:1.7;margin:0 0 20px;">Your account on <strong>{{site_name}}</strong> has been created successfully.</p>
  <p style="font-size:15px;color:rgba(255,255,255,0.7);line-height:1.7;margin:0 0 28px;">You can now log in and explore our AI-powered solutions, smart automation tools, and digital services.</p>
  <div style="text-align:center;margin-bottom:32px;">
    <a href="{{login_url}}" style="display:inline-block;background:#0b4f6c;color:#ffffff;font-size:14px;font-weight:600;text-decoration:none;padding:14px 32px;border-radius:4px;">Access Your Dashboard →</a>
  </div>
  <p style="font-size:14px;color:rgba(255,255,255,0.5);line-height:1.6;margin:0;">If you need support, contact us at <a href="mailto:{{support_email}}" style="color:#3ee07f;">{{support_email}}</a>.</p>
  <p style="margin-top:32px;font-size:13px;color:rgba(255,255,255,0.3);">Thank you,<br>The {{site_name}} Team · © {{current_year}}</p>
</div>',
                ],
                'admin_new_user' => [
                    'name'    => 'Admin New User Notification',
                    'subject' => 'New user registered: {{name}}',
                    'body'    => '<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;padding:32px 24px;background:#f4f6f9;border-radius:8px;">
  <h2 style="color:#0b4f6c;margin:0 0 16px;">New User Registration</h2>
  <p style="color:#374151;">A new user has registered on <strong>{{site_name}}</strong>.</p>
  <table style="width:100%;background:#fff;border-radius:6px;margin:16px 0;border-collapse:collapse;">
    <tr><td style="padding:10px 16px;font-size:13px;color:#6b7280;width:120px;">Name</td><td style="padding:10px 16px;font-size:14px;color:#111;">{{name}}</td></tr>
    <tr style="border-top:1px solid #f0f0f0;"><td style="padding:10px 16px;font-size:13px;color:#6b7280;">Email</td><td style="padding:10px 16px;font-size:14px;color:#111;">{{email}}</td></tr>
  </table>
  <a href="{{login_url}}" style="display:inline-block;background:#0b4f6c;color:#fff;font-size:13px;font-weight:600;text-decoration:none;padding:10px 24px;border-radius:4px;">View in Admin →</a>
</div>',
                ],
            ];

            foreach ($templates as $key => $tpl) {
                if (!in_array($key, $existing)) {
                    DB::table('email_templates')->insert(array_merge($tpl, [
                        'key'        => $key,
                        'is_active'  => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]));
                }
            }
        }
    }

    public function down(): void
    {
        // Intentionally left empty — reversing unique index or removing seeded rows
        // would be destructive and is not needed for rollback safety.
    }
};
