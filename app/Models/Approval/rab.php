<?php

namespace App\Models\Approval;

use App\Models\Base\BaseModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class rab extends BaseModel
{
    // CREATE, UPDATE, DELETE, EDIT
    public static function create(array $storeData)
    {
        return DB::table('rabs')->insert([
            'kebutuhan'=> $storeData['kebutuhan'],
            'deskripsi' => $storeData['deskripsi'],
            'uom' => $storeData['uom'],
            'quantity' => $storeData['quantity'],
            'unit_per_price' => $storeData['unit_per_price'],
            'total_per_item' => $storeData['total_price'],
            'created_at' => now(),
        ]);
    }

    public static function update(array $storeData, $id)
    {
        return DB::table('rabs')
            ->where('id', $id)
            ->update([
                'kebutuhan' => $storeData['kebutuhan'],
                'deskripsi' => $storeData['deskripsi'],
                'uom' => $storeData['uom'],
                'quantity' => $storeData['quantity'],
                'unit_per_price' => $storeData['unit_per_price'],
                'total_per_item' => $storeData['total_price'],
                'updated_at' => now(),
            ]);
    }

    public static function edit($id)
    {
        return DB::table('rabs')
            ->where('rabs.id', $id)
            ->select('rabs.*')
            ->first();
    }

    public static function delete($id)
    {
        return DB::table('rabs')
            ->where('id', $id)
            ->delete();
    }

    public static function getAllRab($id)
    {
        return DB::table('rabs')
            ->where('id', '=', $id)
            ->select('rabs.*')
            ->get()
            ->map(function ($rab) {
                $rab->created_at = Carbon::parse($rab->created_at);
                return $rab;
            });
    }

    public static function getRabById($id)
    {
        return DB::table('rabs')
            ->where('id', '=', $id)
            ->select('rabs.*')
            ->first();
    }

    // GET TOTAL PLAN
    public static function getTotalRab($id)
    {
        return DB::table('rabs')
            ->where('id', '=', $id)
            ->select('rabs.*')
            ->sum('total_per_item');
    }

    // COUNT TOTAL PER ITEM
    public static function getTotalPerItem($id)
    {
        return DB::table('rabs')
            ->select('id', 'quantity', 'unit_per_price', DB::raw('quantity * unit_per_price as total_per_item'))
            ->get();
    }
}
