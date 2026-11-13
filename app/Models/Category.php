<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(CategoryTranslation::class);
    }

    public function currentTranslation(?string $locale = null): ?CategoryTranslation
    {
        $locale ??= app()->getLocale();

        return $this->translations()->where('locale', $locale)->first()
            ?? $this->translations()->where('locale', 'en')->first();
    }

    public function getLocalizedNameAttribute(): string
    {
        return $this->currentTranslation()?->name ?? $this->name;
    }

    public function getLocalizedDescriptionAttribute(): ?string
    {
        return $this->currentTranslation()?->description ?? $this->description;
    }
}
