<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model {
    protected $fillable = ['form_id','label','name','field_type','placeholder','help_text','is_required','options','validation_rules','default_value','sort_order','is_active'];

    public function getOptionsArrayAttribute() {
        if (!$this->options) return [];
        $decoded = json_decode($this->options, true);
        return is_array($decoded) ? $decoded : array_filter(array_map('trim', explode("\n", $this->options)));
    }
}
