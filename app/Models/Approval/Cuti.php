<?php

namespace App\Models\Approval;

use App\Models\Base\BaseModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Cuti extends BaseModel
{
    // protected $table = 'cutis';

    // // =======================================CRUD OPERATIONS==========================================================
    public static function create(array $storeData)
    {
        return DB::table('cutis')->insert([
            'name' => $storeData['name'],
            'jobdesk_id' => $storeData['selectJobdesk'],
            'head_id' => $storeData['selectHead'],
            'email' => $storeData['email'],
            'no_telepon' => $storeData['no_telepon'],
            'jenis_cuti' => $storeData['jenis_cuti'],
            'detail' => $storeData['detail'],
            'tanggal_mulai' => $storeData['tanggal_mulai'],
            'tanggal_akhir' => $storeData['tanggal_akhir'],
            'akumulasi' => self::calculateCutiDays($storeData['tanggal_mulai'], $storeData['tanggal_akhir']),
            'tanggal_pengajuan' => $storeData['tanggal_pengajuan'],
            'nama_kontak_darurat' => $storeData['nama_kontak_darurat'],
            'telp_darurat' => $storeData['telp_darurat'],
            'alamat' => $storeData['alamat'],
            'hubungan_darurat' => $storeData['hubungan_darurat'],
            'nama_delegasi' => $storeData['nama_delegasi'],
            'detail_delegasi' => $storeData['detail_delegasi'],
            'file_up' => $storeData['file_up'],
            'created_at' => now(),
            // 'updated_at' => now()
        ]);
    }

    public static function update($id, array $storeData)
    {
        return DB::table('cutis')
            ->where('id', $id)
            ->update([
                'name' => $storeData['name'],
                'jobdesk_id' => $storeData['jobdesk_id'],
                'head_id' => $storeData['head_id'],
                'email' => $storeData['email'],
                'no_telepon' => $storeData['no_telepon'],
                'jenis_cuti' => $storeData['jenis_cuti'],
                'detail' => $storeData['detail'],
                'tanggal_mulai' => $storeData['tanggal_mulai'],
                'tanggal_akhir' => $storeData['tanggal_akhir'],
                'akumulasi' => self::calculateCutiDays($storeData['tanggal_mulai'], $storeData['tanggal_akhir']),
                'tanggal_pengajuan' => $storeData['tanggal_pengajuan'],
                'nama_kontak_darurat' => $storeData['nama_kontak_darurat'],
                'telp_darurat' => $storeData['telp_darurat'],
                'alamat' => $storeData['alamat'],
                'hubungan_darurat' => $storeData['hubungan_darurat'],
                'nama_delegasi' => $storeData['nama_delegasi'],
                'detail_delegasi' => $storeData['detail_delegasi'],
                'file_up' => $storeData['file_up'],
                'updated_at' => now()
            ]);
    }

    public static function edit($id)
    {
        return DB::table('cutis')
            ->where('id', $id)
            ->select('cutis.*')
            ->first();
    }

    public static function delete($id)
    {
        return DB::table('cutis')
            ->where('id', $id)
            ->delete();
    }

    // // ===========================================GET DATA===========================================================
    public static function getAll()
    {
        return DB::table('cutis')
            ->join('jobdesk', 'cutis.jobdesk_id', '=', 'jobdesk.id')
            ->join('heads', 'cutis.head_id', '=', 'heads.id')
            ->select(
                'cutis.*',
                'jobdesk.job as jobdesk_name',
                'heads.name as head_name'
            )
            ->orderBy('cutis.created_at', 'desc')
            ->get();
    }

    public static function getById($id)
    {
        return DB::table('cutis')
            ->where('cutis.id', $id)
            ->join('jobdesk', 'cutis.jobdesk_id', '=', 'jobdesk.id')
            ->join('heads', 'cutis.head_id', '=', 'heads.id')
            ->select(
                'cutis.*',
                'jobdesk.job as jobdesk_name',
                'heads.name as head_name'
            )
            ->first();
    }

    // // ==============================================UTILITIES====================================================
    public static function calculateCutiDays($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        return $start->diffInDaysFiltered(function(Carbon $date) {
            return !$date->isWeekend();
        }, $end) + 1;
    }



// =======================================CREATE, UPDATE, DELETE, EDIT==========================================================
    // public static function create(array $storeData)
    // {
    //     return DB::table('cutis')->insert([
    //         'name' => $storeData['name'],
    //         'jobdesk_id' => $storeData['selectJobdesk'],
    //         'head_id' => $storeData['selectHead'],
    //         'email' => $storeData['email'],
    //         'no_telepon' => $storeData['no_telepon'],
    //         'jenis_cuti' => $storeData['jenis_cuti'],
    //         'detail' => $storeData['detail'],
    //         'tanggal_mulai' => $storeData['tanggal_mulai'],
    //         'tanggal_akhir' => $storeData['tanggal_akhir'],
    //         // 'akumulasi' => $storeData['akumulasi'],
    //         'akumulasi' => self::cutiDays($storeData['tanggal_mulai'], $storeData['tanggal_akhir']),
    //         'tanggal_pengajuan' => $storeData['tgl_pengajuan'],
    //         'nama_kontak_darurat' => $storeData['nama_kontak_darurat'],
    //         'telp_darurat' => $storeData['telp_darurat'],
    //         'alamat' => $storeData['alamat'],
    //         'hubungan_darurat' => $storeData['hubungan_darurat'],
    //         'nama_delegasi' => $storeData['nama_delegasi'],
    //         'detail_delegasi' => $storeData['detail_delegasi'],
    //         'file_up' => $storeData['file_up'],
    //         'created_at' => now(),
    //     ]);
    // }

    // public static function update(array $storeData, $id)
    // {
    //     return DB::table('cutis')
    //         ->where('id', $id)
    //         ->update([
    //            'name' => $storeData['name'],
    //            'jobdesk_id' => $storeData['selectJobdesk'],
    //            'head_id' => $storeData['selectHead'],
    //            'email' => $storeData['email'],
    //            'no_telepon' => $storeData['no_telepon'],
    //            'jenis_cuti' => $storeData['jenis_cuti'],
    //            'detail' => $storeData['detail'],
    //            'tanggal_mulai' => $storeData['tanggal_mulai'],
    //            'tanggal_akhir' => $storeData['tanggal_akhir'],
    //         //    'akumulasi' => $storeData['akumulasi'],
    //            'akumulasi' => self::cutiDays($storeData['tanggal_mulai'], $storeData['tanggal_akhir']),
    //            'tanggal_pengajuan' => $storeData['tgl_pengajuan'],
    //            'nama_kontak_darurat' => $storeData['nama_kontak_darurat'],
    //            'telp_darurat' => $storeData['telp_darurat'],
    //            'alamat' => $storeData['alamat'],
    //            'hubungan_darurat' => $storeData['hubungan_darurat'],
    //            'nama_delegasi' => $storeData['nama_delegasi'],
    //            'detail_delegasi' => $storeData['detail_delegasi'],
    //            'file_up' => $storeData['file_up'],
    //            'updated_at' => now(),
    //         ]);
    // }

    // public function edit($id)
    // {
    //     return DB::table('cutis')
    //         ->where('cutis.id', $id)
    //         ->join('jobdesk', 'cutis.jobdesk_id', '=', 'jobdesk.id')
    //         ->join('heads', 'cutis.head_id', '=', 'heads.id')
    //         ->select(
    //             'cutis.*',
    //             'jobdesk.job as jobdesk_name',
    //             'heads.name as head_name' 
    //         )
    //         ->first();
    // }

    // public static function delete($id)
    // {
    //     return DB::table('cutis')
    //         ->where('id', $id)
    //         ->delete();
    // }

// ===========================================GET DATA===========================================================
    // public static function getAllCuti()
    // {
    //     return DB::table('cutis')
    //         ->join('jobdesk', 'cutis.jobdesk_id', '=', 'jobdesk.id')
    //         ->join('heads', 'cutis.head_id', '=', 'heads.id')
    //         ->select(
    //             'cutis.*',
    //             'jobdesk.job as jobdesk_name',
    //             'heads.name as head_name' 
    //         )
    //         ->orderBy('jobdesk_id')
    //         ->orderBy('head_id')
    //         ->get();
    // }

    // public static function getCutiById($id)
    // {
    //     return DB::table('cutis')
    //         ->where('cutis.id', $id)
    //         ->join('jobdesk', 'cutis.jobdesk_id', '=', 'jobdesk.id')
    //         ->join('heads', 'cutis.head_id', '=', 'heads.id')
    //         ->select(
    //             'cutis.*',
    //             'jobdesk.job as jobdesk_name',
    //             'heads.name as head_name' 
    //         )
    //         ->first();
    // }

    // public static function detail($id)
    // {
    //     return DB::table('cutis')
    //         ->join('jobdesk', 'cutis.jobdesk_id', '=', 'jobdesk.id')
    //         ->join('heads', 'cutis.head_id', '=', 'heads.id')
    //         ->select(
    //             'cutis.*',
    //             'jobdesk.job as jobdesk_name',
    //             'heads.name as head_name' 
    //         )
    //         ->where('cutis.id', $id)
    //         ->get();
    // }

// ==============================================DEPENDENT DROPDOWN=====================================================
    // public static function getHead($jobdesk_id)
    // {
    //     return DB::table('heads')
    //         ->where('head_id', $jobdesk_id)
    //         ->select('id', 'job')
    //         ->get();
    // }

// ===================================================CALCULATE CUTI DAY=======================================================
    // public static function cutiDays($startDate, $endDate)
    // {
    //     $start = Carbon::parse($startDate);
    //     $end = Carbon::parse($endDate);

    //     return $start->diffInDaysFiltered(function(Carbon $date) {
    //         return !$date->isWeekend();
    //     }, $end) + 1;
    // }
}
