<?php

namespace App\Broadcasting;

use App\Models\Submenu;
use App\Models\User;
use App\Models\UserSubmenu;

class MISRequestChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user): array|bool
    {
        $user = \Auth::user();
        $submenu = Submenu::query()->where('route','=','dashboard.mis_requests.index')->first();
        if(empty($submenu)){
            abort(403,'Submenu not found');
        }
        $userSubmenus = UserSubmenu::query()
            ->where('user_id','=',\Auth::user()->user_id)
            ->where('submenu_id','=',$submenu->submenu_id)
            ->count();
        if($userSubmenus < 1){
            abort(401);
        }
        return true;
    }
}
