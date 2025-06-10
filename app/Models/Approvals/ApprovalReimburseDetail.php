<?php

namespace App\Models\Approvals;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class ApprovalReimburseDetail extends BaseModel
{
    public static function getAll()
    {
        return DB::table('approval_reimburse_details')->get();
    }

    public static function getById($id)
    {
        return DB::table('approval_reimburse_details')->where('id', $id)->first();
    }

    public static function create($storeData)
    {
        DB::table('approval_reimburse_details')->insert([
            'reimburse_id' => $storeData['reimburseId'],
            'name' => $storeData['name'],
            'description' => $storeData['description'],
            'uom' => $storeData['uom'],
            'quantity' => $storeData['qty'],
            'item_price' => $storeData['iPrice'],
            'total_item_price' => $storeData['iTPrice'],
        ]);
    }

    public static function update($id, $storeData)
    {
        DB::table('approval_reimburse_details')->where('id', $id)->update([
            'reimburse_id' => $storeData['reimburseId'],
            'name' => $storeData['name'],
            'description' => $storeData['description'],
            'uom' => $storeData['uom'],
            'quantity' => $storeData['qty'],
            'item_price' => $storeData['iPrice'],
            'total_item_price' => $storeData['iTPrice'],
        ]);
    }

    public static function delete($id)
    {
        DB::table('approval_reimburse_details')->where('id', $id)->delete();
    }

    public static function getByreimburseId($id)
    {
        return DB::table('approval_reimburse_details')->where('reimburse_id', $id)->sum('total_item_price');
    }
}
