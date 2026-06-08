<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model {
    protected $fillable = [
        'name','subject','preview_text','content','from_name','from_email','reply_to',
        'type','status','scheduled_at','sent_at','created_by','subscriber_list_id',
        'ai_prompt','ai_goal','ai_tone','ai_audience',
        'total_sent','total_delivered','total_opened','total_clicked','total_bounced','total_unsubscribed'
    ];
    protected $casts = ['scheduled_at'=>'datetime','sent_at'=>'datetime'];
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function subscriberList() { return $this->belongsTo(SubscriberList::class); }
    public function sends() { return $this->hasMany(CampaignSend::class); }
    public function abTests() { return $this->hasMany(AbTest::class); }

    public function getOpenRateAttribute(): float {
        if (!$this->total_sent) return 0;
        return round(($this->total_opened / $this->total_sent) * 100, 1);
    }
    public function getClickRateAttribute(): float {
        if (!$this->total_sent) return 0;
        return round(($this->total_clicked / $this->total_sent) * 100, 1);
    }
}
