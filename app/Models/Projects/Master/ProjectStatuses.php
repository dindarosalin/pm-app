<?php

namespace App\Models\Projects\Master;
use Illuminate\Support\Facades\DB;
use App\Models\Base\BaseModel;

class ProjectStatuses extends BaseModel
{
    public static function getAll(){
        return DB::table('project_statuses')->get();
    }

    public static function create($storeData){
        return DB::table('project_statuses')->insert(
            [
                'project_status' => $storeData['statusName'],
                'code_status' => $storeData['statusCode'],
            ]
        );
    }

    public static function update($storeData, $id){
        return DB::table('project_statuses')
        ->where('id',  $id)
        ->update(
            [
                'project_status' => $storeData['statusName'],
                'code_status' => $storeData['statusCode'],
            ]
        );
    }

    public static function getById($id){
        return DB::table('project_statuses')
        ->where('id', '=', $id)
        ->first();
    }

    public static function delete($id){
        return DB::table('project_statuses')
        ->where('id', $id)
        ->delete();
    }
}
