<?php

namespace App\Models\Projects\Budget\Plan;

use Illuminate\Support\Facades\DB;
use App\Models\Base\BaseModel;
use Carbon\Carbon;

use function Laravel\Prompts\select;

class Plan extends BaseModel
{
// ==================================================CREATE, UPDATE , DELETE, EDIT====================================================================================
    // CREATE
    public static function create(array $storeData)
    {
        // dd($storeData);
        return DB::table('plans')->insert([
            'name' => $storeData['name'],
            'category_id' => $storeData['selectCategory'],
            'sub_category_id' => $storeData['selectSubCategory'],
            'uom' => $storeData['uom'],
            'quantity' => $storeData['quantity'],
            'unit_price' => $storeData['unit_price'],
            'total_per_item' =>$storeData['total_per_item'],
            'created_at'=>now(),
            'id_project' => $storeData['projectId'],
        ]);
         // the left side belongs to column in table 'plans', will filled on '$storeData'
    }


    // UPDATE
    public static function update(array $storeData, $id)
    {
        return DB::table('plans')
                ->where('id', $id) // just take the ID each row
                ->update([          // data will be update after input data
                    'category_id' => $storeData['selectCategory'],
                    'sub_category_id' => $storeData['selectSubCategory'],
                    'name' => $storeData['name'],
                    'uom' => $storeData['uom'],
                    'quantity' => $storeData['quantity'],
                    'unit_price' => $storeData['unit_price'],
                    'total_per_item' => $storeData['total_per_item'],
                    'id_project' => $storeData['projectId'],
                ]);
        // the function accept value based on $storeData and ID of each row ont table plans
    }

    // EDIT
    public static function edit($id)
    {
        return DB::table('plans')
                ->where('plans.id', $id)
                ->join('categories', 'plans.category_id', '=', 'categories.id')
                ->join('sub_categories', 'plans.sub_category_id', '=', 'sub_categories.id')
                ->join('projects', 'plans.id_project', '=', 'projects.id')
                ->select(
                    'plans.*',
                    'categories.name as category-name', 
                    'sub_categories.name as sub_category_name',
                    'projects.title as project_name'
                )
                ->first();
        // get the concept select category and sub category
    }

    // DELETE
    public static function delete($id)
    {
        return DB::table('plans')
                ->where('id', $id)
                ->delete();
    }

 
// ==================================================GET DATA====================================================================================
    // GET ALL BUDGET PLAN
    // public static function getAllPlan($projectId)
    // {
    //     return DB::table('plans')
    //             ->where('id_project', '=', $projectId)
    //             ->join('categories', 'plans.category_id', '=', 'categories.id')
    //             ->join('sub_categories', 'plans.sub_category_id', '=', 'sub_categories.id')
    //             ->join('projects', 'plans.id_project', '=', 'projects.id')
    //             ->select(
    //                         'plans.*',
    //                         'categories.name as category_name', 
    //                         'sub_categories.name as sub_category_name',
    //                         'projects.title as project_name'
    //                     )
    //             ->orderBy('category_id')
    //             ->orderBy('sub_category_id')
    //             ->get();
    // }

    public static function getAllPlan($projectId)
    {
        return DB::table('plans')
                ->where('id_project', $projectId)
                ->join('categories', 'plans.category_id', '=', 'categories.id')
                ->join('sub_categories', 'plans.sub_category_id', '=', 'sub_categories.id')
                ->join('projects', 'plans.id_project', '=', 'projects.id')
                ->select(
                            'plans.*',
                            'categories.name as category_name', 
                            'sub_categories.name as sub_category_name',
                            'projects.title as project_name'
                        )
                ->orderBy('plans.category_id')
                ->orderBy('plans.sub_category_id')
                ->get();
    }

    public static function getTotalPlan($projectId)
    {
        return DB::table('plans')
                ->select('id_project', DB::raw('SUM(total_per_item) as total'))
                ->where('id_project','=', $projectId)
                ->groupBy('id_project')
                ->first();
               
                // ->sum('total_per_item');            
    }

    // GET BY ID
    public static function getPlanById($id)
    {
        return DB::table('plans')
                ->where('plans.id', $id)
                ->join('categories', 'plans.category_id', '=', 'categories.id')
                ->join('sub_categories', 'plans.sub_category_id', '=', 'sub_categories.id')
                ->join('projects', 'plans.id_project', '=', 'projects.id')
                ->select(
                    'plans.*',
                    'categories.name as category-name', 
                    'sub_categories.name as sub_category_name',
                    'projects.title as project_name'
                )
                ->first();
         // especially for requirement edit, (Because get all data in table plans and choosing ID each row)
    }

