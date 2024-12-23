<?php

namespace App\Models\Projects\Master;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class TaskCategory extends BaseModel
{
    public static function getAll()
    {
        return DB::table('task_categories')->get();
    }

    public static function create($storeData)
    {
        return DB::table('task_categories')->insert(
            [
                'category_name' => $storeData['categoryName'],
                'category_code' => $storeData['categoryCode'],
            ]
        );
    }

    public static function update($storeData, $id)
    {
        return DB::table('task_categories')
            ->where('id',  $id)
            ->update(
                [
                    'category_name' => $storeData['categoryName'],
                    'category_code' => $storeData['categoryCode'],
                ]
            );
    }

    public static function getById($id)
    {
        return DB::table('task_categories')
            ->where('id', $id)
            ->first();
    }

    public static function delete($id)
    {
        return DB::table('task_categories')
            ->where('id', $id)
            ->delete();
    }
}
