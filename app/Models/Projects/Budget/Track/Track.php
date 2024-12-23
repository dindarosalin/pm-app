<?php

namespace App\Models\Projects\Budget\Track;

use Carbon\Carbon;
use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

class Track extends BaseModel
{
// ==================================================CREATE, UPDATE , DELETE, EDIT====================================================================================
    // CREATE
    // the left side belongs to column in table 'tracks', will filled on '$storeData'
    public static function create(array $storeData)
    {
        return DB::table('tracks')->insert([
            'name' => $storeData['name'],
            'category_id' => $storeData['selectCategory'],
            'sub_category_id' => $storeData['selectSubCategory'],
            'uom' => $storeData['uom'],
            'quantity' => $storeData['quantity'],
            'unit_price' => $storeData['unit_price'],
            'total_per_item' => $storeData['total_per_item'],
            'attachment' => $storeData['attachment'],
            'purchase_date' => $storeData['purchase_date'],
            'created_at' => now(),
            'id_project' => $storeData['projectId'],
        ]);
        
    }

    // UPDATE
    public static function update(array $storeData, $id)
    {
        return DB::table('tracks')
            ->where('id', $id) //just take the id of each row
            ->update([ //data will be update after input data
                'category_id' => $storeData['selectCategory'],
                'sub_category_id' => $storeData['selectSubCategory'],
                'name' => $storeData['name'],
                'uom' => $storeData['uom'],
                'quantity' => $storeData['quantity'],
                'unit_price' => $storeData['unit_price'],
                'total_per_item' => $storeData['total_per_item'],
                'attachment' => $storeData['attachment'],
                'purchase_date' => $storeData['purchase_date'],
                'updated_at' => now(), 
                'id_project' => $storeData['projectId'],
            ]);

    }

    // EDIT
    // get the concept select category and sub category
    public static function edit($id)
    {
        return DB::table('tracks')
            ->where('tracks.id', $id)
            ->join('categories', 'tracks.category_id', '=', 'categories.id')
            ->join('sub_categories', 'tracks.sub_category_id', '=', 'sub_categories.id')
            ->join('projects', 'tracks.id_project', '=', 'projects.id')
            ->select(
                        'tracks.*',
                        'categories.name as category_name',
                        'sub_categories.name as sub_category_name',
                        'projects.title as project_name'
                    )
            ->first();
    }

    // DELETE
    public static function delete($id)
    {
        return DB::table('tracks')
            ->where('id', $id)
            ->delete();
    }

// ==================================================GET DATA====================================================================================
    // GET ALL TRACK EXPENSE
    public static function getAllTrack($projectId)
    {
        return DB::table('tracks')
            ->where('id_project', '=', $projectId)
            ->join('categories', 'tracks.category_id', '=', 'categories.id')
            ->join('sub_categories', 'tracks.sub_category_id', '=', 'sub_categories.id')
            ->join('projects', 'tracks.id_project', '=', 'projects.id')
            ->select(
                    'tracks.*',
                    'categories.name as category_name',
                    'sub_categories.name as sub_category_name',
                    'projects.title as project_name' 
                    )
            ->orderBy('category_id')
            ->orderBy('sub_category_id')
            ->get()
            ->map(function ($track) { //this method for implement the modification item be array
                // Mengonversi string tanggal menjadi objek Carbon
                $track->created_at = Carbon::parse($track->created_at);
                return $track;
            });
    
        // uji coba query get id per row
    }

    // GET TRACK BY ID
    // for the edit requirement because get all data in table tracks and choosing each id for the row 
    public static function getTrackById($id)
    {
        return DB::table('tracks')
            ->where('tracks.id', $id)
            ->join('categories', 'tracks.category_id', '=', 'categories.id')
            ->join('sub_categories', 'tracks.sub_category_id', '=', 'sub_categories.id')
            ->join('projects', 'tracks.id_project', '=', 'projects.id')
            ->select(
                        'tracks.*',
                        'categories.name as category_name',
                        'sub_categories.name as sub_category_name',
                        'projects.title as project_name' 
                    )
            ->first();
    }

