<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Speaker extends Model
{
    protected $fillable = [
        'conference_id',
        'name_ar',
        'name_en',
        'title_ar',
        'title_en',
        'bio_ar',
        'bio_en',
        'image',
        'company_ar',
        'company_en',
        'linkedin',
        'twitter',
        'facebook',
        'order',
    ];

    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class);
    }
}
