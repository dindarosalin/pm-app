<?php
namespace App\Models\Projects\Master;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class TaskStatuses extends BaseModel
{
    public static function getAll() {
        return DB::table('task_statuses')->get();
    }

    public static function getExceptNew() {
        return DB::table('task_statuses')
        ->where('id', '>', 1)
        ->get();
    }

    public static function create($storeData){
        return DB::table('task_statuses')->insert(
            [
                'task_status' => $storeData['statusName'],
                'code_status' => $storeData['statusCode'],
            ]
        );
    }

    public static function update($storeData, $id){
        return DB::table('task_statuses')
        ->where('id',  $id)
        ->update(
            [
                'task_status' => $storeData['statusName'],
                'code_status' => $storeData['statusCode'],
            ]
        );
    }

    public static function getById($id){
        return DB::table('task_statuses')
        ->where('id', '=', $id)
        ->first();
    }

    public static function delete($id){
        return DB::table('task_statuses')
        ->where('id', $id)
        ->delete();
    }
}
