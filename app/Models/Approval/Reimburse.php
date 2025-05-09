<?php

namespace App\Models\Approval;

use App\Models\Base\BaseModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Reimburse extends BaseModel
{
    //======================================CREATE, UPDATE, DELETE, EDIT========================================
    public static function create(array $storeData)
    {
        return DB::table('reimburses')->insert([
            'kebutuhan' => $storeData['kebutuhan'],
            'uom' => $storeData['uom'],
            'quantity' => $storeData['quantity'],
            'unit_price' => $storeData['unit_price'],
            'total_per_item' => $storeData['total_per_item'],
            'attachment' => $storeData['attachment'],
            'purchase_date' => $storeData['purchase_date'],
            'created_at' => now(),
        ]);
    }

    public static function update(array $storeData, $id)
    {
        return DB::table('reimburses')
            ->where('id', $id)
            ->update([
                'kebutuhan' => $storeData['kebutuhan'],
                'uom' => $storeData['uom'],
                'quantity' => $storeData['quantity'],
                'unit_price' => $storeData['unit_price'],
                'total_per_item' => $storeData['total_per_item'],
                'attachment' => $storeData['attachment'],
                'purchase_date' => $storeData['purchase_date'],
                'updated_at' => now(),
            ]);
    }

    public static function edit($id)
    {
        return DB::table('reimburses')
            ->where('reimburses.id', $id)
            ->select('reimburses.*')
            ->first();
    }   

    public static function delete($id)
    {
        return DB::table('reimburses')
            ->where('id', $id)
            ->delete();
    }

    // ======================================GET ALL DATA========================================
    public static function getAllreimburse($id)
    {
        return DB::table('reimburses')
            ->where('id', '=', $id)
            ->select('reimburses.*')
            ->get()
            ->map(function ($reimburses) {
                $reimburses->created_at = Carbon::parse($reimburses->created_at);
                return $reimburses;
            });
    }

    public static function getreimburseById($id)
    {
        return DB::table('reimburses')
            ->where('reimburses.id', $id)
            ->select('reimburses.*')
            ->first();
    }

    public static function getTotalreimburses($id)
    {
        return DB::table('reimburses')
            ->where('id', '=', $id)
            ->select('reimburses.*')
            ->sum('total_per_item');
    }

    // ======================================COUNT TOTAL PER ITEM========================================
    public static function totalPriceItem()
    {
        return DB::table('reimburses')
            ->select('id', 'quantity', 'unit_price', DB::raw('quantity * unit_price as total_per_item'))
            ->get();
    }
}
