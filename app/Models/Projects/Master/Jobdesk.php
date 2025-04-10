<?php

namespace App\Models\Projects\Master;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class Jobdesk extends BaseModel
{
    protected $table = 'jobdesk';
// =================================CREATE, UPDATE, EDIT, DELETE======================================================
    public static function create(array $storeData)
    {
        return DB::table('jobdesk')->insert([
            'job' => $storeData['job'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public static function update(array $storeData, $id)
    {
        return DB::table('jobdesk')
            ->where('id', $id)
            ->update([
                'job' => $storeData['job'],
                'updated_at' => now(),
            ]);
    }

    public static function delete($id)
    {
        return DB::table('jobdesk')
            ->where('id', $id)
            ->delete();
    }
// =================================GET ALL======================================================
    public static function getAllJob()
    {
        return DB::table('jobdesk')
            ->get();
    }

    public static function getJobId($id)
    {
        return DB::table('jobdesk')
            ->where('id', $id)
            ->first();
    }
}
