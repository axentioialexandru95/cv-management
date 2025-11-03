<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VolunteerExperience>
 */
class VolunteerExperienceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isCurrent = fake()->boolean(25);
        $startDate = fake()->dateTimeBetween('-10 years', '-1 month');
        $endDate = $isCurrent ? null : fake()->dateTimeBetween($startDate, 'now');

        return [
            'cv_id' => \App\Models\CV::factory(),
            'role' => fake()->randomElement([
                'Volunteer Coordinator',
                'Mentor',
                'Event Organizer',
                'Community Outreach Volunteer',
                'Teaching Assistant',
                'Food Bank Volunteer',
                'Environmental Activist',
                'Youth Program Leader',
                'Fundraising Coordinator',
                'Administrative Support Volunteer',
            ]),
            'organization' => fake()->randomElement([
                'Red Cross',
                'Habitat for Humanity',
                'Local Food Bank',
                'YMCA',
                'United Way',
                'Big Brothers Big Sisters',
                'Animal Shelter',
                'Environmental Conservation Society',
                'Community Health Clinic',
                'Public Library',
            ]),
            'city' => fake()->city(),
            'country' => fake()->country(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_current' => $isCurrent,
            'description' => fake()->paragraphs(fake()->numberBetween(1, 3), true),
            'order' => 0,
        ];
    }
}
