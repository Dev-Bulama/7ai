<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ServiceCategory extends Model {
    protected $fillable = ['name','slug','description','icon','image','parent_id','sort_order','is_active'];

    public function parent() { return $this->belongsTo(ServiceCategory::class, 'parent_id'); }
    public function children() { return $this->hasMany(ServiceCategory::class, 'parent_id'); }
    public function services() { return $this->hasMany(Service::class, 'category_id'); }

    protected static function boot() {
        parent::boot();
        static::creating(fn($m) => $m->slug = $m->slug ?: Str::slug($m->name));
    }
}
