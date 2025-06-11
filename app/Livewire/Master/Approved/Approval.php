<?php

// namespace App\Livewire\Master\Approved;

// use App\Models\Projects\Master\Approval as MasterApproval;
// use Livewire\Attributes\On;
// use Livewire\Component;

// class Approval extends Component
// {
//     public $approval;
//     public $approvalId;
//     public $jenis;

//     #[On('refresh')]
//     public function refresh()
//     {
//         $this->approval = MasterApproval::getAllApproval();
//     }

//     public function render()
//     {
//         return view('livewire.master.approved.approval', ['approval' => $this->approval]);
//     }

//     public function mount()
//     {
//         $this->approval = MasterApproval::getAllApproval();
//     }
// // ========================================STORE, DELETE, EDIT==========================================    
//     public function store()
//     {
//         $this->validate([
//             'jenis' => 'required|string|max:50',
//         ]);

//         try {
//             if ($this->approvalId) {
//                 MasterApproval::update(['jenis' => $this->jenis], $this->approvalId);
//                 session()->flash('success', 'Approval Berhasil Diupdate!');
//             } else {
//                 MasterApproval::create(['jenis' => $this->jenis]);
//                 session()->flash('success', 'Approval Berhasil Dibuat!');
//             }
//             $this->js("alert('Approval Tersimpan')");

//             $this->refresh();
//         } catch (\Throwable $th) {
//             session()->flash('error', 'Error: ' .$th->getMessage());
//         }
//     }

//     public function edit($id)
//     {
//         $approvals = MasterApproval::getApprovalId($id);

//         if ($approvals) {
//             $this->approvalId = $approvals->id;
//             $this->jenis = $approvals->jenis;
//         }
//         $this->dispatch('show-edit-offcanvas');
//     }

//     public function delete($id)
//     {
//         MasterApproval::delete($id);
//         $this->js("alert('Approval Berhasil Dihapus')");
//         $this->dispatch('refresh');
//     }

//     // ========================================HANDLE OFFCANVAS==========================================
//     public function btnApproval_Clicked()
//     {
//         $this->dispatch('show-create-offcanvas');
//     }
// }
