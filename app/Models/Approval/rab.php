<?php

namespace App\Models\Approval;

use App\Models\Base\BaseModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class rab extends BaseModel
{
    // ==============================================================STORE RABS==================================================================
    public static function create(array $storeData)
    {
        return DB::table('rabs')->insert([
            'name_id' => $storeData['name_id'],
            'telepon' => $storeData['telepon'],
            'email' => $storeData['email'],
            'jobdesk_id' => $storeData['selectJobdesk'],
            'head_id' => $storeData['selectHead'],
            'id_jenis_approve' => $storeData['jenis_rab'],
            'created_at' => now(),
        ]);
    }

    public static function update(array $storeData, $id)
    {
        return DB::table('rabs')
        ->where('id', $id)
        ->update([
            'name_id' => $storeData['name_id'],
            'telepon' => $storeData['telepon'],
            'email' => $storeData['email'],
            'jobdesk_id' => $storeData['selectJobdesk'],
            'head_id' => $storeData['selectHead'],
            'id_jenis_approve' => $storeData['jenis_rab'],
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

    // =======================================GET ALL DATA RABS========================================
    public static function getAllRab()
    {
        return DB::table('rabs')
        ->join('jobdesk', 'rabs.jobdesk_id', '=', 'jobdesk.id')
            ->join('heads', 'rabs.head_id', '=', 'heads.id')
            ->join('jenis_approve', 'rabs.id_jenis_approve', '=', 'jenis_approve.id')
            ->select(
                'rabs.*',
                'jobdesk.job as jobdesk_name',
                'heads.name as head_name',
                'jenis_approve.jenis as rab_name'
            )
            ->orderBy('rabs.created_at', 'desc')
            ->get();
    }

    public static function getAllByAuth($auth)
    {
        return DB::table('rabs')
            ->where('rabs.name_id', $auth)
            ->get();
    }

    // ================================================DEPENDENT DROPDOWN================================================
    public static function getHeads($jobdesk_id)
    {
        return DB::table('rabs')
        ->where('jobdesk_id', $jobdesk_id)
        ->select('id', 'job')
        ->get();
    }


    // =======================================================STORE RAB DETAIL================================================
    public static function createRabDetail(array $storeData)
    {
        return DB::table('rab_details')->insert([
            'rab_id' => $storeData['rab_id'],
            'kebutuhan' => $storeData['kebutuhan'],
            'deskripsi' => $storeData['deskripsi'],
            'oum' => $storeData['uom'],
            'quantity' => $storeData['quantity'],
            'unit_price' => $storeData['unit_price'],
            'total_per_item' => $storeData['total_per_item'],
            'created_at' => now(),
        ]);
    }

    public static function updateRabDetail(array $storeData, $id)
    {
        return DB::table('rab_details')
        ->where('id', $id)
        ->update([
            'rab_id' => $storeData['rab_id'],
            'kebutuhan' => $storeData['kebutuhan'],
            'deskripsi' => $storeData['deskripsi'],
            'oum' => $storeData['uom'],
            'quantity' => $storeData['quantity'],
            'unit_price' => $storeData['unit_price'],
            'total_per_item' => $storeData['total_per_item'],
        ]);
    }

    public static function editRabDetail($id)
    {
        return DB::table('rab_details')
        ->where('rab_details.id', $id)
        ->join('rabs', 'rab_details.rab_id', '=', 'rabs.id')
        ->select(
            'rab_details.*',
            'rabs.id as rab_detail_name')
            ->first();
    }

    public static function deleteRabDetail($id)
    {
        return DB::table('rab_details')
        ->where('id', $id)
        ->delete();
    }

    public static function getAllRabDetail($rabId)
    {
        return DB::table('rab_details')
        ->where('rab_id', $rabId)
        ->join('rabs', 'rab_details.rab_id', '=', 'rabs.id')
        ->select('rab_details.*',
                'rabs.id as rab_detail_name')
        ->get();
    }

    public static function getTotalRab($rabId)
    {
        return DB::table('rab_details')
        ->select('rab_id', DB::raw('SUM(total_per_item) as total'))
        ->groupBy('rab_id')
        ->first();
    }

    public static function getRabDetailById($id)
    {
        return DB::table('rab_details')
        ->where('rab_details.id', $id)
        ->join('rabs', 'rab_details.rab_id', '=', 'rabs.id')
        ->select(
            'rab_details.*',
            'rabs.id as rab_detail_name'
        )
        ->first();
    }

    public static function getDetailByIdRab($rab_id)
    {
        return DB::table('rab_details')
            ->where('rab_details.rab_id', $rab_id)
            ->join('rabs', 'rab_details.rab_id', '=', 'rabs.id')
            ->select('rab_details.*',
                     'rabs.id as rab_detail_name')
            ->first();
    }

    // =======================================================COUNT TOTAL PER ITEM================================================
    public static function totalPriceItem()
    {
        return DB::table('rab_details')
            ->select('id', 'quantity', 'unit_price', DB::raw('quantity * unit_price as total_per_item'))
            ->get();
    }

}





// {
//     // CREATE, UPDATE, DELETE, EDIT

//     // KODE CAMPUR DENGAN RAB DETAIL
//     public static function create(array $storeData)
//     {
//         return DB::table('rabs')->insert([
//             'name_id' => $storeData['name_id'],
//             'telepon' => $storeData['telepon'],
//             'email' => $storeData['email'],
//             'jobdesk_id' => $storeData['selectJobdesk'],
//             'head_id' => $storeData['selectHead'],
//             'id_jenis_approve' => $storeData['jenis_rab'],
//             'created_at' => now(),
//         ]);
//     }


//     public static function update(array $storeData, $id)
//     {
//         return DB::table('rabs')
//             ->where('id', $id)
//             ->update([
//                 'name_id' => $storeData['name_id'],
//                 'telepon' => $storeData['telepon'],
//                 'email' => $storeData['email'],
//                 'jobdesk_id' => $storeData['selectJobdesk'],
//                 'head_id' => $storeData['selectHead'],
//                 'id_jenis_approve' => $storeData['jenis_rab'],
//                 'updated_at' => now(),
//             ]);
//     }

//     public static function edit($id)
//     {
//         return DB::table('rabs')
//             ->where('rabs.id', $id)
//             ->select('rabs.*')
//             ->first();
//     }

//     public static function delete($id)
//     {
//         return DB::table('rabs')
//             ->where('id', $id)
//             ->delete();
//     }
// // =======================================GET ALL DATA========================================
//     public static function getAllRab()
//     {
//         return DB::table('rabs')
//             ->join('jobdesk', 'rabs.jobdesk_id', '=', 'jobdesk.id')
//             ->join('heads', 'rabs.head_id', '=', 'heads.id')
//             ->join('jenis_approve', 'rabs.id_jenis_approve', '=', 'jenis_approve.id')
//             ->select(
//                 'rabs.*',
//                 'jobdesk.job as jobdesk_name',
//                 'heads.name as head_name',
//                 'jenis_approve.jenis as rab_name'
//             )
//             ->orderBy('rabs.created_at', 'desc')
//             ->get()
//             ->map(function ($rab) {
//                 $rab->created_at = Carbon::parse($rab->created_at);
//                 return $rab;
//             });
//     }

//     public static function getAllByAuth($auth)
//     {
//         return DB::table('rabs')
//             ->where('rabs.name', $auth)
//             ->select('rabs.*')
//             ->get();
//     }

//     public static function getRabById($id)
//     {
//         return DB::table('rabs')
//             ->where('id', '=', $id)
//             ->join('jobdesk', 'rabs.jobdesk_id', '=', 'jobdesk.id')
//             ->join('heads', 'rabs.head_id', '=', 'heads.id')
//             ->join('jenis_approve', 'rabs.id_jenis_approve', '=', 'jenis_approve.id')
//             ->select(
//                 'rabs.*',
//                 'jobdesk.job as jobdesk_name',
//                 'heads.name as head_name',
//                 'jenis_approve.jenis as rab_name'
//             )
//             ->first();
//     }

//     public static function getRabWithDetails($id)
//     {
//         return DB::table('rab_details')
//             ->join('rabs', 'rab_details.rab_id', '=', 'rab_id')
//             ->where('rabs.id', $id)
//             ->select('rabs.*', 'rab_details.*')
//             ->get();
//     }

//     // DEPENDENT DROPDOWN
//     public static function getHeadsRab($jobdesk_id)
//     {
//         return DB::table('rabs')
//             ->where('jobdesk_id', $jobdesk_id)
//             ->select('id', 'job')
//             ->get();
//     }

//     // GET TOTAL PLAN
//     public static function getTotalRab($id)
//     {
//         return DB::table('rabs')
//             ->where('id', '=', $id)
//             ->select('rabs.*')
//             ->sum('total_per_item');
//     }

//     // COUNT TOTAL PER ITEM
//     public static function getTotalPerItem($id)
//     {
//         return DB::table('rabs')
//             ->select('id', 'quantity', 'unit_per_price', DB::raw('quantity * unit_per_price as total_per_item'))
//             ->get();
//     }



// }


// public static function getAllRab($id)
    // {
    //     return DB::table('rabs')
    //         ->where('id', '=', $id)
    //         ->select('rabs.*')
    //         ->get()
    //         ->map(function ($rab) {
    //             $rab->created_at = Carbon::parse($rab->created_at);
    //             return $rab;
    //         });
    // }
