<?php

namespace App\Providers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Features;

class TeamServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRequests();

        $this->configureQueue();
    }

    public function configureRequests()
    {
        if (! $this->app->runningInConsole()) {
            $domain = $this->app->request->getHost();

            /** @var \App\Models\Team $team
             * query to see if a team owns the current domain
             */
            $team = Team::where('domain', $domain)->first();

            if (isset($team->id)) {
                $team->configure()->use();

            } else {
                /**
                 * Allow registration of new users.
                 */
                config(['fortify.features' => [
                    Features::registration(),
                    Features::resetPasswords(),
                    // Features::emailVerification(),
                    Features::updateProfileInformation(),
                    Features::updatePasswords(),
                    Features::twoFactorAuthentication([
                        // 'confirm' => true,
                        'confirmPassword' => true,
                    ]),
                ],]);
            }
        }
    }

    public function configureQueue(){
        $this->app['queue']->createPayloadUsing(function () {
            return $this->app['team'] ? [
                'team_uuid' => $this->app['team']->uuid,
            ] : [];
        });

        $this->app['events']->listen(JobProcessing::class, function ($event){
            if(isset($event->job->payload['team_uuid'])){
              $team = Team::whereUuid($event->job->payload['team_uuid'])->first();
                if(isset($team->id)){
                    $team->configure()->use();
                }
            }
        });
    }
}
