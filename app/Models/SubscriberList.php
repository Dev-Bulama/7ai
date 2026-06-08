<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SubscriberList extends Model {
    protected $fillable = ['name','description','subscriber_count'];
    public function subscribers() { return $this->belongsToMany(Subscriber::class, 'subscriber_list'); }
    public function campaigns() { return $this->hasMany(Campaign::class); }
}
