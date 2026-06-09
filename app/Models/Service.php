<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model {
    protected $fillable = ['title','slug','short_description','full_description','category_id','featured_image','icon','price','cta_text','cta_link','meta_title','meta_description','status','sort_order'];

    public function category() { return $this->belongsTo(ServiceCategory::class, 'category_id'); }

    protected static function boot() {
        parent::boot();
        static::creating(fn($m) => $m->slug = $m->slug ?: Str::slug($m->title));
    }
}
