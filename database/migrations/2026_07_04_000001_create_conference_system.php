<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ── 1. Add conference columns to form_submissions ──────────────────
        Schema::table('form_submissions', function (Blueprint $table) {
            $table->string('participant_id', 20)->nullable()->unique()->after('is_read');
            $table->string('qr_token', 64)->nullable()->unique()->after('participant_id');
            $table->boolean('attendance_verified')->default(false)->after('qr_token');
            $table->timestamp('checked_in_at')->nullable()->after('attendance_verified');
            $table->unsignedBigInteger('checked_in_by')->nullable()->after('checked_in_at');
            $table->boolean('lunch_collected')->default(false)->after('checked_in_by');
            $table->timestamp('lunch_collected_at')->nullable()->after('lunch_collected');
            $table->unsignedBigInteger('lunch_collected_by')->nullable()->after('lunch_collected_at');
            $table->timestamp('badge_exported_at')->nullable()->after('lunch_collected_by');
        });

        // ── 2. Add is_conference_form to forms ─────────────────────────────
        Schema::table('forms', function (Blueprint $table) {
            $table->boolean('is_conference_form')->default(false)->after('prevent_duplicates');
        });

        // ── 3. conference_settings ─────────────────────────────────────────
        Schema::create('conference_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id')->unique();
            $table->string('event_name')->default('Conference');
            $table->date('event_date')->nullable();
            $table->string('event_venue')->nullable();
            $table->string('participant_id_prefix', 10)->default('CONF');
            $table->boolean('lunch_enabled')->default(true);
            $table->integer('lunch_rounds')->default(1);
            $table->boolean('badge_enabled')->default(true);
            $table->string('badge_bg_color', 7)->default('#0a1628');
            $table->string('badge_accent_color', 7)->default('#3ee07f');
            $table->string('badge_logo_path')->nullable();
            $table->text('qr_generated_at')->nullable();
            $table->timestamps();

            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
        });

        // ── 4. participant_scan_logs ───────────────────────────────────────
        Schema::create('participant_scan_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_submission_id');
            $table->unsignedBigInteger('scanned_by');
            $table->enum('action', ['check_in', 'lunch', 'badge_print', 'manual_verify']);
            $table->string('ip_address')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('scanned_at')->useCurrent();
            $table->timestamps();

            $table->foreign('form_submission_id')->references('id')->on('form_submissions')->onDelete('cascade');
            $table->foreign('scanned_by')->references('id')->on('users')->onDelete('cascade');
        });

        // ── 5. Seed new roles ──────────────────────────────────────────────
        $tableNames = config('permission.table_names');
        $rolesTable = $tableNames['roles'] ?? 'roles';
        $guard = 'web';
        $now = now();

        foreach (['front-desk-staff', 'lunch-staff'] as $role) {
            DB::table($rolesTable)->insertOrIgnore([
                'name'       => $role,
                'guard_name' => $guard,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('participant_scan_logs');
        Schema::dropIfExists('conference_settings');

        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn('is_conference_form');
        });

        Schema::table('form_submissions', function (Blueprint $table) {
            $table->dropColumn([
                'participant_id', 'qr_token', 'attendance_verified',
                'checked_in_at', 'checked_in_by',
                'lunch_collected', 'lunch_collected_at', 'lunch_collected_by',
                'badge_exported_at',
            ]);
        });
    }
};
