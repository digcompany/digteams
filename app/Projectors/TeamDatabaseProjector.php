<?php

namespace App\Projectors;

use App\Models\User;
use App\StorableEvents\TeamDatabaseCreated;
use Artisan;
use Illuminate\Support\Facades\DB;
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

        $driver = DB::connection('team')->getConfig('driver');
        $charset = DB::connection('team')->getConfig('charset');
        $collation = DB::connection('team')->getConfig('collation');

        switch($driver)
        {
            case 'mysql':

                DB::connection('team')->statement("CREATE DATABASE IF NOT EXISTS `{$event->name}` CHARACTER SET `$charset` COLLATE `$collation`");

               $artisan = Artisan::call('team-db:migrate', [
                    'db' => $teamDatabase->id,
                ]);

            case 'pgsql':
                /* 'TODO: add support for this driver' */
;
                break;
            case 'sqlite':
                /* 'TODO: add support for this driver' */

                break;
        }


    }
}
