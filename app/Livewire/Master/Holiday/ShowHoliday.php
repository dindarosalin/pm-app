<?php

namespace App\Livewire\Master\Holiday;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Master\Holiday;

class ShowHoliday extends Component
{
    public $holidays;
    public $holId, $holidayName, $holidayDate, $holidayDescription;
    public $holidayType = true;

    public function render()
    {
        $this->holidays = Holiday::getAll();

        $month = 12;
        $year = 2024;

        $activeDays = Holiday::getActiveDayMonth($month, $year);
        return view('livewire.master.holiday.show-holiday');
    }

    public function save(){
        if ($this->holId) {
            // dd($this->all());
            Holiday::Update($this->holId, $this->all());
        } else {
            Holiday::Create($this->all());
        }
        $this->reset();
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }

    #[On('edit')]
    public function edit($id) {
        $this->dispatch('show-form-offcanvas');
        $var = Holiday::getById($id);
        $this->holId = $var->id;
        $this->holidayName = $var->name;
        $this->holidayDate = $var->date;
        $this->holidayDescription = $var->description;
        $this->holidayType = $var->is_national;
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
        Holiday::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }
}

