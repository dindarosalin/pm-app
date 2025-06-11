<?php

namespace App\Livewire\Approval\Responsible;

use App\Models\Approvals\ApprovalReimburse;
use App\Models\Approvals\ApprovalReimburseDetail;
use App\Models\master\uom;
use Livewire\Attributes\On;
use Livewire\Component;

class ResponsibleReimburseDetail extends Component
{
    public $reimburseId;
    public $uoms;
    public $reimburseDetailId, $name, $description, $uom, $qty, $iPrice, $iTPrice;
    public $data, $reimburse;
    public function render()
    {
        $this->loadData();
        return view('livewire.approval.responsible.responsible-reimburse-detail');
    }

    public function mount($reimburseId)
    {
        $this->reimburseId = $reimburseId;
    }

    public function loadData()
    {
        $this->data = ApprovalReimburseDetail::getByreimburseIdAll($this->reimburseId);
        $this->uoms = uom::getAll();
        $this->reimburse = ApprovalReimburse::getById($this->reimburseId);
    }

    public function save()
    {
        if ($this->reimburseDetailId) {
            $this->updateDetailReimburse($this->reimburseDetailId);
        } else {
            $this->createDetailReimburse();
        }

        ApprovalReimburse::updateTotal($this->reimburseId);

        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.',
        ]);
    }

    public function createDetailReimburse()
    {
        ApprovalReimburseDetail::create([
            'reimburseId' => $this->reimburseId,
            'name' => $this->name,
            'description' => $this->description,
            'uom' => $this->uom,
            'qty' => $this->qty,
            'iPrice' => $this->iPrice,
            'iTPrice' => $this->iTPrice,
        ]);
    }

    public function updateDetailReimburse($id)
    {
        ApprovalReimburseDetail::update($id, [
            'reimburseId' => $this->reimburseId,
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
        $d = ApprovalReimburseDetail::getById($id);

        $this->reimburseDetailId = $d->id;
        $this->reimburseId = $d->reimburse_id;
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
        ApprovalReimburseDetail::delete($id);
        ApprovalReimburse::updateTotal($this->reimburseId);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Deleted',
            'text' => 'It will not list on the table.',
        ]);
    }
}
