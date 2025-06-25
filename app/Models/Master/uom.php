<?php

namespace App\Models\Master;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class Uom extends BaseModel
{
    public static function getAll()
    {
        return DB::table('uoms')->get();
    }

    public static function getById($id)
    {
        return DB::table('uoms')->where('id', $id)->first();
    }

    public static function create($storeData)
    {
        DB::table('uoms')->insert([
            'name' => $storeData['name'],
            'description' => $storeData['description'],
        ]);
    }

    public static function update($id, $storeData)
    {
        DB::table('uoms')
            ->where('id', $id)
            ->update([
                'name' => $storeData['name'],
                'description' => $storeData['description'],
            ]);
    }

    public static function delete($id)
    {
        DB::table('uoms')->where('id', $id)->delete();
    }
}
