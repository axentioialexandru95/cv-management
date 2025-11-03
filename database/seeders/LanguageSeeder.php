<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            ['name' => 'English', 'code' => 'en'],
            ['name' => 'Spanish', 'code' => 'es'],
            ['name' => 'French', 'code' => 'fr'],
            ['name' => 'German', 'code' => 'de'],
            ['name' => 'Italian', 'code' => 'it'],
            ['name' => 'Portuguese', 'code' => 'pt'],
            ['name' => 'Dutch', 'code' => 'nl'],
            ['name' => 'Polish', 'code' => 'pl'],
            ['name' => 'Romanian', 'code' => 'ro'],
            ['name' => 'Czech', 'code' => 'cs'],
            ['name' => 'Greek', 'code' => 'el'],
            ['name' => 'Hungarian', 'code' => 'hu'],
            ['name' => 'Swedish', 'code' => 'sv'],
            ['name' => 'Danish', 'code' => 'da'],
            ['name' => 'Finnish', 'code' => 'fi'],
            ['name' => 'Slovak', 'code' => 'sk'],
            ['name' => 'Bulgarian', 'code' => 'bg'],
            ['name' => 'Croatian', 'code' => 'hr'],
            ['name' => 'Lithuanian', 'code' => 'lt'],
            ['name' => 'Slovenian', 'code' => 'sl'],
            ['name' => 'Latvian', 'code' => 'lv'],
            ['name' => 'Estonian', 'code' => 'et'],
            ['name' => 'Maltese', 'code' => 'mt'],
            ['name' => 'Irish', 'code' => 'ga'],
            ['name' => 'Russian', 'code' => 'ru'],
            ['name' => 'Ukrainian', 'code' => 'uk'],
            ['name' => 'Turkish', 'code' => 'tr'],
            ['name' => 'Arabic', 'code' => 'ar'],
            ['name' => 'Chinese', 'code' => 'zh'],
            ['name' => 'Japanese', 'code' => 'ja'],
            ['name' => 'Korean', 'code' => 'ko'],
        ];

        foreach ($languages as $language) {
            \App\Models\Language::create($language);
        }
    }
}
