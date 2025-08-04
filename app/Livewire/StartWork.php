<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Working;
use Livewire\Component;
use App\Models\ButtonStart;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class StartWork extends Component
{

    public $isButtonDisabled;

    public function store()
    {
        $employee = Auth::user()->user_id; //GET ID FROM SESSION LOGIN

        $storeData = [
            'employee_id' => $employee
        ];

        Working::create($storeData);
        ButtonStart::create($storeData);

        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Saved',
            'text' => 'It will list on the table soon.'
        ]);

        $this->dispatch('success');
    }

    public function user()
    {
        $session = Auth::user()->user_id;
        $disabledAt = ButtonStart::getById($session);
        return $disabledAt;
    }


    #[On('success')]
    public function mount()
    {

        $users = StartWork::user();
        if ($users->isEmpty()) {
            $this->isButtonDisabled = false; // Atur sesuai kebutuhan Anda jika tidak ada data
        } else {
            $disabledAt = $users[0]->button_disabled_at;
            $this->isButtonDisabled = $disabledAt && Carbon::parse($disabledAt)->isToday();
        }

        // $disabledAt = StartWork::user()[0]->button_disabled_at;
        // $this->isButtonDisabled = $disabledAt && Carbon::parse($disabledAt)->isToday();
    }

    public function render()
    {
        return view('livewire.start-work', ['isButtonDisabled' => $this->isButtonDisabled]);
    }
}
