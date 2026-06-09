<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Cta extends Model {
    protected $fillable = ['name','title','text','button_label','button_url','button2_label','button2_url','background_image','background_color','is_active'];
}
