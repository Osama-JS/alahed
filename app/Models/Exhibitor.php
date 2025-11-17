<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Exhibitor extends Model
{
    protected $fillable = [
        'conference_id',
        'name_ar',
        'name_en',
        'summary_ar',
        'summary_en',
        'description_ar',
        'description_en',
        'logo',
        'website',
        'booth_number',
        'order',
    ];

    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class);
    }

    public function booth(): HasOne
    {
        return $this->hasOne(ExhibitionBooth::class);
    }
}
