<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publication>
 */
class PublicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cv_id' => \App\Models\CV::factory(),
            'title' => fake()->sentence(fake()->numberBetween(5, 12)),
            'publication_type' => fake()->randomElement([
                'Journal Article',
                'Conference Paper',
                'Book Chapter',
                'Technical Report',
                'White Paper',
                'Magazine Article',
                'Blog Post',
                'Research Paper',
            ]),
            'authors' => fake()->name().', '.fake()->name().', '.fake()->name(),
            'publication_venue' => fake()->randomElement([
                'IEEE Transactions on Software Engineering',
                'ACM Computing Surveys',
                'Journal of Systems and Software',
                'International Conference on Software Engineering',
                'Communications of the ACM',
                'Science Magazine',
                'Nature',
                'Computer Science Review',
            ]),
            'publication_date' => fake()->dateTimeBetween('-10 years', 'now'),
            'doi' => fake()->optional(0.6)->regexify('10\.\d{4}/[a-z0-9]+'),
            'url' => fake()->optional(0.7)->url(),
            'description' => fake()->optional(0.5)->paragraph(),
            'order' => 0,
        ];
    }
}
