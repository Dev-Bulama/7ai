<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model {
    use HasFactory;
    protected $fillable = [
        'title','slug','excerpt','content','featured_image','author_id','category_id',
        'status','published_at','meta_title','meta_description','read_time','views','featured','allow_comments'
    ];
    protected $casts = ['published_at'=>'datetime','featured'=>'boolean','allow_comments'=>'boolean'];

    public function author() { return $this->belongsTo(User::class, 'author_id'); }
    public function category() { return $this->belongsTo(Category::class); }
    public function tags() { return $this->belongsToMany(Tag::class); }
    public function comments() { return $this->hasMany(Comment::class); }
    public function scopePublished($q) { return $q->where('status','published')->where('published_at','<=',now()); }
}
