<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Certification>
 */
class CertificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $issueDate = fake()->dateTimeBetween('-10 years', 'now');
        $hasExpiry = fake()->boolean(40);
        $expiryDate = $hasExpiry ? fake()->dateTimeBetween($issueDate, '+5 years') : null;

        return [
            'cv_id' => \App\Models\CV::factory(),
            'title' => fake()->randomElement([
                'AWS Certified Solutions Architect',
                'Google Cloud Professional',
                'Microsoft Azure Administrator',
                'Certified Scrum Master',
                'PMP - Project Management Professional',
                'CompTIA Security+',
                'CISSP - Certified Information Systems Security Professional',
                'Certified Kubernetes Administrator',
                'Oracle Certified Professional',
                'Salesforce Certified Administrator',
                'HubSpot Inbound Marketing',
                'Google Analytics Individual Qualification',
            ]),
            'issuing_organization' => fake()->randomElement([
                'Amazon Web Services',
                'Google Cloud',
                'Microsoft',
                'Scrum Alliance',
                'Project Management Institute',
                'CompTIA',
                'ISC2',
                'Linux Foundation',
                'Oracle',
                'Salesforce',
                'HubSpot Academy',
                'Google',
            ]),
            'issue_date' => $issueDate,
            'expiry_date' => $expiryDate,
            'credential_id' => fake()->optional(0.7)->regexify('[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}'),
            'credential_url' => fake()->optional(0.5)->url(),
            'description' => fake()->optional(0.4)->sentence(),
            'order' => 0,
        ];
    }
}
