<?php

namespace App\Models\Projects\Master;

use Illuminate\Support\Facades\DB;
use App\Models\Base\BaseModel;

class TaskSubCriterias extends BaseModel
{
    public static function getAll()
    {
        return DB::table('task_subcriterias')
        ->join('task_criterias', 'task_subcriterias.criteria_id', '=', 'task_criterias.id')
        ->select(
            'task_subcriterias.*',
            'task_criterias.c_name as criteria_name'
        )
        ->get();
    }

    public static function create($storeData){
        return DB::table('task_subcriterias')->insert(
            [
                'criteria_id' => $storeData['cId'],
                'sc_label' => $storeData['scLabel'],
                'sc_min' => $storeData['scMin'],
                'sc_max' => $storeData['scMax'],
                'sc_value' => $storeData['scValue'],
                'sc_description' => $storeData['scDesc']
            ]
        );
    }

    public static function update($storeData, $id){
        return DB::table('task_subcriterias')
        ->where('id',  $id)
        ->update(
            [
                'criteria_id' => $storeData['cId'],
                'sc_label' => $storeData['scLabel'],
                'sc_min' => $storeData['scMin'],
                'sc_max' => $storeData['scMax'],
                'sc_value' => $storeData['scValue'],
                'sc_description' => $storeData['scDesc']
            ]
        );
    }

    public static function getById($id){
        return DB::table('task_subcriterias')
        ->where('id', $id)
        ->first();
    }

    public static function delete($id){
        return DB::table('task_subcriterias')
        ->where('id', $id)
        ->delete();
    }
}
