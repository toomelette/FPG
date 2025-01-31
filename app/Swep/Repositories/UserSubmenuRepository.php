<?php

namespace App\Swep\Repositories;
 
use App\Models\Submenu;
use App\Swep\BaseClasses\BaseRepository;
use App\Swep\Interfaces\UserSubmenuInterface;

use Route;
use App\Models\UserSubmenu;


class UserSubmenuRepository extends BaseRepository implements UserSubmenuInterface {
	



    protected $user_submenu;




	public function __construct(UserSubmenu $user_submenu){

        $this->user_submenu = $user_submenu;
        parent::__construct();

    }






    public function store($submenu, $user_menu){

        $user_submenu = new UserSubMenu;
        $user_submenu->submenu_id = $submenu->submenu_id;
        $user_submenu->user_menu_id = $user_menu->user_menu_id;
        $user_submenu->user_id = $user_menu->user_id;
        $user_submenu->is_nav = $submenu->is_nav;
        $user_submenu->name = $submenu->name;
        $user_submenu->nav_name = $submenu->nav_name;
        $user_submenu->route = $submenu->route;
        $user_submenu->save();

        return $user_submenu;

    }






    public function isExist($rt = null) {
        if($rt == null){
            $route_name = Route::currentRouteName();
        }else{
            $route_name = $rt;
        }
        $user_id = $this->auth->user()->user_id;

        if($route_name == 'dashboard.home'){
            return 1;
        }else{
            $submenu_id = Submenu::where('route',$route_name)->first();
            if(empty($submenu_id)){
                abort(503,'Submenu does not exist.: Route name:['.$route_name.']');
            }
            if($submenu_id->public == 1){
                return true;
            }
            $submenu_id = $submenu_id->submenu_id;

            $usm = $this->user_submenu->where('submenu_id', $submenu_id)
                ->where('user_id', $user_id)
                ->first();

            if(empty($usm)){
                abort(503,'This action is unauthorized. (Insufficient privilege)');
            }
            return $usm;
        }
    }


    public function isUserAuthorized($rt) {
        $route_name = $rt;
        $user_id = $this->auth->user()->user_id;


        $submenu_id = Submenu::where('route',$route_name)->first();
        if($submenu_id->public == 1){
            return true;
        }
        $submenu_id = $submenu_id->submenu_id;

        $usm = $this->user_submenu->where('submenu_id', $submenu_id)
            ->where('user_id', $user_id)
            ->first();

        if(empty($usm)){
            return false;
        }

        return true;
    }






}