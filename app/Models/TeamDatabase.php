<?php

namespace App\Models;

use Dyrynda\Database\Support\BindsOnUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TeamDatabase extends Model
{
    use HasFactory;
    use UsesLandlordConnection;
    use BindsOnUuid;
    use GeneratesUuid;

    protected $guarded = [];

    protected $invalidCharacters = [
        '"', '~','!','@','#','$','%','^','&','*','(',')','-','+','=',';',':','/','','?','|',']','[','{','}','<','>','.','`','\\',' ', '\'',
    ];

    public function configure()
    {
        config([
            'database.connections.team.database' => $this->name,
        ]);

        DB::purge('team');

        DB::reconnect('team');

        Schema::connection('team')->getConnection()->reconnect();

        return $this;
    }

    public function use()
    {
        app()->forgetInstance('teamDatabase');

        app()->instance('teamDatabase', $this);

        return $this;
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function name() : Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => $attributes['name'],
            set: fn ($value, $attributes) => str($attributes['name'] ?? $value)->lower()->snake()->replace($this->invalidCharacters, ''),
        );
    }

}
