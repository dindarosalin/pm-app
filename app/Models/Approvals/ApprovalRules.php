<?php

namespace App\Models\Approvals;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class ApprovalRules extends BaseModel
{
    public static function getAll()
    {
        return DB::table('approval_rules')
            ->join('approval_types', 'approval_rules.approval_id', '=', 'approval_types.id')
            ->join('app_user', 'approval_rules.created_by', '=', 'app_user.user_id')
            ->select([
                'approval_rules.id',
                'approval_rules.file_name',
                'approval_rules.file_path',
                'approval_rules.created_by',
                'approval_rules.last_updated',
                'approval_types.name as approval_name',
                'app_user.user_name as creator_name'
            ])
            ->get();
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
        // dd($storeData);
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
        DB::table('approval_rules')->where('id', $id)->delete();
    }
}
