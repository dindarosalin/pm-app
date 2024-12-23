<?php

namespace App\Livewire\Projects\Budget\Track;

use App\Models\Projects\Budget\Category as BudgetCategory;
use App\Models\Projects\Budget\SubCategory as BudgetSubCategory;
use App\Models\Projects\Budget\Track\Track as TrackTrack;
use App\Models\Projects\Project;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use Throwable;


class FormTrack extends Component
{
    use WithFileUploads;

    public $tracks;
    public $projectId;
    public $trackId;
    public $category_id, $sub_category_id, $name, $uom, $quantity = 1, $unit_price = 0, $purchase_date;
    public $selectCategory, $selectSubCategory;
    public $total_per_item;
    public $sub_categories = [];
    public $categories;
   
    // make the rule for processing the attachments
    #[Rule('required|sometimes|image|max:1024')]
    public $newAttachment; //simpan file baru
    public $attachment; //simpan path file 






    public function render()
    {
        $this->categories = BudgetCategory::getAllCategory(); // ambil berulang all data category agar tidak hilang ketika reset
        return view('livewire.projects.budget.track.form-track');
    }

    // public function mount()
    // {
    //     $this->tracks = TrackTrack::getAllTrack($this->projectId);
    // }

    public function mount($title)
    {
        $project = Project::getTitleProject($title);

        if ($project) {
            $this->projectId = $project->id;
            $this->tracks = TrackTrack::getAllTrack($this->projectId);
        } else {
            // Tangani jika proyek tidak ditemukan
            session()->flash('error', 'Project not found.');
            return redirect()->route('budget.show.budget'); // Redirect jika tidak ditemukan
        }
    }

// ==================================================STORE (CREATE & UPDATE), EDIT,====================================================================================
    // CREATE & UPDATE (STORE)
    public function store()
    {
        // validate
        $this->validate([
            'selectCategory' => 'required',
            'selectSubCategory' => 'required',
            'name' => 'required|string|max:255',
            'uom' => 'required|string|max:50',
            'quantity' => 'required|min:1',
            'unit_price' => 'required|min:0',
            'purchase_date' => 'required|date',
            'newAttachment' => 'nullable|image|max:1024',
        ]);

        try {
            if ($this->trackId) {
                // dd($this->trackId);

                $this->total_per_item = $this->totalItem($this->quantity, $this->unit_price);

                if ($this->newAttachment) {
                    Storage::delete($this->attachment, 'public');
                    $this->newAttachment = $this->newAttachment->store('budgets', 'public');
                    // $attachment = $this->newAttachment;
                }
                DB::table('tracks')->where('id', $this->trackId)->update([
                    'name' => $this->name,
                    'category_id' => $this->selectCategory,
                    'sub_category_id' => $this->selectSubCategory,
                    'uom' => $this->uom,
                    'quantity' => $this->quantity,
                    'unit_price' => $this->unit_price,
                    'total_per_item' => $this->total_per_item,
                    'purchase_date' => $this->purchase_date,
                    'attachment' => $this->newAttachment ?? $this->attachment,
                    'id_project' => $this->projectId,
                ]);
                $this->js("alert('Expense Updated Successfully !')");
            } else {
                $this->total_per_item = $this->totalItem($this->quantity, $this->unit_price);

                if ($this->newAttachment) {
                    $this->newAttachment = $this->newAttachment->store('budgets', 'public');
                }
                TrackTrack::create ([
                    'name' => $this->name,
                    'selectCategory' => $this->selectCategory,
                    'selectSubCategory' => $this->selectSubCategory,
                    'uom' => $this->uom,
                    'quantity' => $this->quantity,
                    'unit_price' => $this->unit_price,
                    'attachment' => $this->newAttachment,
                    'total_per_item' => $this->total_per_item,
                    'purchase_date' => $this->purchase_date,
                    'projectId' => $this->projectId,
                ]);
                $this->js("alert('Expense Created Successfully!')");
            }
                $this->dispatch('close-offcanvas'); //offcanvas tutup otomatis
                $this->dispatch('trackUpdated'); //load otomatis 
                $this->resetForm(); //reset otomatis
        } catch (\Throwable $th){
            throw $th;
            $this->js("alert('Unsaved')");
        }
    }

//    public $listeners = ['editTrack'=>'edit'];
    // EDIT
    #[On('edit')]
    public function edit($id)
    {
        $track = TrackTrack::getTrackById($id);

        $this->trackId = $track->id;
        $this->selectCategory = $track->category_id;
        $this->selectSubCategory = $track->sub_category_id;
        $this->name = $track->name;
        $this->uom = $track->uom;
        $this->quantity = $track->quantity;
        $this->unit_price = $track->unit_price;
        $this->purchase_date = $track->purchase_date;
        $this->attachment = $track->attachment;
       
        $this->dispatch('show-edit-offcanvas');
    }

// ==================================================COUNT TOTAL PER ITEM====================================================================================
    // COUNT TOTAL PER ITEM
    public function totalItem($qty, $price)
    {
        return $this->total_per_item = $qty * $price;
    }

// ==================================================DEPENDENT DROPDOWN====================================================================================
    // DEPENDENT DROPDOWN
    public function loadSubCategory()
    {
        if ($this->selectCategory) {
            $this->sub_categories = BudgetSubCategory::getSubCategoryByCategory($this->selectCategory);
        }
    }

// ==================================================H========ANDLE OFF CANVAS============================================================================
    // HANDLE CLOSE
    public function btnClose_Offcanvas()
    {
        $this->resetForm();
        $this->dispatch('close_offcanvas');
    }

// ==================================================RESET====================================================================================
    // RESET FORM
    #[On('reset')]
    public function resetForm()
    {
        $this->selectCategory = '';
        $this->selectSubCategory = '';
        $this->name = '';
        $this->uom = '';
        $this->quantity = '';
        $this->unit_price = '';
        $this->purchase_date = '';
        $this->attachment = '';
        $this->trackId = '';
    }

    
}











  