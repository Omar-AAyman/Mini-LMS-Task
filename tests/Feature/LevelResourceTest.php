<?php

use App\Models\Level;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Filament\Facades\Filament;
use App\Filament\Resources\LevelResource\Pages\ManageLevels;
use Illuminate\Database\QueryException;
    
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['is_admin' => true]);
});

it('lists levels in filament', function () {
    $level = Level::factory()->create(['name' => 'Beginner', 'slug' => 'beginner']);

    actingAs($this->admin)
        ->get('/admin/levels')
        ->assertSuccessful()
        ->assertSee('Beginner');
});

it('can create a level', function () {
    actingAs($this->admin);

    Filament::setCurrentPanel(Filament::getPanel('admin'));

    Livewire::test(ManageLevels::class)
        ->callAction('create', data: [
            'name' => 'Expert',
            'slug' => 'expert',
        ])
        ->assertHasNoErrors();

    $this->assertDatabaseHas('levels', ['slug' => 'expert']);
});

it('enforces unique slug constraint on levels', function () {
    Level::factory()->create(['name' => 'Beginner', 'slug' => 'beginner']);

    expect(fn () => Level::create(['name' => 'Duplicate', 'slug' => 'beginner']))
        ->toThrow(QueryException::class);
});
