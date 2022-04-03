<?php

namespace App\Console\Commands;

use App\Models\TeamDatabase;
use Illuminate\Console\Command;

class TeamDatabaseMigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'team-db:migrate {db?} {--fresh} {--seed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->argument('db')) {
            $this->migrate(
                TeamDatabase::find($this->argument('db'))
            );
        } else {
            TeamDatabase::all()->each(
                fn ($db) => $this->migrate($db)
            );
        }
    }

    protected function migrate($db)
    {
        $db->configure()->use();

        $this->line('');
        $this->line('-----------------------------------------');
        $this->line("Migrating team database #{$db->id} ({$db->name})");
        $this->line('-----------------------------------------');
        $this->line('');

        $options = ['--force' => true];

        if ($this->option('seed')) {
            $options['--seed'] = true;
        }

        $this->call(
            $this->option('fresh') ? 'migrate:fresh' : 'migrate',
            $options
        );
    }
}
