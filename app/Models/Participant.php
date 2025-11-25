<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participant extends Model
{
    protected $fillable = [
        'conference_id',
        'name',
        'email',
        'phone',
        'company',
        'job_title',
        'type',
        'booth_id',
        'status',
        'approval_token',
        'approved_at',
        'approved_by',
        'admin_notes',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class);
    }

    public function booth(): BelongsTo
    {
        return $this->belongsTo(ExhibitionBooth::class, 'booth_id');
    }

    public function attendances()
    {
        return $this->hasMany(ParticipantAttendance::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Query Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
