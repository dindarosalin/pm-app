<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Base\BaseModel;
use Illuminate\Support\Arr;

class AccessRightModel extends BaseModel
{
    public static function getAllMenuControl()
    {
        return DB::table('app_menu_control')
            ->orderBy('order_no')
            ->get();
    }

    public static function getAllMenuAccessRight($role_id)
    {
        return DB::table('app_role_menu_control')
            ->where("role_id", $role_id)
            ->get();
    }

    public static function insert($params)
    {
        return DB::table('app_role_menu_control')->insert($params);
    }


    public static function delete($role_id)
    {
        return DB::table('app_role_menu_control')->where('role_id', $role_id)->delete();
    }

    public static function update($role_id, $params)
    {
        $log = Arr::add($params, 'role_id', $role_id);

        DB::beginTransaction();
        try {
            AccessRightModel::delete($role_id);
            AccessRightModel::insert($params);
            // ActivityLogModel::addLog('Update Access Right', $log);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
}
