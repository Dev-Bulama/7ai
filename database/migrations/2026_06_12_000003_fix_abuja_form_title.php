<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('forms')
            ->where('public_path', '/abuja')
            ->update([
                'name'       => 'Abuja AI Conference Registration',
                'title'      => 'Abuja AI Conference Registration',
                'updated_at' => now(),
            ]);
    }

    public function down(): void {}
};
