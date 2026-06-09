<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Form extends Model {
    protected $fillable = ['name','slug','public_path','title','subtitle','bg_color','description','success_message','redirect_url','notification_email','store_submissions','is_active'];

    public function fields() { return $this->hasMany(FormField::class)->orderBy('sort_order'); }
    public function submissions() { return $this->hasMany(FormSubmission::class); }

    protected static function boot() {
        parent::boot();
        static::creating(fn($m) => $m->slug = $m->slug ?: Str::slug($m->name));
    }
}
