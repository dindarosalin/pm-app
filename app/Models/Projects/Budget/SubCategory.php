<?php

namespace App\Models\Projects\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

use App\Models\Base\BaseModel;

class SubCategory extends BaseModel
{
    // CREATE
    public static function create(array $storeData)
    {
        return DB::table('sub_categories')->insert(
            [
                'category_id' => $storeData['category_id'],
                'name' => $storeData['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    // UPDATE
    public static function update(array $storeData, $id)
    {
        return DB::table('sub_categories')
        ->where('id', $id)
        ->update([
            'category_id' => $storeData['category_id'],
            'name' => $storeData['name'],
            'updated_at' =>now(),
        ]);
    }

    // GET ALL SUB CATEGORY
    public static function getAllSubCategory()
    {
        return DB::table('sub_categories')
        ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
        ->select('sub_categories.*', 'categories.name as category_name')
        ->get();
    }


    // GET SUB CATEGORY BY ID
    public static function getSubCategoryById($id)
    {
        return DB::table('sub_categories')
        ->where('sub_categories.id', $id)
        ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
        ->select('sub_categories.*', 'categories.name as category_name')
        ->first();
    }

    

    // DELETE
    public static function deleteSubCategory($id)
    {
        return DB::table('sub_categories')
        ->where('id', $id)
        ->delete();
    }

    // DEPENDENT DROPDOWN   
    public static function getSubCategoryByCategory($categoryId)
    {
        return DB::table('sub_categories')
        ->where('category_id', $categoryId)
        ->select('id', 'name')
        ->get();
    }

    // COLLECT DATA BUDGET PLAN BASED ON CATEGORY ID
    // get budget plan based on category id
    public static function getBudgetPlan($categoryId)
    {
        return DB::table('plans')
            ->where('category_id', $categoryId) // Misalnya berdasarkan kategori
            ->get(); // Mengambil semua data rencana berdasarkan ID kategori
    }
}











// KODE LAMA
// {
//     protected $table = 'sub_categories';
//     protected $fillable = ['name', 'category_id'];
    
//     // use HasFactory;

//     public function category()
//     { 
//         return $this->belongsTo(Category::class);
//     }

//     public static function createSubCategory(array $storeData)
//     {
//         return DB::table('sub_categories')->insert([
//             'category_name' => $storeData['category_name'],
//             'name' => $storeData['name']
//         ]);
//     }

//     public static function getSubCategory()
//     {
//         return DB::table('sub_categories')
//         ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
//         ->select('sub_categories.*', 'categories.name as category_name')
//         ->get();
//     }
// }

// KODE LAMA
// return $this->belongsTo(Category::class, 'category_name');
// return DB::table('sub_categories')->get();




        // return DB::table('sub_categories')
        // ->where('category_id', $categoryId)
        // ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
        // ->select('sub_categories.*', 'categories.name as category_name')
        // ->get();

         // MODEL FOR EDIT
    // public static function editSubCategory($id)
    // {
    //     return DB::table('sub_categories')
    //     ->where('sub_categories.id', $id)
    //     ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
    //     ->select('sub_categories.*', 'categories.name as category_name')
    //     ->first();
    // }
