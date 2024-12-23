<?php

namespace App\Livewire\Budget\Track;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Track as ModelsTrack;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Livewire\Attributes\On;
use Livewire\Component;
use Throwable;

class Track extends Component
{
    // INISIALISASI
    public $tracks;
    public $categoryId, $sub_category_id, $name, $uom, $quantity = 0, $unit_price = 0, $total_per_item = 0, $total_all = 0;
    public $up_file = []; //save the data in array for ease the user to up many file at once
    public $trackId; //inisialization for id in table tracks
    public $categories; //save list category from table 'categories'
    // COUNT
    public $totalByCategory = []; // simpan total per kategori
    // SELECT
    public $selectCategory = null; //give 'null' because yet the choosen category
    public $selectSubCategory = null;
    public $sub_categories = [];
    



    // RENDER
    // show the interface component and for the calling repeatedly
    public function render()
    {
        // get all data from each table
        $this->tracks = ModelsTrack::getAllTrack();
        $this->categories = Category::getAllCategory();
       
        // for count
        $this->loadBudgets(); //for total count based on category

        return view('livewire.budget.track.track', [
            // for count
            'categories' => $this->categories,
            'tracks' => $this->tracks,
            'totalByCategory' => $this->totalByCategory,
            'total_all' => $this->total_all,
        ]);

        // for count
        $this->tracks = DB::table('tracks')
        ->join('categories', 'tracks.category_id', '=', 'categories.id')
        ->select(
                'categories.name as category_name',
                'tracks.quantity',
                'tracks.unit_price',
                'tracks.total_per_item'
                )
        ->get();
    }

    // STORE
    public function store()
    {
        // $this->validate([
        //     'selectCategory' => 'required|exists:categories,id',
        //     'selectSubCategory' => 'required|exists:sub_categories,id',
        //     'name' => 'required|string|max:255',
        //     'uom' => 'required|string|max:50',
        //     'quantity' => 'required|numeric|min:1',
        //     'unit_price' => 'required|numeric|min:0',
        //     'total_per_item' => 'required|numeric|min:0',
        //     'total_all' => 'required|numeric|min:0',
        //     'up_file' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        // ]);
        
        try {
            if ($this->trackId) {
                ModelsTrack::update([
                    'categoryId' => $this->selectCategory,
                    'sub_category_id' => $this->selectSubCategory,
                    'name' => $this->name,
                    'uom' => $this->uom,
                    'quantity' => $this->quantity,
                    'unit_price' => $this->unit_price,
                    'total_per_item' => $this->total_per_item,
                    'total_all' => $this->total_all,
                    'up_file' => $this->up_file,
                ], $this->trackId);
                session()->flash('success', 'Track Expense Updated Successfully!');
            } else {
                ModelsTrack::create([
                    'categoryId' => $this->selectCategory,
                    'sub_category_id' => $this->selectSubCategory,
                    'name' => $this->name,
                    'uom' => $this->uom,
                    'quantity' => $this->quantity,
                    'unit_price' => $this->unit_price,
                    'total_per_item' => $this->total_per_item,
                    'total_all' => $this->total_all,
                    'up_file' => $this->up_file,
                ]);
                session()->flash('success', 'Track Expense Created Successfully!');
            }
            $this->dispatch('close-offcanvas');
            $this->js("alert('Track Expense Saved!')");
            $this->reset();
        } catch (\Throwable $th) {
            session()->flash('error', $th);
        }
    }    
       

    // EDIT
    public function edit($id)
    {
        $track = ModelsTrack::getTrackById($id);
            $this->trackId = $track->id;
            $this->selectCategory = $track->category_id;
            $this->selectSubCategory = $track->sub_category_id;
            $this->name = $track->name;
            $this->uom = $track->uom;
            $this->quantity = $track->quantity;
            $this->unit_price = $track->unit_price;
            $this->total_per_item = $track->total_per_item;
            $this->total_all = $track->total_all;
            // $this->up_file = json_decode($track->track, true); 

            $this->dispatch('show-edit-offcanvas');        
    }

    // DELETE
    public function delete($id)
    {
        // call method delete from model
        ModelsTrack::deleteTrack($id);
        $this->loadBudgets();
        $this->js("alert('Expense Deleted!')");
    }

    // REFRESH
    #[On('refresh')]
    public function refresh() {}

    // CREATE
    public function show_create_offcanvas()
    {
        $this->dispatch('show-offcanvas');
    }


    // FOR BUTTON CLICK
    public function btnForm_Clicked()
    {
        $this->dispatch('show-create-offcanvas');
    }
    public function btnClose_Offcanvas()
    {
        $this->reset();
        $this->dispatch('close-offcanvas');

    }


    // COUNT
    // method "updated" for automatically counting
    public function updated($propertyName)
    {
        if ($propertyName === 'quantity' || $propertyName === 'unit_price') {
            // count totalperitem when quantity or unit price changes
            $this->total_per_item = $this->quantity * $this->unit_price;
        }
        // after count the totalperitem, loop count total_all
        $this->loadBudgets();
    }

    // COUNT TOTAL
    public function loadBudgets()
    {
        // get all category from track
        $categories = $this->tracks->pluck('category_id')->unique();
        // loop tiap kategori fot count total
        foreach ($categories as $category_id) {
            $this->totalByCategory[$category_id] = ModelsTrack::totalCount($category_id) ?? 0; //simpan total per aktegori
        }

    }


