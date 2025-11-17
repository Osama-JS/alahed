<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgendaSession extends Model
{
    protected $fillable = [
        'agenda_day_id',
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'stage_ar',
        'stage_en',
        'start_time',
        'end_time',
        'order',
    ];

    public function agendaDay(): BelongsTo
    {
        return $this->belongsTo(AgendaDay::class);
    }
}
