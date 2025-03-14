<?php

namespace App\Models\Projects\Master;

use Illuminate\Support\Facades\DB;
use App\Models\Base\BaseModel;

class TaskCriterias extends BaseModel
{
    public static function getAll(){
        return DB::table('task_criterias')->get();
    }

    public static function create($storeData){
        return DB::table('task_criterias')->insert(
            [
                'c_name' => $storeData['cName'],
                'c_attribute' => $storeData['cAttribute'],
                'c_value' => $storeData['cValue'],
                'c_description' => $storeData['cDescription']
            ]
        );
    }

    public static function update($storeData, $id){
        return DB::table('task_criterias')
        ->where('id',  $id)
        ->update(
            [
                'c_name' => $storeData['cName'],
                'c_attribute' => $storeData['cAttribute'],
                'c_value' => $storeData['cValue'],
                'c_description' => $storeData['cDescription']
            ]
        );
    }

    public static function getById($id){
        return DB::table('task_criterias')
        ->where('id', $id)
        ->first();
    }

    public static function delete($id){
        return DB::table('task_criterias')
        ->where('id', $id)
        ->delete();
    }
}
