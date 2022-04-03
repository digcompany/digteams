<?php

namespace App\Projectors;

use App\Contracts\DatabaseManager;
use App\Jobs\MigrateTeamDatabase;
use App\Models\User;
use App\StorableEvents\TeamDatabaseCreated;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class TeamDatabaseProjector extends Projector
{
    public function onTeamDatabaseCreated(TeamDatabaseCreated $event)
    {
        $user = User::where('uuid', $event->userUuid)->firstOrFail();

        $teamDatabase = $user->teamDatabases()->firstOrCreate(
            [
                'name' => $event->name,
            ],
            [
                'name' => $event->name,
                'uuid' => $event->databaseUuid,
                'user_id' => $user->id,
            ]
        );

        $databaseManager = app(DatabaseManager::class)->setConnection('team');

        $databaseManager->createDatabase($teamDatabase);

        MigrateTeamDatabase::dispatch($teamDatabase->uuid);
    }
}
