<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['cards', 'services', 'faqs', 'menu_items'];
        foreach ($tables as $table) {
            if (Schema::hasColumn($table, 'icon')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->text('icon')->nullable()->change();
                });
            }
        }
    }

    public function down(): void
    {
        $tables = ['cards', 'services', 'faqs', 'menu_items'];
        foreach ($tables as $table) {
            if (Schema::hasColumn($table, 'icon')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->string('icon')->nullable()->change();
                });
            }
        }
    }
};
