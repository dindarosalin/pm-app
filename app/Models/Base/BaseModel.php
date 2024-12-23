<?php

namespace App\Models\Base;
use Illuminate\Support\Facades\{DB, Auth};
use Illuminate\Support\Arr;

class BaseModel
{
    public static function getUserRoleId()
    {
        $data = DB::table('app_role')
            ->join('app_role_user', 'app_role.role_id', '=', 'app_role_user.role_id')
            ->where('user_id', Auth::user()->user_id)
            ->value('app_role.role_id');

        return $data;
    }

    // get user menu access by url
    public static function getMenuAccessByUrl($url)
    {
        return DB::table('app_menu as a')
            ->join('app_menu_control as d', 'd.menu_id', '=', 'a.menu_id')
            ->join('app_role_menu_control as b', 'd.id', '=', 'b.menu_control_id')
            ->join('app_role_user as c', 'b.role_id', '=', 'c.role_id')
            ->where('a.menu_url', $url)
            ->where('c.user_id', Auth::user()->user_id)
            ->where('d.code', "R")
            ->first();
    }

    // get menu parent url
    public static function getParentMenuUrl($parent_menu_id)
    {
        return DB::table('app_menu')->where('menu_id', $parent_menu_id)->value('menu_url');
    }

    // get parent menu utama
    public static function parentMenuUtama($user_id)
    {
        // get data
        $parent_menu_utama = DB::table('app_menu AS a')
            ->select('a.menu_id', 'parent_menu_id', 'menu_name', 'menu_url', 'menu_icon', 'menu_active', 'a.menu_sort')
            ->join('app_menu_control as d', 'd.menu_id', '=', 'a.menu_id')
            ->join('app_role_menu_control as b', 'd.id', '=', 'b.menu_control_id')
            ->join('app_role_user as c', 'b.role_id', '=', 'c.role_id')
            ->whereNull('a.parent_menu_id')
            ->where([
                ['a.menu_display', '=', '1'],
                ['a.menu_group', '=', 'utama'],
                ['c.user_id', '=', $user_id],
                ['d.code', '=', 'R'],
            ])
            ->orderBy('a.menu_sort', 'ASC')
            ->get();

        // return
        return $parent_menu_utama;
    }

    // get child menu utama
    public static function childMenuUtama($menu_id, $user_id)
    {
        // get data
        $child_menu_utama = DB::table('app_menu AS a')
            ->select('a.menu_id', 'parent_menu_id', 'menu_name', 'menu_url', 'menu_icon', 'menu_active', 'a.menu_sort')
            ->join('app_menu_control as d', 'd.menu_id', '=', 'a.menu_id')
            ->join('app_role_menu_control as b', 'd.id', '=', 'b.menu_control_id')
            ->join('app_role_user as c', 'b.role_id', '=', 'c.role_id')
            ->where([
                ['a.parent_menu_id', '=', $menu_id],
                ['a.menu_display', '=', '1'],
                ['a.menu_group', '=', 'utama'],
                ['c.user_id', '=', $user_id],
                ['d.code', '=', 'R'],
            ])->orderBy('a.menu_sort', 'ASC')
            ->get();

        // return
        return $child_menu_utama;
    }

    // get parent menu system
    public static function parentMenuSystem($user_id)
    {
        // get data
        $parent_menu_system = DB::table('app_menu AS a')
            ->select('a.menu_id', 'parent_menu_id', 'menu_name', 'menu_url', 'menu_icon', 'menu_active', 'a.menu_sort')
            ->join('app_menu_control as d', 'd.menu_id', '=', 'a.menu_id')
            ->join('app_role_menu_control as b', 'd.id', '=', 'b.menu_control_id')
            ->join('app_role_user as c', 'b.role_id', '=', 'c.role_id')
            ->whereNull('a.parent_menu_id')
            ->where([
                ['a.menu_display', '=', '1'],
                ['a.menu_group', '=', 'system'],
                ['c.user_id', '=', $user_id],
                ['d.code', '=', 'R'],
            ])
            ->orderBy('a.menu_sort', 'ASC')
            ->get();

        // dd($parent_menu_system);
        // return
        return $parent_menu_system;
    }

    // get child menu system
    public static function childMenuSystem($menu_id, $user_id)
    {
        // get data
        $child_menu_system = DB::table('app_menu AS a')
            ->select('a.menu_id', 'parent_menu_id', 'menu_name', 'menu_url', 'menu_icon', 'menu_active', 'a.menu_sort')
            ->join('app_menu_control as d', 'd.menu_id', '=', 'a.menu_id')
            ->join('app_role_menu_control as b', 'd.id', '=', 'b.menu_control_id')
            ->join('app_role_user as c', 'b.role_id', '=', 'c.role_id')
            ->where([
                ['a.parent_menu_id', '=', $menu_id],
                ['a.menu_display', '=', '1'],
                ['a.menu_group', '=', 'system'],
                ['c.user_id', '=', $user_id],
                ['d.code', '=', 'R'],
            ])->orderBy('a.menu_sort', 'ASC')
            ->get();

        // dd($child_menu_system);

        // return
        return $child_menu_system;
    }

    // make microtime ID
    public static function makeMicrotimeID()
    {
        return str_replace('.', '', microtime(true));
    }

    // user role
    public static function getUserRole()
    {
        $data = DB::table('app_role')
            ->select('role_name')
            ->join('app_role_user', 'app_role.role_id', '=', 'app_role_user.role_id')
            ->where('user_id', Auth::user()->user_id)
            ->first();

        return $data;
    }

    public static function isAuthorize($menu_id, $permission_code)
    {
        $permission = DB::table('app_menu as a')
            ->join('app_menu_control as d', 'd.menu_id', '=', 'a.menu_id')
            ->join('app_role_menu_control as b', 'd.id', '=', 'b.menu_control_id')
            ->join('app_role_user as c', 'b.role_id', '=', 'c.role_id')
            ->where('a.menu_id', $menu_id)
            ->where('c.user_id', Auth::user()->user_id)
            ->where('d.code', $permission_code)
            ->first();

        if (empty($permission) || $permission == NULL) {
            return false;
        } else {
            return true;
        }
    }
}
