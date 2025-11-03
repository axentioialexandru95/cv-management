<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CV extends Model
{
    /** @use HasFactory<\Database\Factories\CVFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cvs';

    protected $fillable = [
        'user_id',
        'title',
        'template_id',
        'accent_color',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'postal_code',
        'country',
        'nationality',
        'date_of_birth',
        'linkedin_url',
        'website_url',
        'profile_photo_path',
        'about_me',
        'driving_licenses',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'driving_licenses' => 'array',
            'is_active' => 'boolean',
            'template_id' => \App\Enums\CVTemplate::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function workExperiences(): HasMany
    {
        return $this->hasMany(WorkExperience::class, 'cv_id')->orderBy('order');
    }

    public function educationEntries(): HasMany
    {
        return $this->hasMany(EducationEntry::class, 'cv_id')->orderBy('order');
    }

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'cv_language', 'cv_id', 'language_id')
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
            ->withTimestamps()
            ->orderBy('order');
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class, 'cv_id')->orderBy('order');
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class, 'cv_id')->orderBy('order');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'cv_id')->orderBy('order');
    }

    public function publications(): HasMany
    {
        return $this->hasMany(Publication::class, 'cv_id')->orderBy('order');
    }

    public function volunteerExperiences(): HasMany
    {
        return $this->hasMany(VolunteerExperience::class, 'cv_id')->orderBy('order');
    }
}
