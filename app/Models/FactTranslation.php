<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FactTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'fact_id',
        'locale',
        'title',
        'description',
    ];

    public function fact(): BelongsTo
    {
        return $this->belongsTo(Fact::class);
    }
}
