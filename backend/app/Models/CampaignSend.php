<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CampaignSend extends Model {
    protected $fillable = [
        'campaign_id','subscriber_id','message_id','status',
        'sent_at','delivered_at','opened_at','open_count','ip_address','user_agent','country','device'
    ];
    protected $casts = ['sent_at'=>'datetime','delivered_at'=>'datetime','opened_at'=>'datetime'];
    public function campaign() { return $this->belongsTo(Campaign::class); }
    public function subscriber() { return $this->belongsTo(Subscriber::class); }
    public function clicks() { return $this->hasMany(CampaignClick::class); }
}
