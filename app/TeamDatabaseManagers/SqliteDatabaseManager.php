<?php

declare(strict_types=1);

namespace App\TeamDatabaseManagers;

use App\Contracts\DatabaseManager;

class SQLiteDatabaseManager implements DatabaseManager
{
    public function createDatabase($teamDatabase): bool
    {
        try {
            return file_put_contents(database_path($teamDatabase->name), '');
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function deleteDatabase($teamDatabase): bool
    {
        try {
            return unlink(database_path($teamDatabase->name));
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function databaseExists(string $name): bool
    {
        return file_exists(database_path($name));
    }

    public function makeConnectionConfig(array $baseConfig, string $databaseName): array
    {
        $baseConfig['database'] = database_path($databaseName);

        return $baseConfig;
    }

    public function setConnection(string $connection)
    {
        return $this;
    }
}
