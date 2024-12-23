<?php

namespace App\Models\Projects\Master;

use Illuminate\Support\Facades\DB;
use App\Models\Base\BaseModel;

class TaskLabel extends BaseModel
{
    public static function getAll()
    {
        return DB::table('task_labels')->get();
    }

    public static function create($storeData){
        return DB::table('task_labels')->insert(
            [
                'label_name' => $storeData['labelName'],
                'label_code' => $storeData['labelCode'],
            ]
        );
    }

    public static function update( $id, $storeData){
        return DB::table('task_labels')
        ->where('id',  $id)
        ->update(
            [
                'label_name' => $storeData['labelName'],
                'label_code' => $storeData['labelCode'],
            ]
        );
    }

    public static function getById($id){
        return DB::table('task_labels')
        ->where('id', $id)
        ->first();
    }

    public static function delete($id){
        return DB::table('task_labels')
        ->where('id', $id)
        ->delete();
    }
}
