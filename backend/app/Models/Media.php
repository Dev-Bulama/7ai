<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Media extends Model {
    protected $fillable = ['user_id','name','file_name','mime_type','disk','path','size','collection','custom_properties','alt_text'];
    protected $casts = ['custom_properties'=>'array'];
    public function user() { return $this->belongsTo(User::class); }
    public function getUrlAttribute(): string { return asset('storage/'.$this->path); }
}
