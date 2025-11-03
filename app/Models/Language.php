<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Language extends Model
{
    /** @use HasFactory<\Database\Factories\LanguageFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
    ];

    public function cvs(): BelongsToMany
    {
        return $this->belongsToMany(CV::class, 'cv_language', 'language_id', 'cv_id')
            ->withPivot([
                'listening',
                'reading',
                'spoken_interaction',
                'spoken_production',
                'writing',
                'is_native',
                'certificates',
                'order',
            ])
            ->withTimestamps();
    }
}
