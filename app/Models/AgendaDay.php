<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgendaDay extends Model
{
    protected $fillable = [
        'conference_id',
        'date',
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'order',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(AgendaSession::class)->orderBy('order');
    }
}
