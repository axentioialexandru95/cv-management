<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkExperience>
 */
class WorkExperienceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isCurrent = fake()->boolean(20);
        $startDate = fake()->dateTimeBetween('-15 years', '-1 year');
        $endDate = $isCurrent ? null : fake()->dateTimeBetween($startDate, 'now');

        return [
            'cv_id' => \App\Models\CV::factory(),
            'job_title' => fake()->randomElement([
                'Software Engineer',
                'Senior Frontend Developer',
                'Backend Developer',
                'Full Stack Developer',
                'DevOps Engineer',
                'Project Manager',
                'Product Manager',
                'UX/UI Designer',
                'Data Analyst',
                'Marketing Manager',
                'Sales Representative',
                'Customer Success Manager',
                'Business Analyst',
                'QA Engineer',
                'System Administrator',
            ]),
            'employer' => fake()->company(),
            'city' => fake()->city(),
            'country' => fake()->country(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_current' => $isCurrent,
            'description' => fake()->paragraphs(fake()->numberBetween(2, 4), true),
            'order' => 0,
        ];
    }
}
