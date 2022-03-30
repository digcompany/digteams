<?php

namespace Tests\Feature;

use App\Http\Livewire\CreateDatabaseForm;
use App\Models\TeamDatabase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class TeamDatabaseCanBeCreatedTest extends TestCase
{

    public function test_team_databases_can_be_created()
    {
        $this->actingAs(User::factory()->create());

        $component = Livewire::test(CreateDatabaseForm::class)->set('state', [
            'name' => 'Test Database',
        ])->call('createDatabase');

        $this->assertDatabaseHas('team_databases', [
            'name' => 'Test Database',
        ], (new TeamDatabase())->getConnectionName());
    }
}
