<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Publication extends Model
{
    /** @use HasFactory<\Database\Factories\PublicationFactory> */
    use HasFactory;

    protected $fillable = [
        'cv_id',
        'title',
        'publication_type',
        'authors',
        'publication_venue',
        'publication_date',
        'doi',
        'url',
        'description',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'publication_date' => 'date',
        ];
    }

    public function cv(): BelongsTo
    {
        return $this->belongsTo(CV::class, 'cv_id');
    }
}
