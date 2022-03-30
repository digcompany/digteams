<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\Team as JetstreamTeam;

class Team extends JetstreamTeam
{
    use HasFactory;
    use HasProfilePhoto;
    use UsesLandlordConnection;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'personal_team' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'personal_team',
        'uuid',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    public function configure()
    {
        config([
            'database.connections.team.database' => $this->teamDatabase->name,
        ]);

        DB::purge('team');

        DB::reconnect('team');

        Schema::connection('team')->getConnection()->reconnect();

        return $this;
    }

    public function use()
    {
        app()->forgetInstance('team');

        app()->instance('team', $this);

        return $this;
    }

    public function teamDatabase()
    {
        return $this->belongsTo(TeamDatabase::class);
    }
}
