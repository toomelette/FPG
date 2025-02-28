<?php


namespace App\Swep\ViewComposers;


use App\Models\Menu;
use App\Models\Submenu;
use App\Models\UserSubmenu;
use App\Swep\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

class TreeComposer
{
    public function compose($view){

        $tree = [];

        $projectId = Auth::user()->project_id;

        $user_submenus = UserSubmenu::query()
            ->with([
                'submenu.menu'
            ])
            ->leftJoin('su_submenus','su_submenus.submenu_id','su_user_submenus.submenu_id')
            ->leftJoin('su_menus','su_menus.menu_id','su_submenus.menu_id')
            ->where('user_id','=',Auth::user()->user_id)
            ->where('portal','=','DIGIFILE')
            ->orderBy('category','asc')
            ->orderBy('su_menus.order','asc')
            ->orderBy('su_submenus.sort','asc');
        if($projectId == 1){
            $user_submenus = $user_submenus->where('su_menus.vis','=',1);
        }else{
            $user_submenus = $user_submenus->where('su_menus.lm','=',1);
        }

        $user_submenus = $user_submenus->get();


        foreach ($user_submenus as $user_submenu){
            $tree[$user_submenu->submenu->menu->category][($user_submenu->submenu->menu->order ?? 99999).'-'.$user_submenu->submenu->menu->menu_id]['menu_obj'] = $user_submenu->submenu->menu;
            $tree[$user_submenu->submenu->menu->category][($user_submenu->submenu->menu->order ?? 99999).'-'.$user_submenu->submenu->menu->menu_id]['submenus'][$user_submenu->submenu_id] = $user_submenu->submenu;
        }

        $publicSubmenus = Submenu::query()->where('public','=',1)
            ->with([
                'menu',
            ])
            ->whereHas('menu', function ($query) use ($projectId) {
                $query->where('portal', '=','DIGIFILE');
                if($projectId == 1){
                    $query->where('su_menus.vis','=',1);
                }else{
                    $query->where('su_menus.lm','=',1);
                }
            })
            ->get();
        if(!empty($publicSubmenus)){
            foreach ($publicSubmenus as $publicSubmenu){
                $tree[$publicSubmenu->menu->category][($publicSubmenu->menu->order ?? 99999).'-'.$publicSubmenu->menu->menu_id]['menu_obj'] = $publicSubmenu->menu;
                $tree[$publicSubmenu->menu->category][($publicSubmenu->menu->order ?? 99999).'-'.$publicSubmenu->menu->menu_id]['submenus'][$publicSubmenu->submenu_id] = $publicSubmenu;
            }
        }

        $tree = collect($tree)->map(function ($d){
            ksort($d);
            return $d;
        })->toArray();
        $view->with(['tree' => $tree]);

    }


}