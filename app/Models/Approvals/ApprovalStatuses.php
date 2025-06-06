<?php

namespace App\Models\Approvals;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class ApprovalStatuses extends BaseModel
{
    public static function getAll() {
        return DB::table('approval_statuses')->get();
    }

    public static function getById($id){
        return DB::table('approval_statuses')->where('id', $id)->first();
    }

    public static function create($storeData)
    {
        DB::table('approval_statuses')->insert(
            [
                'name' => $storeData['name'],
                'code' => $storeData['code'],
                'description' => $storeData['description'],
            ]
        );
    }

    public static function update($storeData, $id)
    {
        // dd($storeData);
        DB::table('approval_statuses')
        ->where('id',  $id)
        ->update(
            [
                'name' => $storeData['name'],
                'code' => $storeData['code'],
                'description' => $storeData['description'],
            ]
        );
    }

    public static function delete($id)
    {
        return DB::table('approval_statuses')
            ->where('id', $id)
            ->delete();
    }
}
