<?php

namespace Tests\Feature;

use App\Http\Livewire\CreateDatabaseForm;
use App\Models\TeamDatabase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;

class TeamDatabaseCanBeCreatedTest extends TestCase
{

    public function test_team_databases_can_be_created()
    {
        $this->actingAs(User::factory()->create());

        $this->withoutExceptionHandling();

        $component = Livewire::test(CreateDatabaseForm::class)->set('state', [
            'name' => ':memory:',
        ])->call('createDatabase');

        $this->assertDatabaseHas('team_databases', [
            'name' => ':memory:',
        ], (new TeamDatabase())->getConnectionName());
    }
}
