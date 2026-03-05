<?php

namespace App\Http\Controllers\Auth;

use App\Models\Document;
use App\Models\SuSettings;
use App\Models\User;
use App\Swep\Interfaces\UserInterface;

use Auth;
use Session;
use Illuminate\Http\Request;
use App\Swep\Helpers\__cache;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use function PHPUnit\Framework\returnArgument;


class LoginController extends Controller{
   

    use AuthenticatesUsers;

    protected $user_repo;

    protected $auth;
    protected $session;
    protected $__cache;
    protected $event;
    protected $redirectTo = 'home';
    protected $maxAttempts = 4;
    protected $decayMinutes = 2;





    public function __construct(UserInterface $user_repo, __cache $__cache){


        $this->user_repo = $user_repo;

        $this->auth = auth();
        $this->session = session();
        $this->__cache = $__cache;

        $this->middleware('guest')->except('logout');

    }





    
    public function username(){

        return 'username';
    
    }


    public function showLoginForm()
    {

        session(['link' => url()->previous()]);

        return view('auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        return redirect(session('link'));
    }


    protected function login(Request $request){
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }


        if($this->auth->guard()->attempt($this->credentials($request))){

            if($this->auth->user()->is_activated == false){

                $this->session->flush();
                $this->session->flash('AUTH_UNACTIVATED','Your accounting is in DEACTIVATED status or you must have been an inactive employee. Please contact the designated IT Personnel to activate your account.');
                $this->auth->logout();

            }else{

                $portal = $request->portal;

                $user = User::query()->where('user_id','=',Auth::user()->user_id)->first();
                $user->portal = $request->portal;
                $user->update();
                $activity = activity()
                    ->performedOn(new User())
                    ->causedBy($this->auth->user()->id)
                    ->event('login')
                    ->withProperties(['attributes' => 'Logged in'])
                    ->log('auth');

                $this->clearLoginAttempts($request);
                return redirect()->route('home');
                if (isset(session('_previous')['url'])){
                    return redirect(session('_previous')['url']);
                }else{

                    return redirect()->route('home');
                }

            }
        
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);

    }






    public function logout(Request $request){
        
        if($request->isMethod('post')){

            $activity = activity()
                ->performedOn(new User())
                ->causedBy($this->auth->user()->id)
                ->withProperties(['attributes' => 'Logged out'])
                ->log('auth');


            $this->session->flush();
            $this->guard()->logout();
            $request->session()->invalidate();

            $logout_redirect_link = $_SERVER['SERVER_NAME'];
            $logout_redirect = SuSettings::query()->where('setting','=','logout_redirect')->first();
            if(!empty($logout_redirect)){
                $logout_redirect_link = $logout_redirect->string_value;
            }

            return redirect('http://'.$logout_redirect_link.'/');
            return redirect('/?portal='.$request->portal);

        }
        
        return abort(404);

    }









}
