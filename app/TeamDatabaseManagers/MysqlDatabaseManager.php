<?php

declare(strict_types=1);

namespace App\TeamDatabaseManagers;

use App\Exceptions\NoConnectionSetException;
use App\Models\TeamDatabase;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;

class MySQLDatabaseManager
{
    /** @var string */
    protected $connection;

    protected function database(): Connection
    {
        if ($this->connection === null) {
            throw new NoConnectionSetException(static::class);
        }

        return DB::connection($this->connection);
    }

    public function setConnection(string $connection): void
    {
        $this->connection = $connection;
    }

    public function createDatabase(TeamDatabase $teamDatabase): bool
    {
        $database = $teamDatabase->name;
        $charset = $this->database()->getConfig('charset');
        $collation = $this->database()->getConfig('collation');

        return $this->database()->statement("CREATE DATABASE IF NOT EXISTS `{$database}` CHARACTER SET `$charset` COLLATE `$collation`");
    }

    public function deleteDatabase(TeamDatabase $teamDatabase): bool
    {
        return $this->database()->statement("DROP DATABASE IF NOT EXISTS `{$teamDatabase->name}`");
    }

    public function databaseExists(string $name): bool
    {
        return (bool) $this->database()->select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$name'");
    }

    public function makeConnectionConfig(array $baseConfig, string $databaseName): array
    {
        $baseConfig['database'] = $databaseName;

        return $baseConfig;
    }
}
