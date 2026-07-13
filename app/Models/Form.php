<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Form extends Model {
    use SoftDeletes;
    protected $fillable = ['name','slug','public_path','title','subtitle','bg_color','description','success_message','redirect_url','notification_email','store_submissions','is_active','welcome_email_enabled','welcome_email_subject','welcome_email_body','welcome_email_from_name','welcome_email_from_address','welcome_email_field','payment_enabled','payment_amount','payment_currency','payment_description','prevent_duplicates','duplicate_check_fields','is_conference_form','discount_enabled','discount_percent','discount_check_form_id','discount_email_subject','discount_email_body','discount_email_from_name','discount_email_from_address'];

    protected $casts = ['welcome_email_enabled' => 'boolean', 'store_submissions' => 'boolean', 'is_active' => 'boolean', 'payment_enabled' => 'boolean', 'prevent_duplicates' => 'boolean', 'payment_amount' => 'decimal:2', 'is_conference_form' => 'boolean', 'discount_enabled' => 'boolean', 'discount_percent' => 'decimal:2'];

    public function fields() { return $this->hasMany(FormField::class)->orderBy('sort_order'); }
    public function submissions() { return $this->hasMany(FormSubmission::class); }
    public function discountCheckForm() { return $this->belongsTo(Form::class, 'discount_check_form_id'); }

    protected static function boot() {
        parent::boot();
        static::creating(fn($m) => $m->slug = $m->slug ?: Str::slug($m->name));
    }
}
