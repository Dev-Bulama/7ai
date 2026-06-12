<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update the /abuja form title and subtitle to match conference branding
        DB::table('forms')
            ->where('public_path', '/abuja')
            ->orWhere('slug', 'abuja')
            ->orWhere('slug', 'abuja-registration')
            ->update([
                'title'    => 'Abuja AI Conference Registration',
                'subtitle' => 'Register for FREE to learn how AI can impact your work, home and organisation',
                'updated_at' => now(),
            ]);
    }

    public function down(): void {}
};
