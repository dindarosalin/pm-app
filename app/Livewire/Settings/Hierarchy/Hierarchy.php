<?php

namespace App\Livewire\Settings\Hierarchy;

use Livewire\Component;
use App\Models\Settings\Accounts;
use App\Models\Employee\EmployeeHierarchy;
use Illuminate\Support\Facades\DB;

class Hierarchy extends Component
{
    public $showModal = false;
    public $selectedKaryawan;
    public $selectedAtasan;
    public $karyawan;
    public $atasan;

    public function mount()
    {
        $this->karyawan = DB::table('app_user')->get();
        $this->atasan = EmployeeHierarchy::whereNull('parent_id')->get();
    }

    public function save(){
        $rule = [
            'selectedKaryawan' => 'required',
            // 'selectedAtasan' => 'required'
        ];
        
        $this->validate($rule);
        EmployeeHierarchy::create([
            'parent_id' => $this->selectedAtasan,
            'user_id' => $this->selectedKaryawan
        ]);
        $this->reset(['selectedKaryawan', 'selectedAtasan', 'showModal']);
        session()->flash('success', 'Data berhasil disimpan!');
    }

    public function destroy($id){
        EmployeeHierarchy::where('id', $id)->delete();
        session()->flash('success', 'Data berhasil dihapus!');
    }
    
    public function render()
    {
        $rs_employee = Accounts::getAllPaginate();
        $employees = EmployeeHierarchy::whereHas('child')->whereNull('parent_id')->paginate(10);
        return view('livewire.settings.hierarchy.hierarchy', compact('rs_employee', 'employees'));
    }
}
