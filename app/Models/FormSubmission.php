<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model {
    protected $fillable = ['form_id','ip_address','user_agent','data','is_read'];
    protected $casts = ['data' => 'array'];

    public function form() { return $this->belongsTo(Form::class); }
}
