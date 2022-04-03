<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
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

    // protected $appends = [
    //     'url',
    // ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];

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
            'database.connections.team.database' => $this->teamDatabase->name ?? null,
            'cache.prefix' => $this->id,
        ]);

        DB::purge('team');

        DB::reconnect('team');

        Schema::connection('team')->getConnection()->reconnect();

        app('cache')->purge(
            config('cache.default')
        );

        return $this;
    }

    public function applyTeamScopeToUserBase()
    {
        User::addGlobalScope('team', function ($query) {
            $query->whereHas('teams', function ($query) {
                $query->where('teams.id', $this->id);
            });
            $query->orWhereHas('ownedTeams', function ($query) {
                $query->where('teams.id', $this->id);
            });
            $query->orWhereIn('email', $this->teamInvitations->pluck('email')->toArray());
        });
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

    public function url() : Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => isset($attributes['domain']) ? $this->preferHttps($attributes['domain']) : config('app.url'),
        );
    }

    //use  native laravel http client to check if domain supports https

    public function preferHttps($domain)
    {
        try {
            $response = Http::get("https://{$domain}");
            if ($response->status() === 200) {
                return "https://{$domain}";
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return "http://{$domain}";
        }
    }
}
