<?php

namespace App\Models\Projects\Master;

use App\Models\Base\BaseModel;

use Illuminate\Support\Facades\DB;

class Approval extends BaseModel
{
    protected $table = 'jenis_approve';
    // =================================CREATE, UPDATE, EDIT, DELETE======================================================
    public static function create(array $storeData)
    {
        return DB::table('jenis_approve')->insert([
            'jenis' => $storeData['jenis'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public static function update(array $storeData, $id)
    {
        return DB::table('jenis_approve')
            ->where('id', $id)
            ->update([
                'jenis' => $storeData['jenis'],
                'updated_at' => now(),
            ]);
    }

    public static function delete($id)
    {
        return DB::table('jenis_approve')
            ->where('id', $id)
            ->delete();
    }

    // =================================GET ALL======================================================
    public static function getAllApproval()
    {
        return DB::table('jenis_approve')
            ->get();
    }

    public static function getApprovalId($id)
    {
        return DB::table('jenis_approve')
            ->where('id', $id)
            ->first();
    }

    
}
