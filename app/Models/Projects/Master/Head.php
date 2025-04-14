<?php

namespace App\Models\Projects\Master;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class Head extends BaseModel
{
// ======================================CREATE, UPDATE, DELETE==============================================
    public static function create(array $storeData)
    {
        return DB::table('heads')->insert([
            'jobdesk_id' => $storeData['jobdesk_id'],
            'name' => $storeData['name'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public static function update(array $storeData, $id)
    {
        return DB::table('heads')
            ->where('id', $id)
            ->update([
                'jobdesk_id' => $storeData['jobdesk_id'],
                'name' => $storeData['name'],
                'updated_at' => now(),
            ]);
    }

    public static function delete($id)
    {
        return DB::table('heads')
            ->where('id', $id)
            ->delete();
    }

// =======================================GET=================================================================
    public static function getAllHead()
    {
        return DB::table('heads')
            ->join('jobdesk', 'heads.jobdesk_id', '=', 'jobdesk.id')
            ->select('heads.*', 'jobdesk.job as jobdesk_name')
            ->get();
    }

    public static function getHeadById($id)
    {
        return DB::table('heads')
            ->where('heads.id', $id)
            ->join('jobdesk', 'heads.jobdesk_id', '=', 'jobdesk.id')
            ->select('heads.*', 'jobdesk.job as jobdesk_name')
            ->first();
    }

// ==============================================DEPENDENT DROPDOWN=================================================================
    public static function getHeadByJobdesk($jobdeskId)
    {
        return DB::table('heads')
            ->where('jobdesk_id', $jobdeskId)
            ->select('id', 'name')
            ->get();
    }
}
