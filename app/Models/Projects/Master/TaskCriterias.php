<?php

namespace App\Models\Projects\Master;

use Illuminate\Support\Facades\DB;
use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\Schema;

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

    public static function getAllTaskColumnNames()
    {
        return [
            'id',
            'project_id',
            'title',
            'summary',
            'start_date_estimation',
            'end_date_estimation',
            'attachment',
            'created_by',
            'assign_to',
            'completion_time',
            'created_at',
            'updated_at',
            'status_id',
            'category_id',
            'use_holiday',
            'use_weekend',
            'deleted_at',
            'status_name',
            'project_title',
            'created_by_name',
            'assign_to_name',
            'category_name',
            'flag',
            'label'
        ];
    }
}
