<?php

namespace App\Livewire\Master\StatusWfh;

use App\Models\Master\WfhStatuses;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowStatusWfh extends Component
{
    public $statuses;
    public $statusId;
    public $statusName;
    public $statusCode;

    protected $rules = [
        'statusName' => 'required',
        'statusCode' => 'required',
    ];

    protected $messages = [
        'statusName.required' => 'Status name required.',
        'statusCode.required' => 'Status code required.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        $this->validate();

        $storeData = [

            'status_wfh' => $this->statusName,
            'code' => $this->statusCode,
        ];

        try {
            // dd($storeData);
            if ($this->statusId) {
                WfhStatuses::update($storeData, $this->statusId);
            } else {
                WfhStatuses::create($storeData);
                $this->updatedProjectStatus($this->projectId);
            }

            $this->resetForm();
            $this->dispatch('close-offcanvas');
            $this->dispatch('status-updated');
            $this->dispatch('swal:modal', [
                'type' => 'success',
                'message' => 'Data Saved',
                'text' => 'It will list on the table soon.'
            ]);

            $this->dispatch('success');
        } catch (\Throwable $th) {
            session()->flash('error', $th);
            $th->getMessage();
        }
    }

    public function edit($id)
    {
        // dd($id);
        $item = WfhStatuses::getBy($id);
        // dd($item);
        if ($item) {
            $this->statusId = $item->id;
            $this->statusName = $item->status_wfh;
            $this->statusCode = $item->code;
        } else {
            session()->flash('error', 'Status not found.');
        }
        $this->dispatch('show-edit-offcanvas');
    }

    public function resetForm()
    {
        $this->statusId = null;
        $this->statusName = '';
        $this->statusCode = '';
    }

    public function alertConfirm($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'message' => 'Are you sure?',
            'text' => 'You won\'t be able to revert this!',
            'id' => $id,
            'dispatch' => 'delete-project-status'
        ]);
    }

    #[On('delete-project-status')]
    public function delete($id)
    {
        WfhStatuses::deleteBy($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.'
        ]);
    }

    public function getListeners()
    {
        return ['refreshComponent' => '$refresh'];
    }

    public function getStatusesProperty()
    {
        return WfhStatuses::getAllStatus();
    }

    public function btnClose_Offcanvas()
    {
        $this->resetForm();
        $this->dispatch('close-offcanvas');
    }

    public function render()
    {

        $this->statuses = $this->getStatusesProperty();
        // dd($this->statuses);
        if ($this->statuses && $this->statuses->isEmpty()) {
            session()->flash('message', 'No statuses found.');
        } elseif ($this->statuses) {
            session()->flash('message', 'Statuses loaded successfully.');
        } else {
            session()->flash('message', 'Statuses could not be loaded.');
        }

        return view('livewire.master.status-wfh.show-status-wfh');
    }
}