    // DEPENDENT DROPDOWN
    public function loadSubCategory()
    {
        // DB::beginTransaction();

        // try {
        //     // find old category
        //     $oldCategory = DB::table('categories')->where('id', $this->categoryId)->first();

        //     // insert new category
        //     $newCategoryId = DB::table('categories')->insertGetId([
        //         'name' => $this->selectCategory,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);

        //     // gandakan subkategori
        //     $oldSubCategory = DB::table('sub_categories')->where('category_id', $this->categoryId)->get();

        //     foreach ($oldSubCategory as $subCategory) {
        //         DB::table('sub_categories')->insert([
        //             'category_id' => $newCategoryId,
        //             'name' => $this->selectSubCategory, //untuk simpan nilai sub category
        //             'created_at' => now(),
        //             'updated_at' => now(),
        //         ]);
        //     }

        //     DB::commit();
        //     session()->flash('success', 'Category duplicated successfully!');
        //     $this->reset();
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     session()->flash('error', 'Failed to duplicated category: ' . $e->getMessage());
        // }


        if ($this->selectCategory) {
            $this->sub_categories = SubCategory::getSubCategoryByCategory($this->selectCategory);
        }
    }


    // FILTER
    // public function updatingSearch()
    // {
    //     $this->reset();
    // }
    // public function updatingFilters()
    // {
    //     $this->reset();
    // }
    // public function resetFilter()
    // {
    //     $this->reset();
    // }
    // public function sortBy($column)
    // {
    //     if ($this->sortColumn === $column) {
    //         $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    //     } else {
    //         $this->sortColumn = $column;
    //         $this->sortDirection = 'asc';
    //     }
    // }
}

 // validation data
        // $this->validate([
        //     'categoryId' => 'required|exists:categories.id',
        //     'sub_category_id' =>'required|exists:sub_categories.id',
        //     'name' => 'required|string|max:255',
        //     'uom' => 'required|string|max:255',
        //     'quantity' =>'required|numeric|min:1',
        //     'unit_price' => 'required|numeric|min:0',
        //     'total_per_item' => 'required|numeric|0',
        //     // msih opsional
        //     'up_file' => 'nullable|array',
        //     'up_file.*' => 'file|max:10240',
        // ]);
        // try {
        //     if ($this->trackId) {
        //         ModelsTrack::update($this->all(), $this->trackId);
        //         session()->flash('success', 'Expense Track Updated Successfully!!');
        //     } else {
        //         // dd($this->all());
        //         ModelsTrack::create([
        //           'categoryId' => $this->selectCategory,
        //           'sub_category_id' => $this->selectSubCategory,
        //           'name' => $this->name,
        //           'uom' => $this->uom,
        //           'quantity' => $this->quantity,
        //           'unit_price' => $this->unit_price,  
        //         ]);
        //         session()->flash('success', 'Expense Track Created Successfully!!');
        //     }
        //     $this->dispatch('close-offcanvas');
        //     $this->js("alert('Expense Saved!')");
        //     $this->reset();
        //     // $this->js("alert('Track Expense Saved')");
        //     // $this->refresh();
        // } catch (\Throwable $th) {
        //     session()->flash('error', $th);
        //     // throw $th;
        // }

        

        // $this->reset();

    // $this->totalByCategory = ModelsTrack::totalCount();
        // return ($this->totalByCategory); 
        
        

        // get all category unique from tracks
        // $categories = $this->tracks->groupBy('category_id');

        // iterasi melalui tiap kategory dan simpan totalnya
        // foreach ($categories as $category_id) {
        //     $result = ModelsTrack::totalCount($category_id); //call totalCount
        //     //call function totalCount from Model
        //     $this->totalByCategory[$category_id] = $result->total_all ?? 0; //simpan total per kategori

            // $this->totalByCategory[$category_id] = ModelsTrack::totalCount($category_id)
            //                                         ->first()
            //                                         ->total_all ?? 0;

        // $this->totalByCategory = ModelsTrack::totalCount($this->category_id);
    
    // {

    //     $this->totalByCategory = DB::table('tracks')
    //     ->selectRaw('category_id, sum(total_per_item) as total_all')
    //     // ->where('')
    //     ->groupBy('category_id')
    //     // ->SUM('total_per_item');
    //     ->get('total_all');
    //     // ->get();

    //     // dd($this->totalByCategory);
    //     return ($this->totalByCategory);

        // get total price per category
        // $this->totalByCategory = DB::table('tracks')
        // ->join('categories', 'tracks.category_id', '=', 'categories.id')
        // ->select(
        //         'categories.id as category_id',
        //         'categories.name as category_name',
        //         DB::raw("SUM(tracks.total_per_item) as total_item"),
        //         'tracks.created_at' //kolom created at
        //     )
        // ->groupBy('categories.id', 'categories.name', 'tracks.created_at')
        // ->get()
        // ->keyBy('category_id');

        // count total all

        // $this->total_all = (DB::table('tracks')->sum('total_per_item', 0));
    // }

    // FILTER'S
    // public function updatingSearch()
    // {
    //     $this->reset();
    // }

    // public function updatingFilters()
    // {
    //     $this->reset();
    // }

    // public function resetFilter()
    // {
    //     $this->reset();
    // }

    // public function sortBy($column)
    // {
    //     if ($this->sortColumn === $column)
    //     {
    //         $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    //     } else {
    //         $this->sortColumn = $column;
    //         $this->sortDirection = 'asc';
    //     }
    // }

