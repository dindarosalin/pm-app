<?php

namespace App\Livewire\Master\Uom;

use Livewire\Component;

class Measure extends Component
{
    public function render()
    {
        return view('livewire.master.uom.measure');
    }

// =================================================================================================
    // public function store()
    // {
    //     $this->validate([
    //         'jenis' => 'string|max:255',
    //         'name' => 'string|max:255',
    //     ]);

    //     try {
    //         if ($uomId) {
    //             Measure::update([
    //                 'jenis' => $jenis,
    //                 'name' => $name
    //             ], $uomId);
    //             session()->flash('success', 'unit of measure Updated Successfully!');
    //         } else {
    //             Measure::create([
    //                 'jenis' =>
    //             ]);
    //         }
    //     }
    // }
}
