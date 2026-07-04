<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConferenceSetting extends Model
{
    protected $fillable = [
        'form_id', 'event_name', 'event_date', 'event_venue',
        'participant_id_prefix', 'lunch_enabled', 'lunch_rounds',
        'badge_enabled', 'badge_bg_color', 'badge_accent_color',
        'badge_logo_path', 'qr_generated_at',
    ];

    protected $casts = [
        'event_date'      => 'date',
        'lunch_enabled'   => 'boolean',
        'badge_enabled'   => 'boolean',
        'lunch_rounds'    => 'integer',
        'qr_generated_at' => 'datetime',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
