<?php

namespace App\Models\Master;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class WfhStatuses extends BaseModel
{
    protected $table = 'status_wfh';
    protected $primaryKey = 'id';



    protected $fillable = [
        'status_name',
        'description',
        'created_at',
        'updated_at',
    ];

    public static function getAllStatus()
    {
        return DB::table('status_wfh')
            ->select('id', 'status_wfh', 'code')
            ->get();
    }

    public static function create(array $storeData)
    {
        return DB::table('status_wfh')->insert([
            'status_wfh' => $storeData['status_wfh'],
            'code' => $storeData['code'],
            'created_at' => now(),
            // 'updated_at' => now(),
        ]);
    }

    public static function update(array $storeData, $id)
    {
        return DB::table('status_wfh')
            ->where('id', $id)
            ->update([
                'status_wfh' => $storeData['status_wfh'],
                'code' => $storeData['code'],
                'updated_at' => now(),
            ]);
    }

    public static function getBy($id)
    {
        return DB::table('status_wfh')
            ->where('id', $id)
            ->first();
    }
    public static function deleteBy($id)
    {
        return DB::table('status_wfh')
            ->where('id', $id)
            ->delete();
    }
}
