<?php

namespace App\Jobs;

use App\Models\TeamDatabase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class MigrateTeamDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $teamDatabaseUuid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($teamDatabaseUuid)
    {
        $this->teamDatabaseUuid = $teamDatabaseUuid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $teamDatabase = TeamDatabase::whereUuid($this->teamDatabaseUuid)->firstOrFail();

        $artisan = Artisan::call('team-db:migrate', [
            'db' => $teamDatabase->id,
        ]);
    }
}
