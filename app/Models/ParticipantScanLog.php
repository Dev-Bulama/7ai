<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParticipantScanLog extends Model
{
    protected $fillable = [
        'form_submission_id', 'scanned_by', 'action', 'ip_address', 'notes', 'scanned_at',
    ];

    protected $casts = ['scanned_at' => 'datetime'];

    public function submission()
    {
        return $this->belongsTo(FormSubmission::class, 'form_submission_id');
    }

    public function scanner()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }
}
