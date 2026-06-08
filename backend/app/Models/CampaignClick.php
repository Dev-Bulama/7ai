<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CampaignClick extends Model {
    protected $fillable = ['campaign_send_id','url','ip_address','country','device','clicked_at'];
    protected $casts = ['clicked_at'=>'datetime'];
    public function send() { return $this->belongsTo(CampaignSend::class, 'campaign_send_id'); }
}
