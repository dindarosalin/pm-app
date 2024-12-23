<?php

/** Note
 * Code ini digunakan untuk menampilkan data dari release note yang nantinya ditampilkan dalam bentuk tabel
 * Digunakan juga untuk redirect ke detail release note
 */

/** TODO
 * Sortir release note sesuai id project
 */

namespace App\Livewire\Projects\Release;

use App\Models\task;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Http\Controllers\ReleaseNote;
use Illuminate\Support\Facades\Storage;
use App\Models\Projects\ReleaseNote\ReleaseNotes;

class ShowReleaseNote extends Component
{
    // public $releaseNotes;
    public $projectId;

    public $timeFrame = 'all'; //all, weekly, monthly, yearly
    public $search;
    public $filters;
    public $sortColumn;
    public $fromDate, $toDate;


    /**
     * #[On('formSubmitted')]
     * Listening Event yang dilakukan setelah submit
     * untuk reload data agar langsung berubah tanpa refresh
     */
    #[On('formSubmitted')]
    public function mount()
    {
        // dd($taskDone);
    }

    public function filter($releaseNotes)
    {
        // Pencarian
        if ($this->search) {
            // dd($releaseNotes);
            $releaseNotes = ReleaseNotes::scopeSearch($releaseNotes, $this->search);
        }

        // Filter berdasarkan kolom
        // if ($this->filters) {
        //     foreach ($this->filters as $column => $value) {
        //         if (!empty($value)) {
        //             $releaseNotes = ReleaseNotes::scopeFilter($releaseNotes, $column, $value);
        //         }
        //     }
        // }

        // Sorting
        // if ($this->sortColumn) {
        //     $releaseNotes = ReleaseNotes::scopeSorting($releaseNotes, $this->sortColumn, $this->sortDirection);
        // }

        // Filter berdasarkan time frame
        // if ($this->timeFrame) {
        //     $releaseNotes = ReleaseNotes::scopeFilterByTimeFrame($releaseNotes, $this->timeFrame);
        // }

        // Filter berdasarkan date range
        // if ($this->fromDate && $this->toDate) {
        //     $releaseNotes = ReleaseNotes::scopeFilterByDateRange($releaseNotes, $this->fromDate, $this->toDate);
        // }

        return $releaseNotes;
    }

    public function edit($id)
    {
        return $this->dispatch('edit', $id);
    }

    public function alertConfirm($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'message' => 'Are you sure?',
            'text' => 'You won\'t be able to revert this!',
            'id' => $id,
            'dispatch' => 'delete'
        ]);
    }

    #[On('delete')]
    public function delete($id)
    {
        $value = ReleaseNotes::detail($id);
        $attachments = $value[0]->attachments;
        if ($attachments) {
            // Delete exists file
            Storage::delete($attachments, 'public');
        }
        // dd($id);
        ReleaseNotes::delete($id);
        $this->dispatch('formSubmitted');
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }

    //Redirect ke route detail release dengan mengirimkan 2 parameter
    //projectId : identifikasi project mana yang sedang dibuka
    //id : identifikasi id release note yang dibuka
    public function releaseDetail($id)
    {
        return redirect()->route('projects.release.detail.release', ['projectId' => $this->projectId, 'id' => $id]);
    }
    
    public function resetFilter()
    {
        $this->reset();
    }

    public function render()
    {
        $releaseNotes = ReleaseNotes::getAll($this->projectId);
        $releaseNotes = $this->filter($releaseNotes);
        return view('livewire.projects.release.show-release-note',['releaseNotes' => $releaseNotes]);
    }
}
