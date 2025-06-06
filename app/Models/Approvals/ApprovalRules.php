<?php

namespace App\Models\Approvals;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class ApprovalRules extends BaseModel
{
    public static function getAll()
    {
        return DB::table('approval_rules')->get();
    }

    public static function getById($id)
    {
        return DB::table('approval_rules')->where('id', $id)->first();
    }

    public static function create($storeData)
    {
        // dd($storeData);
        DB::table('approval_rules')->insert([
            'approval_id' => $storeData['approval_id'],
            'file_name' => $storeData['file_name'],
            'file_path' => $storeData['file_path'],
            'created_by' => $storeData['auth'], // ubah key-nya
            'last_updated' => now(),
        ]);
    }

    public static function update($id, $storeData)
    {
        DB::table('approval_rules')
            ->where('id', $id)
            ->update([
                'approval_id' => $storeData['approval_id'],
                'file_name' => $storeData['file_name'],
                'file_path' => $storeData['file_path'],
                'created_by' => $storeData['auth'],
                'last_updated' => now(),
            ]);
    }

    public static function delete($id)
    {
        DB::table('approval_rules')
        ->where('id', $id)
        ->delete();
    }
}
