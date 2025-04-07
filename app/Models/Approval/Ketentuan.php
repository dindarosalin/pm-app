<?php

namespace App\Models\Approval;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class Ketentuan extends BaseModel
{
// ============================================CREATE, UPDATE, EDIT, DELETE==================================================================
// simpan data tabel ketentuan ke dalam database
    public static function create(array $storeData)
    {
        // dd($storeData);
        return DB::table('ketentuans')->insert([
            'jenis' => $storeData['jenis'],
            'file_name' => $storeData['file_name'],
            'file_path' => $storeData['file_path'],
            'created_at' => now(),
        ]);
    }

    // update ketentuan based on id
    public static function update(array $storeData, $id)
    {
        return DB::table('ketentuans')
                ->where('id', $id)
                ->update([
                    'jenis' => $storeData['jenis'],
                    'file_name' => $storeData['file_name'],
                    'file_path' => $storeData['file_path'],
                    'updated_at' => now(),
                ]);
    }

    public static function edit($id)
    {
        return DB::table('ketentuans')
                ->where('id', $id)
                ->select('ketentuans.*')
                ->first();
    }

    // hapus ketentuan based on ID
    public static function delete($id)
    {
        return DB::table('ketentuans')
                ->where('id', $id)
                ->delete();
    }

    // ================================================GET DATA==================================================================
    // get all ketentuan dari database
    public static function getAll()
    {
        return DB::table('ketentuans')
                ->get();
    }

    // get ketentuan based on ID
    public static function getById($id)
    {
        return DB::table('ketentuans')
                ->where('id', $id)
                ->first();
    }
}

// get role
    // public function getRole($role_id)
    // {
    //     return DB::table('app_role')
    //             ->where('role_id', $role_id)
    //             ->first();
    // }

    // public static function getKetentuan($id)
    // {
    //     return DB::table('ketentuans')
    //             ->where('id', $id)
    //             ->first();
    // }    
