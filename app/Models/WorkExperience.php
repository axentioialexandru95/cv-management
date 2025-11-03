<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkExperience extends Model
{
    /** @use HasFactory<\Database\Factories\WorkExperienceFactory> */
    use HasFactory;

    protected $fillable = [
        'cv_id',
        'job_title',
        'employer',
        'city',
        'country',
        'start_date',
        'end_date',
        'is_current',
        'description',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_current' => 'boolean',
        ];
    }

    public function cv(): BelongsTo
    {
        return $this->belongsTo(CV::class, 'cv_id');
    }
}
