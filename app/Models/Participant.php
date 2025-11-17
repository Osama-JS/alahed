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
    ];

    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class);
    }

    public function booth(): BelongsTo
    {
        return $this->belongsTo(ExhibitionBooth::class, 'booth_id');
    }
}
