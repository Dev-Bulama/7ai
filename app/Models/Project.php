<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Project extends Model {
    protected $fillable = [
        'client_id','name','description','type','status','start_date','end_date',
        'budget','location','devices'
    ];
    protected $casts = ['devices'=>'array','start_date'=>'date','end_date'=>'date'];
    public function client() { return $this->belongsTo(User::class, 'client_id'); }
    public function invoices() { return $this->hasMany(Invoice::class); }
}
