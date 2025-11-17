<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Door extends Model
{
    protected $fillable = [
        'conference_id',
        'name_ar',
        'name_en',
        'location_ar',
        'location_en',
        'order',
    ];

    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class);
    }
}
