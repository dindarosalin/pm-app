<?php

namespace App\Livewire\Projects\Budget\Track;

use Livewire\Component;
use App\Models\Projects\Budget\Track\Track;

class DetailNota extends Component
{
   public $nota = []; //simpan hasil  data track pada detail

    public function render()
    {
        return view('livewire.projects.budget.track.detail-nota');
    }

    public function mount($id)
    {
        $this->nota = Track::detail($id);
    }
}
