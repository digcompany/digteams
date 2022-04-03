<?php

namespace App\Http\Middleware;

use App\Models\Team;
use Closure;
use Illuminate\Http\Request;

class TeamAuth
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
            $permittedRoutes = ['create-first-team', 'join-team', 'team-invitations.accept'];

            if ($request->user() && isset($request->user()->currentTeam->id)) {
                if (! $request->user()->switchTeam(app('team'))) {
                    if (! in_array($request->route()->getName(), $permittedRoutes)) {
                        return redirect(route('join-team'));
                    }
                }
            } elseif ($request->user() &&
                isset($request->user()->currentTeam->uuid)
        ) {
                $team = Team::where('uuid', $request->user()->currentTeam->uuid)->firstOrFail();
                $team = $team->configure()->use();
            }

        }
        return $next($request);
    }
}
