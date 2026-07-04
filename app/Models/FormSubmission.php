<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model {
    protected $fillable = [
        'form_id','ip_address','user_agent','data','is_read',
        'participant_id','qr_token','attendance_verified',
        'checked_in_at','checked_in_by',
        'lunch_collected','lunch_collected_at','lunch_collected_by',
        'badge_exported_at',
    ];

    protected $casts = [
        'data'                => 'array',
        'attendance_verified' => 'boolean',
        'lunch_collected'     => 'boolean',
        'checked_in_at'       => 'datetime',
        'lunch_collected_at'  => 'datetime',
        'badge_exported_at'   => 'datetime',
    ];

    public function form() { return $this->belongsTo(Form::class); }
    public function checkedInBy() { return $this->belongsTo(User::class, 'checked_in_by'); }
    public function lunchCollectedBy() { return $this->belongsTo(User::class, 'lunch_collected_by'); }
    public function scanLogs() { return $this->hasMany(ParticipantScanLog::class); }
}
