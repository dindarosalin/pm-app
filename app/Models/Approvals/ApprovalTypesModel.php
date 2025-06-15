<?php

namespace App\Models\Approvals;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class ApprovalTypesModel extends BaseModel
{
    public static function getAll() {
        return DB::table('approval_types')->get();
    }

    public static function getById($id){
        return DB::table('approval_types')->where('id', $id)->first();
    }

    public static function create($storeData)
    {
        DB::table('approval_types')->insert(
            [
                'name' => $storeData['approvalName'],
                'description' => $storeData['approvalDescription'],
            ]
        );
    }

    public static function update($storeData, $id)
    {
        // dd($storeData);
        DB::table('approval_types')
        ->where('id',  $id)
        ->update(
            [
                'name' => $storeData['approvalName'],
                'description' => $storeData['approvalDescription'],
            ]
        );
    }

    public static function delete($id)
    {
        return DB::table('approval_types')
            ->where('id', $id)
            ->delete();
    }

}
