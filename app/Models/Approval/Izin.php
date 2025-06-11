<?php

namespace App\Models\Approval;

use App\Models\Base\BaseModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Izin extends BaseModel
{
    // CREATE, UPDATE, DELETE, EDIT
    public static function create(array $storeData)
    {
        // dd($storeData);
        return DB::table('izins')->insert([
            'name' => $storeData['name'],
            'jobdesk_id' => $storeData['selectJobdesk'],
            'head_id' => $storeData['selectHead'],
            'email' => $storeData['email'],
            'telepon' => $storeData['telepon'],
            'id_jenis_approve' => $storeData['jenis_izin'],
            'detail_izin' => $storeData['detail_izin'],
            'tgl_mulai' => $storeData['tgl_mulai'],
            'tgl_akhir' => $storeData['tgl_akhir'],
            'akumulasi' => self::calculateIzin($storeData['tgl_mulai'], $storeData['tgl_akhir']),
            'tgl_ajuan' => $storeData['tgl_ajuan'],
            'nama_darurat' => $storeData['nama_darurat'],
            'telp_darurat' => $storeData['telp_darurat'],
            'relasi_darurat' => $storeData['relasi_darurat'],
            'alamat' => $storeData['alamat'],
            'nama_delegasi' => $storeData['nama_delegasi'],
            'detail_delegasi' => $storeData['detail_delegasi'],
            'file_izin' => $storeData['file_izin'],
            'created_at' => now(),
        ]);
    }

    public static function update(array $storeData, $id)
    {
        return DB::table('izins')
            ->where('id', $id)
            ->update([
                'name' => $storeData['name'],
                'jobdesk_id' => $storeData['jobdesk_id'],
                'head_id' => $storeData['head_id'],
                'email' => $storeData['email'],
                'telepon' => $storeData['telepon'],
                'id_jenis_approve' => $storeData['id_jenis_approve'],
                'detail_izin' => $storeData['detail_izin'],
                'tgl_mulai' => $storeData['tgl_mulai'],
                'tgl_akhir' => $storeData['tgl_akhir'],
                'akumulasi' => self::calculateIzin($storeData['tgl_mulai'], $storeData['tgl_akhir']),
                'tgl_ajuan' => $storeData['tgl_ajuan'],
                'nama_darurat' => $storeData['nama_darurat'],
                'telp_darurat' => $storeData['telp_darurat'],
                'relasi_darurat' => $storeData['relasi_darurat'],
                'alamat' => $storeData['alamat'],
                'nama_delegasi' => $storeData['nama_delegasi'],
                'detail_delegasi' => $storeData['detail_delegasi'],
                'file_izin' => $storeData['file_izin'],
                'updated_at' => now(),
            ]);
    }

    public function edit($id)
    {
        return DB::table('izins')
            ->where('izins.id', $id)
            ->select('izins.*')
            ->first();
    }

    public static function delete($id)
    {
        return DB::table('izins')
            ->where('id', $id)
            ->delete();
    }

    //============================================GET DATA=========================================
    public static function getAll()
    {
        return DB::table('izins')
            ->join('jobdesk', 'izins.jobdesk_id', '=', 'jobdesk.id')
            ->join('heads', 'izins.head_id', '=', 'heads.id')
            ->join('jenis_approve', 'izins.id_jenis_approve', '=', 'jenis_approve.id')
            ->select(
                'izins.*', 
                'jobdesk.job as jobdesk_name',
                'heads.name as head_name',
                'jenis_approve.jenis as izin_name'
            )
            ->orderBy('izins.created_at', 'desc')
            ->get();
    }

    public static function getAllByAuth($auth)
    {
        return DB::table('izins')
            ->where('izins.name', $auth)
            ->get();
    }

    public static function getIzinById($id)
    {
        return DB::table('izins')
            ->where('izins.id', $id)
            ->join('jobdesk', 'izins.jobdesk_id', '=', 'jobdesk.id')
            ->join('heads', 'izins.head_id', '=', 'heads.id')
            ->join('jenis_approve', 'izins.id_jenis_approve', '=', 'jenis_approve.id')
            ->select(
                'izins.*', 
                'jobdesk.job as jobdesk_name',
                'heads.name as head_name',
                'jenis_approve.jenis as izin_name'
            )
            ->first();
    }

    public static function detailIzin($id)
    {
        return DB::table('izins')
            ->join ('jobdesk', 'izins.jobdesk_id', '=', 'jobdesk.id')
            ->join ('heads', 'izins.head_id', '=', 'heads.id')
            ->join ('jenis_approve', 'izins.id_jenis_approve', '=', 'jenis_approve.id')
            ->select(
                'izins.*',
                'jobdesk.job as jobdesk_name',
                'heads.name as head_name',
                'jenis_approve.jenis as izin_name'
            )
            ->where('izins.id', $id)
            ->first();
    }

// DEPENDENT DROPDOWN
    // public static function getHeads($jobdesk_id)
    // {
    //     return DB::table('izins')
    //         ->where('jobdesk_id', $jobdesk_id)
    //         ->select('id', 'job')
    //         ->get();
    // }

//  COUNT AKUMULATION
    public static function calculateIzin($tgl_mulai, $tgl_akhir)
    {
        $start = Carbon::parse($tgl_mulai);
        $end = Carbon::parse($tgl_akhir);

        return $start->diffInDaysFiltered(function(Carbon $date) {
            return !$date->isWeekend();
        }, $end) + 1;
    }

    public static function getIzin()
    {
        return DB::table('izins')
            ->join('jenis_approve', 'izins.id_jenis_approve', '=', 'jenis_approve.id')
            ->select([
                'izins.id as id',
                'jenis_approve.jenis as jenis_izin',
                'izins.tgl_ajuan as tgl_ajuan',
            ])
            ->orderBy('izins.tgl_ajuan', 'desc')
            ->get();
    }
}
