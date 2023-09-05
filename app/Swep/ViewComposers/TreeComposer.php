<?php


namespace App\Swep\ViewComposers;


use App\Models\Menu;
use App\Models\UserSubmenu;
use App\Swep\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

class TreeComposer
{
    public function compose($view){

        $tree = [];
        $menus = Menu::with('submenu')->where('portal','=',Auth::user()->portal)->where('portal','!=','PPU')->get();

        $user_submenus = UserSubmenu::with(['submenu.menu'])->where('user_id', Auth::user()->user_id)
            ->whereHas('submenu', function ($query) {
                return $query->where('is_nav', '=', 1);
            });
        if(Auth::user()->portal != ''){
            $user_submenus = $user_submenus->whereHas('submenu.menu', function ($query) {
                return $query->where('portal', '=', Auth::user()->portal)->where('portal' ,'!=','PPU');
            });
        }

        $user_submenus = $user_submenus->get();

        if(Auth::user()->project_id != 2){
            $dtr_menus = Menu::query()->with(['submenu']);
            if(Helper::dtrMenuOn() == true){
                $dtr_menus = $dtr_menus->where('slug','=','OjM6liSKVeDpwZQc');
            }
            $dtr_menus = $dtr_menus->orWhere('slug','=','ptQX7MfbtJR2EtIf')
                ->get();
            foreach ($dtr_menus as $dtr_menu){
                $tree[$dtr_menu->category][$dtr_menu->menu_id]['menu_obj'] = $dtr_menu;
                foreach (
                    $dtr_menu->submenu->
                    where('is_nav','=',1)
                        ->where('route','!=','dashboard.dtr.extract')
                        ->where('route','!=','dashboard.dtr.index')
                        ->where('route','!=','dashboard.mis_requests.index')
                    as $submenu){
                    $tree[$dtr_menu->category][$dtr_menu->menu_id]['submenus'][$submenu->submenu_id] = $submenu;
                }
            }
        }




        foreach ($user_submenus as $user_submenu){
            if($user_submenu->submenu->menu->portal != 'PPU'){
            $tree[$user_submenu->submenu->menu->category][$user_submenu->submenu->menu->menu_id]['menu_obj'] = $user_submenu->submenu->menu;
            $tree[$user_submenu->submenu->menu->category][$user_submenu->submenu->menu->menu_id]['submenus'][$user_submenu->submenu_id] = $user_submenu->submenu;
            }
        }



        $view->with(['tree' => $tree]);

    }


}