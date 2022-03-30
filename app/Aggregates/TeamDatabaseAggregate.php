<?php

namespace App\Aggregates;

use App\StorableEvents\TeamDatabaseCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class TeamDatabaseAggregate extends AggregateRoot
{
    public function createTeamDatabase(
        string $userUuid,
        string $name,
    ) {
        $this->recordThat(
            new TeamDatabaseCreated(
                databaseUuid: $this->uuid(),
                userUuid: $userUuid,
                name: $name,
            )
        );

        return $this;
    }
}
