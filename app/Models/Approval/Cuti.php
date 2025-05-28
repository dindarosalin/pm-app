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
            'id_jenis_approve' => $storeData['jenis_cuti'],
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
                'id_jenis_approve' => $storeData['jenis_cuti'],
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
            ->join('jenis_approve', 'cutis.id_jenis_approve', '=', 'jenis_approve.id')
            ->select(
                'cutis.*',
                'jobdesk.job as jobdesk_name',
                'heads.name as head_name',
                'jenis_approve.jenis as cuti_name'
            )
            ->orderBy('cutis.created_at', 'desc')
            ->get();
    }

    public static function getAllByAuth($auth)
    {
        return DB::table('cutis')
            ->where('cutis.name', $auth)
            ->get();
    }

    public static function getById($id)
    {
        return DB::table('cutis')
            ->where('cutis.id', $id)
            ->join('jobdesk', 'cutis.jobdesk_id', '=', 'jobdesk.id')
            ->join('heads', 'cutis.head_id', '=', 'heads.id')
            ->join('jenis_approve', 'cutis.id_jenis_approve', '=', 'jenis_approve.id')
            ->select(
                'cutis.*',
                'jobdesk.job as jobdesk_name',
                'heads.name as head_name',
                'jenis_approve.jenis as cuti_name'
            )
            ->first();
    }

    public static function detailCuti($id)
    {
        return DB::table('cutis')
            ->join ('jobdesk', 'cutis.jobdesk_id', '=', 'jobdesk.id')
            ->join ('heads', 'cutis.head_id', '=', 'heads.id')
            ->join ('jenis_approve', 'cutis.id_jenis_approve', '=', 'jenis_approve.id')
            ->select(
                'cutis.*',
                'jobdesk.job as jobdesk_name',
                'heads.name as head_name',
                'jenis_approve.jenis as cuti_name'
            )
            ->where('cutis.id', $id)
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

    // ========================================================GET CUTI================================================
    public static function getCuti()
    {
        return DB::table('cutis')
            ->join('jenis_approve', 'cutis.id_jenis_approve', '=', 'jenis_approve.id')
            ->select([
                'cutis.id as id',
                'jenis_approve.jenis as jenis_cuti',
                'cutis.tanggal_pengajuan as tanggal_pengajuan',
            ])
            ->orderBy('cutis.tanggal_pengajuan', 'desc')
            ->get();
    }
}
