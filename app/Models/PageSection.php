<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PageSection extends Model {
    protected $fillable = ['page_id','title','subtitle','description','section_type','image','background_color','background_image','button_text','button_link','button2_text','button2_link','css_class','custom_html','data','sort_order','is_active'];
    protected $casts = ['data' => 'array'];

    public function page() { return $this->belongsTo(Page::class); }
}
