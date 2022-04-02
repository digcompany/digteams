<?php

namespace App\Http\Middleware;

use App\Models\Team;
use Closure;
use Illuminate\Http\Request;

class TeamSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (isset(app()['team'])) {

            if (! $request->session()->has('team_uuid')) {
                $request->session()->put('team_uuid', app('team')->uuid);
            }

            if ($request->session()->get('team_uuid') !== app('team')->uuid) {
                abort(401);
            }

            if($request->user() &&
                ! $request->user()->switchTeam(app('team'))
            ) {
                abort(401);
            }
        }elseif($request->user() &&
            isset($request->user()->currentTeam->uuid)
        ){
            $team = Team::where('uuid', $request->user()->currentTeam->uuid)->firstOrFail();
            $team = $team->configure()->use();
        }

        return $next($request);
    }
}
