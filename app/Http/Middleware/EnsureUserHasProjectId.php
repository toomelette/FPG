<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasProjectId
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
        $auth = \Auth::user();
        if($auth->project_id == null || $auth->project_id == '' || empty($auth->project_id) ){
            abort(510,'No Project ID assigned to your account.');
        }

        if($auth->project_id != 1 && $auth->project_id != 2 ){
            abort(510,'Invalid Project ID Assignemnt.');
        }
        return $next($request);
    }
}
