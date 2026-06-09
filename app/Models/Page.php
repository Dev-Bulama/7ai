<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model {
    protected $fillable = [
        'title','slug','content','meta_title','meta_description','og_image',
        'schema_markup','template','status','published_at','created_by','sections',
        'parent_id','page_type','featured_image','hero_title','hero_subtitle',
        'hero_description','cta_text','cta_link','seo_keywords','sort_order'
    ];
    protected $casts = ['sections'=>'array','schema_markup'=>'array','published_at'=>'datetime'];

    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function parent() { return $this->belongsTo(Page::class, 'parent_id'); }
    public function children() { return $this->hasMany(Page::class, 'parent_id'); }
    public function pageSections() { return $this->hasMany(PageSection::class)->orderBy('sort_order'); }

    protected static function boot() {
        parent::boot();
        static::creating(function($m) {
            if (!$m->slug) $m->slug = Str::slug($m->title);
        });
    }
}
