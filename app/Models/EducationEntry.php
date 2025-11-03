<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EducationEntry extends Model
{
    /** @use HasFactory<\Database\Factories\EducationEntryFactory> */
    use HasFactory;

    protected $fillable = [
        'cv_id',
        'qualification',
        'institution',
        'city',
        'country',
        'field_of_study',
        'start_date',
        'end_date',
        'is_current',
        'grade',
        'eqf_level',
        'description',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_current' => 'boolean',
            'eqf_level' => 'integer',
        ];
    }

    public function cv(): BelongsTo
    {
        return $this->belongsTo(CV::class, 'cv_id');
    }
}
