<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model {
    protected $fillable = ['ticket_id','user_id','content','is_staff','is_internal'];
    protected $casts = ['is_staff'=>'boolean','is_internal'=>'boolean'];
    public function user() { return $this->belongsTo(User::class); }
    public function ticket() { return $this->belongsTo(Ticket::class); }
}
