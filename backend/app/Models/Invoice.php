<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {
    protected $fillable = [
        'invoice_number','user_id','project_id','subtotal','tax','discount','total',
        'currency','status','due_date','paid_at','notes'
    ];
    protected $casts = ['due_date'=>'date','paid_at'=>'datetime'];
    public function user() { return $this->belongsTo(User::class); }
    public function project() { return $this->belongsTo(Project::class); }
    public function items() { return $this->hasMany(InvoiceItem::class); }
}
