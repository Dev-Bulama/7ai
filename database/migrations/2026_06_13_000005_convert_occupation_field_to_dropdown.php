<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('forms') || !Schema::hasTable('form_fields')) {
            return;
        }

        $options = implode("\n", [
            'Policy Maker',
            'Government Worker',
            'Business Owner',
            'Employee',
            'Student',
            'Others',
        ]);

        // Find the abuja form (by slug or public_path)
        $form = DB::table('forms')
            ->whereNull('deleted_at')
            ->where(function ($q) {
                $q->where('slug', 'abuja')
                  ->orWhere('public_path', '/abuja');
            })
            ->first();

        if (!$form) {
            return;
        }

        // Update any field in that form whose label or name matches "occupation" / "what do you do"
        DB::table('form_fields')
            ->where('form_id', $form->id)
            ->where(function ($q) {
                $q->whereRaw('LOWER(label) LIKE ?', ['%what do you do%'])
                  ->orWhereRaw('LOWER(label) LIKE ?', ['%occupation%'])
                  ->orWhereRaw('LOWER(name) LIKE ?', ['%occupation%'])
                  ->orWhereRaw('LOWER(name) LIKE ?', ['%what_do%']);
            })
            ->update([
                'field_type' => 'select',
                'options'    => $options,
                'placeholder'=> 'Select Occupation',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        // Intentionally empty — reverting a data migration is manual
    }
};
