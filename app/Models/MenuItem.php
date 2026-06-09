<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model {
    protected $fillable = ['menu_id','parent_id','label','type','url','page_id','target','order','icon','is_active'];

    public function menu() { return $this->belongsTo(Menu::class); }
    public function parent() { return $this->belongsTo(MenuItem::class, 'parent_id'); }
    public function children() { return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order'); }
    public function page() { return $this->belongsTo(Page::class); }

    public function getResolvedUrlAttribute(): string {
        if ($this->type === 'page' && $this->page) {
            return url('/' . $this->page->slug);
        }
        return $this->url ?? '#';
    }
}
