<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model {
    protected $fillable = [
        'first_name','last_name','email','phone','company','country','message',
        'service_interest','status','source','ip_address','assigned_to','notes'
    ];
    public function assignedTo() { return $this->belongsTo(User::class, 'assigned_to'); }
}
