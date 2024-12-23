<?php

namespace App\Models\Projects\Master;

use Illuminate\Support\Facades\DB;
use App\Models\Base\BaseModel;

class TaskFlags extends BaseModel
{
    public static function getAll(){
        return DB::table('task_flags')->get();
    }

    public static function create($storeData){
        return DB::table('task_flags')->insert(
            [
                'flag_name' => $storeData['flagName'],
                'flag_code' => $storeData['flagCode'],
            ]
        );
    }

    public static function update($storeData, $id){
        return DB::table('task_flags')
        ->where('id',  $id)
        ->update(
            [
                'flag_name' => $storeData['flagName'],
                'flag_code' => $storeData['flagCode'],
            ]
        );
    }

    public static function getById($id){
        return DB::table('task_flags')
        ->where('id', $id)
        ->first();
    }

    public static function delete($id){
        return DB::table('task_flags')
        ->where('id', $id)
        ->delete();
    }
}
