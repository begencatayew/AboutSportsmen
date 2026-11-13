<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fact extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'title',
        'description',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(FactTranslation::class);
    }

    public function currentTranslation(?string $locale = null): ?FactTranslation
    {
        $locale ??= app()->getLocale();

        return $this->translations()->where('locale', $locale)->first()
            ?? $this->translations()->where('locale', 'en')->first();
    }

    public function getLocalizedTitleAttribute(): string
    {
        return $this->currentTranslation()?->title ?? $this->title;
    }

    public function getLocalizedDescriptionAttribute(): string
    {
        return $this->currentTranslation()?->description ?? $this->description;
    }
}
