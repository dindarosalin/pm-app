<?php

namespace App\Models\Approval;

use App\Models\Base\BaseModel;
use Carbon\Carbon;
use Faker\Provider\Base;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PengadaanProyek extends BaseModel
{
    //======================================CREATE, UPDATE, DELETE, EDIT========================================
    public static function create(array $storeData)
    {
        return DB::table('proyeks')->insert([
            'nama_proyek' => $storeData['nama_proyek'],
            'kode_dokumen' => $storeData['kode_dokumen'],
            'tanggal_ajuan' => $storeData['tanggal_ajuan'],
            'id_departement' => $storeData['id_department'],
            'nama_pemohon' => $storeData['nama_pemohon'],
            'lokasi' => $storeData['lokasi'],
            'ditujukan' => $storeData['ditujukan'],
            'tanggal_setuju' => $storeData['tanggal_setuju'],
            'created_at' => now(),
        ]);
    }

    public static function update(array $storeData, $id)
    {
        return DB::table('proyeks')
            ->where('id', $id)
            ->update([
                'nama_proyek' => $storeData['nama_proyek'],
                'kode_dokumen' => $storeData['kode_dokumen'],
                'tanggal_ajuan' => $storeData['tanggal_ajuan'],
                'id_departement' => $storeData['id_department'],
                'nama_pemohon' => $storeData['nama_pemohon'],
                'lokasi' => $storeData['lokasi'],
                'ditujukan' => $storeData['ditujukan'],
                'tanggal_setuju' => $storeData['tanggal_setuju'],
                'updated_at' => now(),
            ]);
    }

    public static function edit($id)
    {
        return DB::table('proyeks')
            ->where('proyeks.id', $id)
            ->select('proyeks.*')
            ->first();
    }

    public static function delete($id)
    {
        return DB::table('proyeks')
            ->where('id', $id)
            ->delete();
    }
    // ======================================GET ALL DATA========================================
    public static function getAllPengadaanProyek()
    {
        return DB::table('proyeks')
            ->join('jobdesk', 'proyeks.jobdesk.id', '=', 'proyeks.id_department')
            ->select('proyeks.*',
                     'jobdesk.job as name_jobdesk')
            ->get()
            ->map(function ($proyeks) {
                $proyeks->created_at = Carbon::parse($proyeks->created_at);
                return $proyeks;
            });
    }

    public static function getPengadaanProyekById($id)
    {
        return DB::table('proyeks')
        ->where('proyeks.id', $id)
        ->join('jobdesk', 'proyeks.jobdesk.id', '=', 'proyeks.id_department')
        ->select('proyeks.*',
                 'jobdesk.job as name_department')
        ->first();   
    }
}
