<?php

use App\Filament\Resources\CVS\Pages\CreateCV;
use App\Filament\Resources\CVS\Pages\EditCV;
use App\Filament\Resources\CVS\Pages\ListCVS;
use App\Models\CV;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

describe('CV Filament Resource', function () {
    it('can list CVs', function () {
        $user = User::factory()->create();
        CV::factory()->count(3)->for($user)->create();

        Livewire::actingAs($user)
            ->test(ListCVS::class)
            ->assertSuccessful()
            ->assertCanSeeTableRecords(CV::where('user_id', $user->id)->get());
    });

    it('only shows user their own CVs', function () {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $userCVs = CV::factory()->count(2)->for($user)->create();
        $otherUserCVs = CV::factory()->count(2)->for($otherUser)->create();

        Livewire::actingAs($user)
            ->test(ListCVS::class)
            ->assertCanSeeTableRecords($userCVs)
            ->assertCanNotSeeTableRecords($otherUserCVs);
    });

    it('can create CV', function () {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(CreateCV::class)
            ->fillForm([
                'user_id' => $user->id,
                'title' => 'Software Engineer CV',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'phone' => '+1234567890',
                'city' => 'New York',
                'country' => 'USA',
                'is_active' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('cvs', [
            'user_id' => $user->id,
            'title' => 'Software Engineer CV',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
        ]);
    });

    it('validates required fields when creating CV', function () {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(CreateCV::class)
            ->fillForm([
                'title' => '',
                'first_name' => '',
                'last_name' => '',
            ])
            ->call('create')
            ->assertHasFormErrors(['first_name', 'last_name']);
    });

    it('can edit CV', function () {
        $user = User::factory()->create();
        $cv = CV::factory()->for($user)->create();

        Livewire::actingAs($user)
            ->test(EditCV::class, ['record' => $cv->id])
            ->assertFormSet([
                'title' => $cv->title,
                'first_name' => $cv->first_name,
                'last_name' => $cv->last_name,
            ])
            ->fillForm([
                'title' => 'Updated Title',
                'first_name' => 'Jane',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $cv->refresh();

        expect($cv->title)->toBe('Updated Title')
            ->and($cv->first_name)->toBe('Jane');
    });

    it('cannot edit another users CV', function () {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $cv = CV::factory()->for($otherUser)->create();

        Livewire::actingAs($user)
            ->test(EditCV::class, ['record' => $cv->id])
            ->assertForbidden();
    });

    it('can delete CV', function () {
        $user = User::factory()->create();
        $cv = CV::factory()->for($user)->create();

        Livewire::actingAs($user)
            ->test(ListCVS::class)
            ->callTableAction('delete', $cv);

        $this->assertSoftDeleted('cvs', [
            'id' => $cv->id,
        ]);
    });

    it('cannot delete another users CV', function () {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $cv = CV::factory()->for($otherUser)->create();

        Livewire::actingAs($user)
            ->test(ListCVS::class)
            ->assertTableActionHidden('delete', $cv);
    });

    it('can search CVs by title', function () {
        $user = User::factory()->create();
        $cv1 = CV::factory()->for($user)->create(['title' => 'Software Engineer']);
        $cv2 = CV::factory()->for($user)->create(['title' => 'Product Manager']);

        Livewire::actingAs($user)
            ->test(ListCVS::class)
            ->searchTable('Software')
            ->assertCanSeeTableRecords([$cv1])
            ->assertCanNotSeeTableRecords([$cv2]);
    });

    it('can filter CVs by active status', function () {
        $user = User::factory()->create();
        $activeCV = CV::factory()->for($user)->create(['is_active' => true]);
        $inactiveCV = CV::factory()->for($user)->create(['is_active' => false]);

        Livewire::actingAs($user)
            ->test(ListCVS::class)
            ->assertCanSeeTableRecords([$activeCV, $inactiveCV]);
    });
});
