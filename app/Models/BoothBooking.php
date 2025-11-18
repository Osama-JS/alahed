<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoothBooking extends Model
{
    protected $fillable = [
        'exhibition_booth_id',
        'name',
        'email',
        'phone',
        'company',
        'website',
        'business_type',
        'notes',
        'status',
    ];

    public function booth(): BelongsTo
    {
        return $this->belongsTo(ExhibitionBooth::class, 'exhibition_booth_id');
    }
}
