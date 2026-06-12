<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Form extends Model {
    protected $fillable = ['name','slug','public_path','title','subtitle','bg_color','description','success_message','redirect_url','notification_email','store_submissions','is_active','welcome_email_enabled','welcome_email_subject','welcome_email_body','welcome_email_from_name','welcome_email_from_address','welcome_email_field'];

    protected $casts = ['welcome_email_enabled' => 'boolean', 'store_submissions' => 'boolean', 'is_active' => 'boolean'];

    public function fields() { return $this->hasMany(FormField::class)->orderBy('sort_order'); }
    public function submissions() { return $this->hasMany(FormSubmission::class); }

    protected static function boot() {
        parent::boot();
        static::creating(fn($m) => $m->slug = $m->slug ?: Str::slug($m->name));
    }
}
