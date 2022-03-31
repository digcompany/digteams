<?php

namespace App\Actions\Charter;

use App\Aggregates\TeamDatabaseAggregate;
use App\Contracts\CreatesDatabase;
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
        $uuid = Str::uuid();
        $aggregate = TeamDatabaseAggregate::retrieve($uuid)
            ->createTeamDatabase($user->uuid, $input['name'])
            ->persist();
    }

    public function redirectTo()
    {
        return route('teams.create');
    }
}
