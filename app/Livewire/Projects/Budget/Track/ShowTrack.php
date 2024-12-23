<?php

namespace App\Livewire\Projects\Budget\Track;

use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Projects\Budget\Category as BudgetCategory;
use App\Models\Projects\Budget\Track\Track as TrackTrack;
use App\Models\Projects\Project;


class ShowTrack extends Component
{
    public $tracks;
    public $trackId;
    public $projectId;
    public $name, $uom, $quantity = 1, $unit_price = 0, $total_per_item = 0, $purchase_date;
    public $selectCategory, $selectSubCategory;
    public $total_all;
    public $exportTrack;
    // upfile
    public $file = [];
    // filter
    public $search;
    public $filters = [];
    public $fromToDate; 
    public $timeFrame = [];
    public $fromDate = [];
    public $toDate = [];

    public $id;
    public $title;
    
    public function render()
    {
        $this->loadTrack();

        // filter
        $category = BudgetCategory::getAllCategory();

        $this->tracks = $this->filter($this->tracks);
        $this->total_all = $this->tracks->sum('total_per_item'); //hitung otomatis saat filter        
        // dd($this->tracks);
        

        // dd($this->filter);

        return view('livewire.projects.budget.track.show-track', [
            'tracks' => $this->tracks,
            'categories' => $category,
        ]);
    }


    // public function mount()
    // {
    //     $this->trackId;
    //     $this->projectId;
    //     // up file
    //     $this->file = TrackTrack::getFile($this->trackId);
    //     // $this->nota = Track::detail($this->trackId);
    // }

    public function mount($title)
    {
        $projects = Project::getTitleProject($title);

        if ($projects) {
            $this->projectId = $projects->id;
            $this->loadTrack();
        } else {
             // Tangani jika proyek tidak ditemukan
             session()->flash('error', 'Project not found.');
             return redirect()->route('budget.show.budget'); // Redirect jika tidak ditemukan
        }
    }

    public function notaDetail($id){
        return redirect()->route('projects.budget.detail.nota', ['projectId' => $this->projectId, 'id'=> $id]);
    } 

// ==================================================DELETE====================================================================================
    // DELETE

    public function delete($id)
    {
        // $value = Track::detail($id);
        // $attachment = $value[0]->attachment;
        // if ($attachment) {
        //     Storage::delete($attachment, 'public');
        // }

        TrackTrack::delete($id);
        $this->js("alert('Expense Deleted!')");
    }

// ==================================================HANDLE OFF CANVAS====================================================================================
    // OFF CANVAS CREATE

    public function btnTrack_Clicked()
    {
        $this->dispatch('show-create-offcanvas');
    }

// ==================================================LOAD OTOMATICALLY====================================================================================
    // LOAD OTOMATIS
    
    #[On('trackUpdated')]
    public function loadTrack()
    {
        $this->tracks = TrackTrack::getAllTrack($this->projectId);
        
    }

// ==================================================DOWNLOAD WITH DOMPDF====================================================================================
     // DOWNLOAD

     public function generatePdf()
     {
         $data = [
             'exportTrack' => $this->exportTrack,
             'projectName' => Project::getById($this->projectId)->title,
             'tracks' => $this->tracks,
             'total_all' => $this->total_all
         ];
 
         $pdf = Pdf::loadView('pdf.track-pdf', $data);
 
         return response()->streamDownload(function() use ($pdf) {
             echo $pdf->stream();
         }, 'ExpenseTrack.pdf');
    }

// ==================================================FILTER====================================================================================
    // FILTER
    //FILTER TRACK
    public function filter($tracks)
    {
        // search
        if ($this->search) {
            $tracks = TrackTrack::scopeSearch($tracks, $this->search);
        }

        // filter kolom
        // dd($this->filters);
        if ($this->filters) {
            foreach ($this->filters as $column => $value) {
                if (!empty($value)) {
                    $tracks = TrackTrack::scopeFilter($tracks, $column, $value);
                }
            }
        }

        // filter time frame dan date range
        if ($this->timeFrame) {
            foreach ($this->timeFrame as $column => $this->fromToDate) {
                if ($this->fromToDate === 'custom-created') {
                    $tracks = TrackTrack::scopeFilterByDateRange($tracks, $this->fromDate, $this->toDate, $column);
                } else {
                    $tracks = TrackTrack::scopeFilterByTimeFrame($tracks, $column, $this->fromToDate);
                }
            }
        }
        return $tracks;
    }

    
    // // RESET FILTER
    public function resetFilter()
    {
       $this->reset(['filters', 'search', 'timeFrame']);
    }

}













 //   GET CATEGORY
//    public function getCategory()
//    {
//     return DB::table('categories')
//             -> orderBy('name', 'asc')
//             ->get();
//    }
//     //   GET DATA TRACKS BASED ON CATEGORY 
//    public function getTrack()
//    {
//     return Track::getByCategory($this->byCategory);
//    }

 // $this->total_all = $this->totalPrice($this->projectId);