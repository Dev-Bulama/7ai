<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model {
    protected $fillable = ['name','title','description','image','link','button_text','position','start_date','end_date','is_active','sort_order'];
    protected $casts = ['start_date' => 'date', 'end_date' => 'date'];
}
