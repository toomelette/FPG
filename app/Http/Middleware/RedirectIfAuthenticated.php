<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated{
    

    public function handle($request, Closure $next, $guard = null){
        if (Auth::guard($guard)->check()) {
            $portal = $request->portal;
            $user = User::query()->where('user_id','=',Auth::user()->user_id)->first();
            $user->portal = $portal;
            $user->update();
            return redirect('home');
        }

        return $next($request);

    }


}
