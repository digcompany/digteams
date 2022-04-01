<?php

namespace App\Actions\Charter;

use App\Aggregates\TeamDatabaseAggregate;
use App\Contracts\CreatesDatabase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CreateDatabase implements CreatesDatabase
{
    /**
     * Validate and save the given model.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function create($user, array $input)
    {

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255', 'unique:landlord.team_databases'],
            'database_uuid' => ['nullable', 'unique:landlord.team_databases,uuid'],
        ]);

        $uuid = $input['database_uuid'] ?? Str::uuid();

        $aggregate = TeamDatabaseAggregate::retrieve($uuid)
            ->createTeamDatabase($user->uuid, $input['name'])
            ->persist();
    }

    public function redirectTo()
    {
        return route('teams.create');
    }
}
