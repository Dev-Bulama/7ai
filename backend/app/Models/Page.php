<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Page extends Model {
    protected $fillable = [
        'title','slug','content','meta_title','meta_description','og_image',
        'schema_markup','template','status','published_at','created_by','sections'
    ];
    protected $casts = ['sections'=>'array','schema_markup'=>'array','published_at'=>'datetime'];
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}
