<?php
/**
 * TODO
 * Masih belum lengkap
 * Image belum muncul serta masalah formating text yang belum sesuai
 */
namespace App\Livewire\Projects\Release;

use Livewire\Component;
use App\Models\Projects\ReleaseNote\ReleaseNotes;

class ReleaseDetail extends Component
{
    public $result = [];

    public function mount($id){
        $this->result = ReleaseNotes::detail($id);
    }

    public function render()
    {
        return view('livewire.projects.release.release-detail');
    }
}
