<?php

namespace App\Models\Approvals;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class ApprovalPermissionTypes extends BaseModel
{
    public static function getAll()
    {
        return DB::table('approval_permission_types')->get();
    }

    public static function getById($id)
    {
        return DB::table('approval_permission_types')->where('id', $id)->first();
    }

    public static function create($storeData)
    {
        DB::table('approval_permission_types')->insert([
            'name' => $storeData['name'],
            'description' => $storeData['description'],
        ]);
    }

    public static function update($id, $storeData)
    {
        // dd($storeData);
        DB::table('approval_permission_types')
            ->where('id', $id)
            ->update([
                'name' => $storeData['name'],
                'description' => $storeData['description'],
            ]);
    }

    public static function delete($id)
    {
        DB::table('approval_permission_types')->where('id', $id)->delete();
    }
}
