<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VolunteerExperience extends Model
{
    /** @use HasFactory<\Database\Factories\VolunteerExperienceFactory> */
    use HasFactory;

    protected $fillable = [
        'cv_id',
        'role',
        'organization',
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
