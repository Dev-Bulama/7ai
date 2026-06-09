<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SitePopup extends Model {
    protected $fillable = ['name','image_path','link_url','link_text','show_times','is_active','start_date','end_date'];
    protected $casts = ['is_active' => 'boolean', 'start_date' => 'date', 'end_date' => 'date'];
}
