<?php

namespace App\Models;

use Spatie\EventSourcing\Snapshots\EloquentSnapshot as SpatieEloquentSnapshot;

class EloquentSnapshot extends SpatieEloquentSnapshot
{
    use UsesLandlordConnection;
}
