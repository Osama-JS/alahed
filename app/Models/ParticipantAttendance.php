<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParticipantAttendance extends Model
{
    protected $fillable = [
        'participant_id',
        'conference_id',
        'attendance_date',
        'check_in_time',
        'checked_in_by',
        'entry_point',
        'notes',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'check_in_time' => 'datetime',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }

    public function checkedInBy()
    {
        return $this->belongsTo(User::class, 'checked_in_by');
    }
}
