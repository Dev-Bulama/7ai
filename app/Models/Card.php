<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Card extends Model {
    protected $fillable = ['title','subtitle','description','icon','image','link','button_text','group','sort_order','is_active'];
}
