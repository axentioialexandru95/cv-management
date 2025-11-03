<?php

namespace App\Enums;

enum CVTemplate: string
{
    case EUROPASS = 'europass';
    case MODERN = 'modern';
    case CLASSIC = 'classic';
    case MINIMALIST = 'minimalist';

    public function label(): string
    {
        return match ($this) {
            self::EUROPASS => 'Europass',
            self::MODERN => 'Modern',
            self::CLASSIC => 'Classic',
            self::MINIMALIST => 'Minimalist',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::EUROPASS => 'Official EU CV format with comprehensive sections and blue accents',
            self::MODERN => 'Contemporary design with sidebar layout, clean typography, and visual flair',
            self::CLASSIC => 'Traditional single-column layout with serif fonts and understated styling',
            self::MINIMALIST => 'Ultra-clean minimal design focusing on content with subtle styling',
        };
    }

    public function viewPath(): string
    {
        return "cv.templates.{$this->value}";
    }

    public function defaultColor(): string
    {
        return match ($this) {
            self::EUROPASS => '#2563eb',   // blue-600
            self::MODERN => '#6366f1',     // indigo-600
            self::CLASSIC => '#374151',    // gray-700
            self::MINIMALIST => '#475569', // slate-600
        };
    }

    public function defaultSections(): array
    {
        return match ($this) {
            self::EUROPASS => [
                'personal_info' => true,
                'about_me' => true,
                'work_experience' => true,
                'education' => true,
                'languages' => true,
                'skills' => true,
                'certifications' => true,
                'projects' => true,
                'publications' => true,
                'volunteer' => true,
            ],
            self::MODERN => [
                'personal_info' => true,
                'about_me' => true,
                'work_experience' => true,
                'education' => true,
                'skills' => true,
                'certifications' => false,
                'projects' => true,
                'publications' => false,
                'volunteer' => false,
                'languages' => true,
            ],
            self::CLASSIC => [
                'personal_info' => true,
                'about_me' => true,
                'work_experience' => true,
                'education' => true,
                'skills' => true,
                'certifications' => true,
                'projects' => false,
                'publications' => true,
                'volunteer' => false,
                'languages' => true,
            ],
            self::MINIMALIST => [
                'personal_info' => true,
                'about_me' => false,
                'work_experience' => true,
                'education' => true,
                'skills' => true,
                'certifications' => false,
                'projects' => true,
                'publications' => false,
                'volunteer' => false,
                'languages' => false,
            ],
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
