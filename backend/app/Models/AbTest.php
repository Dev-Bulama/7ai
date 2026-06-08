<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AbTest extends Model {
    protected $fillable = ['campaign_id','variant_name','subject','preview_text','content','send_percentage','total_sent','total_opened','total_clicked','is_winner'];
    protected $casts = ['is_winner'=>'boolean'];
    public function campaign() { return $this->belongsTo(Campaign::class); }
}
