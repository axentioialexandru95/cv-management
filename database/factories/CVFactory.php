<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CV>
 */
class CVFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();

        return [
            'user_id' => \App\Models\User::factory(),
            'title' => fake()->randomElement([
                'Software Engineer',
                'Senior Developer',
                'Project Manager',
                'Data Scientist',
                'Marketing Specialist',
                'Financial Analyst',
                'Product Designer',
                'Business Analyst',
            ]),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'postal_code' => fake()->postcode(),
            'country' => fake()->country(),
            'nationality' => fake()->country(),
            'date_of_birth' => fake()->dateTimeBetween('-65 years', '-22 years'),
            'linkedin_url' => 'https://linkedin.com/in/'.strtolower($firstName).'-'.strtolower($lastName),
            'website_url' => fake()->boolean(30) ? 'https://'.strtolower($firstName).strtolower($lastName).'.com' : null,
            'profile_photo_path' => null,
            'about_me' => fake()->paragraphs(3, true),
            'driving_licenses' => fake()->randomElement([
                ['B'],
                ['B', 'C'],
                [],
                ['A', 'B'],
            ]),
            'is_active' => fake()->boolean(90),
        ];
    }
}
