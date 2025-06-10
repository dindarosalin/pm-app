<?php

namespace App\Livewire\Approval\Responsible;

use App\Models\Approvals\ApprovalRab;
use App\Models\Approvals\ApprovalRabDetail;
use App\Models\master\uom;
use Livewire\Attributes\On;
use Livewire\Component;

class ResponsibleRabDetail extends Component
{
    public $rabId;
    public $uoms;
    public $rabDetailId, $name, $description, $uom, $qty, $iPrice, $iTPrice;
    public $data, $rab;
    public function render()
    {
        $this->loadData();
        return view('livewire.approval.responsible.responsible-rab-detail');
    }

    public function mount($rabId)
    {
        $this->rabId = $rabId;
    }

    public function loadData()
    {
        $this->data = ApprovalRabDetail::getAll();
        $this->uoms = uom::getAll();
        $this->rab = ApprovalRab::getById($this->rabId);
    }

    public function save()
    {
        if ($this->rabDetailId) {
            $this->updateDetailRab($this->rabDetailId);
        } else {
            $this->createDetailRab();
        }

        ApprovalRab::updateTotal($this->rabId);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.',
        ]);
    }

    public function createDetailRab()
    {
        ApprovalRabDetail::create([
            'rabId' => $this->rabId,
            'name' => $this->name,
            'description' => $this->description,
            'uom' => $this->uom,
            'qty' => $this->qty,
            'iPrice' => $this->iPrice,
            'iTPrice' => $this->iTPrice,

        ]);
    }

    public function updateDetailRab($id)
    {
        ApprovalRabDetail::update($id, [
            'rabId' => $this->rabId,
            'name' => $this->name,
            'description' => $this->description,
            'uom' => $this->uom,
            'qty' => $this->qty,
            'iPrice' => $this->iPrice,
            'iTPrice' => $this->iTPrice,
        ]);
    }

    public function updatedQty()
    {
        $this->calculateTotalPricePerItem();
    }

    public function updatedIPrice()
    {
        $this->calculateTotalPricePerItem();
    }

    private function calculateTotalPricePerItem()
    {
        $quantity = (float) $this->qty;
        $itemPrice = (float) $this->iPrice;

        $this->iTPrice = $quantity * $itemPrice;
    }

    public function edit($id)
    {
        $this->dispatch('show-offcanvas');
        $d = ApprovalRabDetail::getById($id);

        $this->rabDetailId = $d->id;
        $this->rabId = $d->rab_id;
        $this->name = $d->name;
        $this->description = $d->description;
        $this->uom = $d->uom;
        $this->qty = $d->quantity;
        $this->iPrice = $d->item_price;
        $this->iTPrice = $d->total_item_price;
    }

    public function alertConfirm($id)
    {
        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'message' => 'Are you sure?',
            'text' => 'You won\'t be able to revert this!',
            'id' => $id,
            'dispatch' => 'delete',
        ]);
    }

    #[On('delete')]
    public function delete($id)
    {
        ApprovalRabDetail::delete($id);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.',
        ]);
    }
}
