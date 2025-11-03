<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed languages first
        $this->call(LanguageSeeder::class);

        // Create a test user
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create 3 complete CVs for the test user
        for ($i = 1; $i <= 3; $i++) {
            $cv = \App\Models\CV::factory()
                ->for($user)
                ->create([
                    'title' => 'CV #'.$i,
                    'is_active' => $i === 1, // Only first CV is active
                ]);

            // Add work experiences (2-4 entries)
            \App\Models\WorkExperience::factory()
                ->count(fake()->numberBetween(2, 4))
                ->for($cv)
                ->create();

            // Add education entries (1-3 entries)
            \App\Models\EducationEntry::factory()
                ->count(fake()->numberBetween(1, 3))
                ->for($cv)
                ->create();

            // Add skills (5-10 entries)
            \App\Models\Skill::factory()
                ->count(fake()->numberBetween(5, 10))
                ->for($cv)
                ->create();

            // Add certifications (0-3 entries)
            \App\Models\Certification::factory()
                ->count(fake()->numberBetween(0, 3))
                ->for($cv)
                ->create();

            // Add projects (1-4 entries)
            \App\Models\Project::factory()
                ->count(fake()->numberBetween(1, 4))
                ->for($cv)
                ->create();

            // Add publications (0-2 entries)
            \App\Models\Publication::factory()
                ->count(fake()->numberBetween(0, 2))
                ->for($cv)
                ->create();

            // Add volunteer experiences (0-2 entries)
            \App\Models\VolunteerExperience::factory()
                ->count(fake()->numberBetween(0, 2))
                ->for($cv)
                ->create();

            // Attach 2-4 languages with pivot data
            $languages = \App\Models\Language::inRandomOrder()->limit(fake()->numberBetween(2, 4))->get();

            foreach ($languages as $index => $language) {
                $isNative = $index === 0 && fake()->boolean(30);

                $cv->languages()->attach($language->id, [
                    'listening' => $isNative ? null : fake()->randomElement(['A1', 'A2', 'B1', 'B2', 'C1', 'C2']),
                    'reading' => $isNative ? null : fake()->randomElement(['A1', 'A2', 'B1', 'B2', 'C1', 'C2']),
                    'spoken_interaction' => $isNative ? null : fake()->randomElement(['A1', 'A2', 'B1', 'B2', 'C1', 'C2']),
                    'spoken_production' => $isNative ? null : fake()->randomElement(['A1', 'A2', 'B1', 'B2', 'C1', 'C2']),
                    'writing' => $isNative ? null : fake()->randomElement(['A1', 'A2', 'B1', 'B2', 'C1', 'C2']),
                    'is_native' => $isNative,
                    'certificates' => fake()->optional(0.4)->sentence(),
                    'order' => $index,
                ]);
            }
        }
    }
}