    // GET PLAN BY ID PROJECT
    public static function getPlanByIdProject($id_project)
    {
        return DB::table('plans')
                ->where('plans.id_project', $id_project)
                ->join('categories', 'plans.category_id', '=', 'categories.id')
                ->join('sub_categories', 'plans.sub_category_id', '=', 'sub_categories.id')
                ->join('projects', 'plans.id_project', '=', 'projects.id')
                ->select(
                    'plans.*',
                    'categories.name as category-name', 
                    'sub_categories.name as sub_category_name',
                    'projects.title as project_name'
                )
                ->first();
    }

    public static function getPlansByTitle($title)
    {
        return DB::table('plans')
                ->join ('projects', 'plans.id_project', '=', 'projects.id')
                ->where ('projects.title', $title)
                ->join ('categories', 'plans.category_id', '=', 'categories.id')
                ->join ('sub_categories', 'plans.sub_category_id', '=', 'sub_categories.id')
                ->select(
                    'plans.*',
                    'categories.name as category_name',
                    'sub_categories.name as sub_category_name',
                    'projects.title as project_name'
                )
                ->orderBy('plans.created_at', 'desc')
                ->get();
    }

// ==================================================DEPENDENT DROPDOWN/SELECT====================================================================================
    // MAKE THE DEPENDENT DROPDOWN
    // get sub category based on category id
    public static function getSubCategories($category_id)    // get sub category based on category_id
    {
        return DB::table('sub_categories')
            ->where('category_id', $category_id)
            ->select('id', 'name')
            ->get();

    }

// ==================================================COUNT TOTAL PER ITEM====================================================================================
    // COUNT
    // count total per item
    public static function totalPriceItem()
    {
        return DB::table('plans')
                ->select('id', 'quantity', 'unit_price', DB::raw('quantity * unit_price as total_per_item'))
                ->get();

                            
    }

// ==================================================FILTER====================================================================================
    // SEARCH BY KEYWORD
    public static function scopeSearch($query, $searchTerm) 
    {
        return $query->filter(function ($plan) use ($searchTerm) {
            return stripos ($plan->category_name, $searchTerm) !== false ||
            stripos ($plan->sub_category_name, $searchTerm) !== false ||
            stripos ($plan->name, $searchTerm) !== false;
            // stripos ($plan->purchase_date, $searchTerm) !== false;
        });
    }

    // FILTER TRACK CATEGORY
    public static function scopeFilter($query, $column, $value)
    {
        if ($column == 'category_id') {
            return $query->where('category_id', $value);
        }
        return $query->where($column, $value);
    }





   // FILTER (DAILY - WEEKLY - MONTHLY - ALL)
    public static function scopeFilterByTimeFrame($query, $column, $timeFrame)
    {
        $currentDate = Carbon::now();

        $query->each(function ($item) {
            $item->purchase_date = Carbon::parse($item->purchase_date);
        });

        switch ($timeFrame) {
            case 'today':
                $startDate = $currentDate->copy()->startOfDay();
                $endDate = $currentDate->copy()->endOfDay();
                break;
            case 'yesterday':
                $startDate = $currentDate->copy()->subDay()->startOfDay();
                $endDate = $currentDate->copy()->subDay()->endOfDay();
                break;
            case 'week':
                $startDate = $currentDate->copy()->startOfWeek();
                $endDate = $currentDate->copy()->endOfWeek();
                break;
            case 'month':
                $startDate = $currentDate->copy()->startOfMonth();
                $endDate = $currentDate->copy()->endOfMonth();
                break;
            case 'year':
                $startDate = $currentDate->copy()->startOfYear();
                $endDate = $currentDate->copy()->endOfYear();
                break;
            case 'all':
            default:
                return $query;
            
        }

        return $query->whereBetween($column, [$startDate, $endDate]);
    }

    // FILTER DATE RANGE
    public static function scopeFilterByDateRange($query, $fromDate, $toDate, $column)
    {
        if ($fromDate !== null && $toDate !== null) {
            return $query->whereBetween($column, [$fromDate, $toDate]);
        } elseif ($fromDate !== null) {
            return $query->where($column, '>=', $fromDate);
        } elseif ($toDate !== null) {
            return $query->where($column, '<=', $toDate);
        }
        return $query;
    }
}