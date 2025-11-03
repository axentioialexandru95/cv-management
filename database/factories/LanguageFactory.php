<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Language>
 */
class LanguageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'English',
                'Spanish',
                'French',
                'German',
                'Italian',
                'Portuguese',
                'Russian',
                'Chinese',
                'Japanese',
                'Korean',
                'Arabic',
                'Dutch',
                'Swedish',
                'Polish',
                'Turkish',
            ]),
            'code' => fake()->randomElement(['en', 'es', 'fr', 'de', 'it', 'pt', 'ru', 'zh', 'ja', 'ko', 'ar', 'nl', 'sv', 'pl', 'tr']),
        ];
    }
}
