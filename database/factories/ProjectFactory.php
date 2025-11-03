<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isOngoing = fake()->boolean(15);
        $startDate = fake()->dateTimeBetween('-5 years', '-1 month');
        $endDate = $isOngoing ? null : fake()->dateTimeBetween($startDate, 'now');

        return [
            'cv_id' => \App\Models\CV::factory(),
            'title' => fake()->randomElement([
                'E-commerce Platform',
                'Mobile Banking Application',
                'Content Management System',
                'Real-time Chat Application',
                'Task Management Tool',
                'Social Media Analytics Dashboard',
                'AI-Powered Recommendation Engine',
                'Inventory Management System',
                'Healthcare Patient Portal',
                'Learning Management System',
            ]),
            'description' => fake()->paragraphs(fake()->numberBetween(2, 3), true),
            'role' => fake()->randomElement([
                'Lead Developer',
                'Full Stack Developer',
                'Backend Developer',
                'Frontend Developer',
                'Technical Lead',
                'Project Manager',
                'Software Architect',
                'Team Lead',
            ]),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_ongoing' => $isOngoing,
            'url' => fake()->optional(0.4)->url(),
            'technologies' => fake()->randomElement([
                ['Laravel', 'Vue.js', 'MySQL', 'Docker'],
                ['React', 'Node.js', 'PostgreSQL', 'AWS'],
                ['Python', 'Django', 'Redis', 'Kubernetes'],
                ['PHP', 'JavaScript', 'MongoDB', 'Azure'],
                ['Java', 'Spring Boot', 'Oracle', 'Jenkins'],
            ]),
            'order' => 0,
        ];
    }
}
