<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skill>
 */
class SkillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $skillsByCategory = [
            'Programming Languages' => ['PHP', 'JavaScript', 'Python', 'Java', 'C++', 'Ruby', 'Go', 'TypeScript', 'Swift', 'Kotlin'],
            'Frameworks' => ['Laravel', 'React', 'Vue.js', 'Angular', 'Django', 'Spring Boot', 'Express.js', 'Next.js', 'Symfony'],
            'Tools & Technologies' => ['Docker', 'Kubernetes', 'Git', 'AWS', 'Azure', 'Jenkins', 'Terraform', 'Redis', 'RabbitMQ'],
            'Databases' => ['MySQL', 'PostgreSQL', 'MongoDB', 'Redis', 'Oracle', 'SQL Server', 'DynamoDB', 'Cassandra'],
            'Soft Skills' => ['Leadership', 'Communication', 'Problem Solving', 'Team Collaboration', 'Project Management', 'Critical Thinking'],
            'Design' => ['Figma', 'Adobe XD', 'Sketch', 'InVision', 'UI/UX Design', 'Responsive Design', 'Prototyping'],
            'Marketing' => ['SEO', 'Content Marketing', 'Social Media Marketing', 'Email Marketing', 'Google Analytics', 'PPC Campaigns'],
        ];

        $category = fake()->randomElement(array_keys($skillsByCategory));
        $skills = $skillsByCategory[$category];

        return [
            'cv_id' => \App\Models\CV::factory(),
            'name' => fake()->randomElement($skills),
            'category' => $category,
            'proficiency_level' => fake()->randomElement(['Beginner', 'Intermediate', 'Advanced', 'Expert']),
            'description' => fake()->optional(0.3)->sentence(),
            'order' => 0,
        ];
    }
}
