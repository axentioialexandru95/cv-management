<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EducationEntry>
 */
class EducationEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isCurrent = fake()->boolean(10);
        $startDate = fake()->dateTimeBetween('-20 years', '-2 years');
        $endDate = $isCurrent ? null : fake()->dateTimeBetween($startDate, 'now');

        return [
            'cv_id' => \App\Models\CV::factory(),
            'qualification' => fake()->randomElement([
                'Bachelor of Science',
                'Master of Science',
                'Bachelor of Arts',
                'Master of Arts',
                'Bachelor of Engineering',
                'Master of Business Administration',
                'Doctor of Philosophy',
                'Associate Degree',
                'High School Diploma',
            ]),
            'institution' => fake()->randomElement([
                'Stanford University',
                'Massachusetts Institute of Technology',
                'University of Oxford',
                'Harvard University',
                'Cambridge University',
                'ETH Zurich',
                'University of California, Berkeley',
                'Imperial College London',
                'National University of Singapore',
                'Technical University of Munich',
            ]),
            'city' => fake()->city(),
            'country' => fake()->country(),
            'field_of_study' => fake()->randomElement([
                'Computer Science',
                'Business Administration',
                'Electrical Engineering',
                'Mechanical Engineering',
                'Economics',
                'Psychology',
                'Biology',
                'Mathematics',
                'Physics',
                'Chemistry',
                'Marketing',
                'Finance',
            ]),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_current' => $isCurrent,
            'grade' => fake()->randomElement([
                '3.8 GPA',
                '3.9 GPA',
                'First Class Honours',
                'Summa Cum Laude',
                'Magna Cum Laude',
                'Distinction',
                null,
            ]),
            'eqf_level' => fake()->numberBetween(4, 8),
            'description' => fake()->optional(0.6)->paragraphs(2, true),
            'order' => 0,
        ];
    }
}
