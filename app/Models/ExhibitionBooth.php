<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ExhibitionBooth extends Model
{
    protected $fillable = [
        'conference_id',
        'name',
        'slug',
        'type',
        'width',
        'height',
        'area',
        'price',
        'currency',
        'status',
        'participant_id',
        'exhibitor_id',
        'reserved_at',
        'image',
        'description_ar',
        'description_en',
        'notes',
        'order',
    ];

    protected $casts = [
        'width' => 'decimal:2',
        'height' => 'decimal:2',
        'area' => 'decimal:2',
        'price' => 'decimal:2',
        'reserved_at' => 'datetime',
    ];

    // Boot method to auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booth) {
            if (empty($booth->slug)) {
                $booth->slug = Str::slug($booth->name);
            }

            // Auto-calculate area if width and height are provided
            if ($booth->width && $booth->height && !$booth->area) {
                $booth->area = $booth->width * $booth->height;
            }
        });

        static::updating(function ($booth) {
            if ($booth->isDirty('name') && empty($booth->slug)) {
                $booth->slug = Str::slug($booth->name);
            }

            // Auto-calculate area if width and height are provided
            if (($booth->isDirty('width') || $booth->isDirty('height')) && $booth->width && $booth->height) {
                $booth->area = $booth->width * $booth->height;
            }
        });
    }

    // Relationships
    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class);
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    public function exhibitor(): BelongsTo
    {
        return $this->belongsTo(Exhibitor::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeReserved($query)
    {
        return $query->where('status', 'reserved');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2) . ' ' . $this->currency;
    }

    public function getFormattedAreaAttribute()
    {
        return $this->area ? number_format($this->area, 2) . ' م²' : '-';
    }

    public function getFormattedDimensionsAttribute()
    {
        if ($this->width && $this->height) {
            return $this->width . ' × ' . $this->height . ' م';
        }
        return '-';
    }

    public function getTypeNameAttribute()
    {
        $types = [
            'standard' => ['ar' => 'عادي', 'en' => 'Standard'],
            'premium' => ['ar' => 'مميز', 'en' => 'Premium'],
            'strategic' => ['ar' => 'استراتيجي', 'en' => 'Strategic'],
            'main' => ['ar' => 'رئيسي', 'en' => 'Main'],
            'gold' => ['ar' => 'ذهبي', 'en' => 'Gold'],
            'silver' => ['ar' => 'فضي', 'en' => 'Silver'],
        ];

        $locale = app()->getLocale();
        return $types[$this->type][$locale] ?? $this->type;
    }

    public function getStatusNameAttribute()
    {
        $statuses = [
            'available' => ['ar' => 'متاح', 'en' => 'Available'],
            'reserved' => ['ar' => 'محجوز', 'en' => 'Reserved'],
        ];

        $locale = app()->getLocale();
        return $statuses[$this->status][$locale] ?? $this->status;
    }

    // Methods
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isReserved(): bool
    {
        return $this->status === 'reserved';
    }
}