    // GET TRACK BY ID PROJECT
    public static function getTrackByIdProject($id_project)
    {
        return DB::table('tracks')
                ->where('tracks.id_project', $id_project)
                ->join('categories', 'tracks.category_id', '=', 'categories.id')
                ->join('sub_categories', 'tracks.sub_category_id', '=', 'sub_categories.id')
                ->join('projects', 'tracks.id_project', '=', 'projects.id')
                ->select(
                    'tracks.*',
                    'categories.name as category_name',
                    'sub_categories.name as sub_category_name',
                    'projects.title as project_name'
                )
                ->first();
    }

    public static function getTracksByTitle($title)
    {
        return DB::table('tracks')
                ->join ('projects', 'tracks.id_project', '=', 'projects.id')
                ->where ('projects.title', $title)
                ->join ('categories', 'tracks.category_id', '=', 'categories.id')
                ->join ('sub_categories', 'tracks.sub_category_id', '=', 'sub_categories.id')
                ->select(
                    'tracks.*',
                    'categories.name as category_name',
                    'sub_categories.name as sub_category_name',
                    'projects.title as project_name'
                )
                ->orderBy('tracks.created_at', 'desc')
                ->get();
    }

    public static function getTotalExpense($projectId)
    {
        // hitung total expense 
        return DB::table('tracks')
                ->where('id_project','=', $projectId)
                ->sum('total_per_item');
    }

     // GET DETAIL
     public static function detail($id)
     {
         return DB::table('tracks')
                 ->join ('projects', 'tracks.id_project', '=', 'projects.id')
                 ->join ('categories', 'tracks.category_id', '=', 'categories.id')
                 ->join ('sub_categories', 'tracks.sub_category_id', '=', 'sub_categories.id')
                 ->select ('tracks.*', 
                             'projects.title as project_name',
                             'categories.name as category_name',
                             'sub_categories.name as sub_category_name')
                 ->where('tracks.id', $id)
                 ->get();
     
     }

// ==================================================DEPENDENT DROPDOWN/SELECT====================================================================================
    // MAKE THE DEPENDENT DROPDOWN
    // get sub category based on category id
    public static function getSubCategories($category_id)
    {
        return DB::table('sub_categories')
            ->where('category_id', $category_id)
            ->select('id', 'name')
            ->get();
    }

// ==================================================COUNT TOTAL PER ITEM====================================================================================
    // COUNT
    // total per item
    public static function totalPriceItem()
    {
        return DB::table('tracks')
        ->select('id', 'quantity', 'unit_price', DB::raw('quantity * unit_price as total_per_item'))
        ->get(); 
    }

// ==================================================GET IMAGE====================================================================================
    // GET IMAGE
    public static function getFile($id)
    {
        return DB::table('tracks')
                ->select('attachment')
                ->where('tracks.id', $id)
                ->first();
    }

// ==================================================FILTER====================================================================================
    // SEARCH BY KEYWORD
    public static function scopeSearch($query, $searchTerm) 
    {
        return $query->filter(function ($track) use ($searchTerm) {
            return stripos ($track->category_name, $searchTerm) !== false ||
            stripos ($track->sub_category_name, $searchTerm) !== false ||
            stripos ($track->name, $searchTerm) !== false ||
            stripos ($track->purchase_date, $searchTerm) !== false;
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


 // case 'next_week':
            //     $startDate = $currentDate->copy()->addWeek()->startOfWeek();
            //     $endDate = $currentDate->copy()->addWeek()->endOfWeek();
            //     break;
            // case 'last_week':
            //     $startDate = $currentDate->copy()->subWeek()->startOfWeek();
            //     $endDate = $currentDate->copy()->subWeek()->endOfWeek();
            //     break;
           
            // case 'next_month':
            //     $startDate = $currentDate->copy()->addMonth()->startOfMonth();
            //     $endDate = $currentDate->copy()->addMonth()->endOfMonth();
            //     break;
            // case 'last_month':
            //     $startDate = $currentDate->copy()->subMonth()->startOfMonth();
            //     $endDate = $currentDate->copy()->subMonth()->endOfMonth();
            //     break;