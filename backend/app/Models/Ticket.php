<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model {
    protected $fillable = [
        'ticket_number','user_id','guest_name','guest_email','subject','description',
        'priority','status','category','assigned_to','resolved_at','first_response_at'
    ];
    protected $casts = ['resolved_at'=>'datetime','first_response_at'=>'datetime'];
    public function user() { return $this->belongsTo(User::class); }
    public function replies() { return $this->hasMany(TicketReply::class); }
    public function assignedTo() { return $this->belongsTo(User::class, 'assigned_to'); }
    protected static function booted() {
        static::creating(fn($t) => $t->ticket_number = 'TKT-'.strtoupper(uniqid()));
    }
}
