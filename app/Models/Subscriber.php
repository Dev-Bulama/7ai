<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model {
    protected $fillable = [
        'email','first_name','last_name','phone','country','tags','custom_fields',
        'status','source','subscribed_at','unsubscribed_at'
    ];
    protected $casts = ['tags'=>'array','custom_fields'=>'array','subscribed_at'=>'datetime','unsubscribed_at'=>'datetime'];
    public function lists() { return $this->belongsToMany(SubscriberList::class, 'subscriber_list'); }
}
