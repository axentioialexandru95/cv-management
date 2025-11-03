<?php

use App\Models\CV;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('CV Authorization', function () {
    it('allows user to view their own CV', function () {
        $user = User::factory()->create();
        $cv = CV::factory()->for($user)->create();

        $response = $this->actingAs($user)->get(route('cv.show', $cv));

        $response->assertSuccessful();
    });

    it('prevents user from viewing another users CV', function () {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $cv = CV::factory()->for($otherUser)->create();

        $response = $this->actingAs($user)->get(route('cv.show', $cv));

        $response->assertForbidden();
    });

    it('requires authentication to view CV', function () {
        $cv = CV::factory()->for(User::factory())->create();

        $response = $this->get(route('cv.show', $cv));

        $response->assertRedirect();
    });

    it('allows user to download their own CV PDF', function () {
        $user = User::factory()->create();
        $cv = CV::factory()->for($user)->create();

        $response = $this->actingAs($user)->get(route('cv.pdf', $cv));

        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/pdf');
    });

    it('prevents user from downloading another users CV PDF', function () {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $cv = CV::factory()->for($otherUser)->create();

        $response = $this->actingAs($user)->get(route('cv.pdf', $cv));

        $response->assertForbidden();
    });

    it('requires authentication to download CV PDF', function () {
        $cv = CV::factory()->for(User::factory())->create();

        $response = $this->get(route('cv.pdf', $cv));

        $response->assertRedirect();
    });
});

describe('CV Policy', function () {
    it('allows user to view their own CVs', function () {
        $user = User::factory()->create();
        $cv = CV::factory()->for($user)->create();

        expect($user->can('view', $cv))->toBeTrue();
    });

    it('denies user from viewing other users CVs', function () {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $cv = CV::factory()->for($otherUser)->create();

        expect($user->can('view', $cv))->toBeFalse();
    });

    it('allows user to update their own CVs', function () {
        $user = User::factory()->create();
        $cv = CV::factory()->for($user)->create();

        expect($user->can('update', $cv))->toBeTrue();
    });

    it('denies user from updating other users CVs', function () {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $cv = CV::factory()->for($otherUser)->create();

        expect($user->can('update', $cv))->toBeFalse();
    });

    it('allows user to delete their own CVs', function () {
        $user = User::factory()->create();
        $cv = CV::factory()->for($user)->create();

        expect($user->can('delete', $cv))->toBeTrue();
    });

    it('denies user from deleting other users CVs', function () {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $cv = CV::factory()->for($otherUser)->create();

        expect($user->can('delete', $cv))->toBeFalse();
    });
});

describe('CV Factory', function () {
    it('creates CV with all required fields', function () {
        $cv = CV::factory()->create();

        expect($cv)->toBeInstanceOf(CV::class)
            ->and($cv->user_id)->not->toBeNull()
            ->and($cv->title)->not->toBeNull()
            ->and($cv->first_name)->not->toBeNull()
            ->and($cv->last_name)->not->toBeNull()
            ->and($cv->email)->not->toBeNull();
    });

    it('creates CV with relationships', function () {
        $user = User::factory()->create();
        $cv = CV::factory()->for($user)->create();

        expect($cv->user)->toBeInstanceOf(User::class)
            ->and($cv->user->id)->toBe($user->id);
    });
});

describe('CV Relationships', function () {
    it('has work experiences', function () {
        $cv = CV::factory()
            ->has(\App\Models\WorkExperience::factory()->count(3))
            ->create();

        expect($cv->workExperiences)->toHaveCount(3)
            ->and($cv->workExperiences->first())->toBeInstanceOf(\App\Models\WorkExperience::class);
    });

    it('has education entries', function () {
        $cv = CV::factory()
            ->has(\App\Models\EducationEntry::factory()->count(2))
            ->create();

        expect($cv->educationEntries)->toHaveCount(2)
            ->and($cv->educationEntries->first())->toBeInstanceOf(\App\Models\EducationEntry::class);
    });

    it('has skills', function () {
        $cv = CV::factory()
            ->has(\App\Models\Skill::factory()->count(5))
            ->create();

        expect($cv->skills)->toHaveCount(5)
            ->and($cv->skills->first())->toBeInstanceOf(\App\Models\Skill::class);
    });

    it('can attach languages with pivot data', function () {
        $cv = CV::factory()->create();
        $language = \App\Models\Language::factory()->create();

        $cv->languages()->attach($language->id, [
            'listening' => 'B2',
            'reading' => 'C1',
            'spoken_interaction' => 'B2',
            'spoken_production' => 'B1',
            'writing' => 'B2',
            'is_native' => false,
            'certificates' => 'TOEFL 110/120',
            'order' => 0,
        ]);

        $cv->refresh();

        expect($cv->languages)->toHaveCount(1)
            ->and($cv->languages->first()->pivot->listening)->toBe('B2')
            ->and($cv->languages->first()->pivot->is_native)->toBeFalsy();
    });
});
