<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conference extends Model
{
    protected $fillable = [
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location_ar',
        'location_en',
        'map_url',
        'hero_video_url',
        'hero_image',
        'logo',
        'floor_plan_image',
        'is_active',
        'order',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function speakers(): HasMany
    {
        return $this->hasMany(Speaker::class)->orderBy('order');
    }

    public function sponsors(): HasMany
    {
        return $this->hasMany(Sponsor::class)->orderBy('order');
    }

    public function statistics(): HasMany
    {
        return $this->hasMany(Statistic::class)->orderBy('order');
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function agendaDays(): HasMany
    {
        return $this->hasMany(AgendaDay::class)->orderBy('order');
    }

    public function doors(): HasMany
    {
        return $this->hasMany(Door::class)->orderBy('order');
    }

    public function exhibitors(): HasMany
    {
        return $this->hasMany(Exhibitor::class)->orderBy('order');
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class)->orderBy('order');
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class)->orderBy('order');
    }

    public function booths(): HasMany
    {
        return $this->hasMany(ExhibitionBooth::class)->orderBy('order');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }
}
