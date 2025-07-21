<?php

namespace App\Http\Middleware;


use Auth;
use Session;
use Closure;



class CheckUserStatus{


    protected $auth;
    protected $session;




    public function __construct(){

        $this->auth = auth();
        $this->session = session();
        
    }




    public function handle($request, Closure $next){
        if(request()->has('trigger') && request('trigger') == 'SCANNER'){
            return redirect(route('public.verify.document').'?document='.request()->route()->parameter('slug'));
        }
        if($this->auth->guard()->check()){
            $user = Auth::user();
            if($user->employee->is_active == 'INACTIVE'){
                $user->is_activated = 0;
                $user->save();
            }

            if($this->auth->user()->is_activated == false){

                $this->auth->logout();
                $this->session->flush();
                $this->session->flash('CHECK_NOT_ACTIVE', 'Your account has been deactivated! It may be possible that you were marked as INACTIVE employee.');
                return redirect('/');

            }



            return $next($request);

        }

        $this->session->flush();
        $this->session->flash('CHECK_UNAUTHENTICATED', 'Please Sign in to start your session.');
        return redirect('/');
    
    }





}
