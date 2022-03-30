<?php

namespace App\Projectors;

use App\Models\User;
use App\StorableEvents\TeamDatabaseCreated;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class TeamDatabaseProjector extends Projector
{
    public function onTeamDatabaseCreated(TeamDatabaseCreated $event)
    {
        $user = User::where('uuid', $event->userUuid)->firstOrFail();

        $user->teamDatabases()->forceCreate(
            [
                'name' => $event->name,
                'uuid' => $event->databaseUuid,
                'user_id' => $user->id,
            ]
        );
    }
}
