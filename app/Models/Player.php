<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'team',
        'position',
        'nationality',
        'date_of_birth',
        'height',
        'weight',
        'jersey_number',
        'image',
        'biography',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'height' => 'float',
        'weight' => 'float',
        'jersey_number' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function facts(): HasMany
    {
        return $this->hasMany(Fact::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(PlayerTranslation::class);
    }

    public function currentTranslation(?string $locale = null): ?PlayerTranslation
    {
        $locale ??= app()->getLocale();

        return $this->translations()->where('locale', $locale)->first()
            ?? $this->translations()->where('locale', 'en')->first();
    }

    public function getLocalizedNameAttribute(): string
    {
        return $this->currentTranslation()?->name ?? $this->name;
    }

    public function getLocalizedTeamAttribute(): string
    {
        return $this->currentTranslation()?->team ?? $this->team;
    }

    public function getLocalizedPositionAttribute(): string
    {
        return $this->currentTranslation()?->position ?? $this->position;
    }

    public function getLocalizedNationalityAttribute(): string
    {
        return $this->currentTranslation()?->nationality ?? $this->nationality;
    }

    public function getLocalizedBiographyAttribute(): ?string
    {
        return $this->currentTranslation()?->biography ?? $this->biography;
    }
}
