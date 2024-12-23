<?php

namespace App\Models\Projects\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\Base\BaseModel;

class Category extends BaseModel
{
    protected $table = 'categories';

    // CREATE
    public static function create(array $storeData)
    {
        return DB::table('categories')->insert(
            [
                'name' => $storeData['name'],
                'created_at' => now(), //simpan data saat create
                'updated_at' => now(), //simpan saat diubah
            ]
        );
    }

    // UPDATE
    public static function update(array $storeData, $id)
    {
        return DB::table('categories')
        ->where('id', $id)
        ->update([
            'name' => $storeData['name'],
            'updated_at' =>now(),
        ]);
    }

    // GET ALL CATEGORY
    public static function getAllCategory()
    {
        return DB::table('categories')
        ->get(); //ambil semua data dari tabel categories
    }

    // GET CATEGORY BY ID
    public static function getCategoryById($id)
    {
        // kode baru
        return DB::table('categories')
        ->where('id', $id) //ambil data based on id
        ->first(); //ambil satu baris data
    }

    // GET ID 'TENAGA KERJA'
    public static function getTenagaKerja()
    {
        return DB::table('categories')
        ->where('name', 'Tenaga Kerja')
        ->first();
    }

    // DELETE
    public static function delete($id)
    {
        return DB::table('categories')
        ->where('id', $id)
        ->delete(); //hapus data based on id
    }

    // RELASI
    public static function getSubCategory($categoryId)
    {
        return DB::table('sub_categories')
        ->where('category_id', $categoryId)
        ->get();
    }
}

