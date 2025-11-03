<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certification extends Model
{
    /** @use HasFactory<\Database\Factories\CertificationFactory> */
    use HasFactory;

    protected $fillable = [
        'cv_id',
        'title',
        'issuing_organization',
        'issue_date',
        'expiry_date',
        'credential_id',
        'credential_url',
        'description',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'expiry_date' => 'date',
        ];
    }

    public function cv(): BelongsTo
    {
        return $this->belongsTo(CV::class, 'cv_id');
    }
}
