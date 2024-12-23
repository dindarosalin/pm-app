<?php

namespace App\Livewire\Base;

use Livewire\Component;
use Livewire\WithPagination;

class BaseComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #region: Listeners & DispatchBrowser for modal message
    public function alert_Success($title, $text)
    {
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'title' => $title,
            'text' => $text
        ]);
    }

    public function confirm_Delete($item_to_delete, $listener_name)
    {
        $this->dispatchBrowserEvent('confirm_Delete', [
            'type' => 'warning',
            'title' => 'Anda yakin akan menghapus<br>[' . $item_to_delete . ']?',
            'text' => 'Jika dihapus, data tidak bisa dikembalikan!',
            'delete_listener_name' => $listener_name
        ]);
    }

    public function call_ParentFunction($parent_function, $value)
    {
        $this->dispatchBrowserEvent('call_ParentFunction', [
            'value' => $value,
            'parent_function' => $parent_function
        ]);
    }

    public function closeModal($modalname)
    {
        $this->dispatchBrowserEvent('closeModal', [
            'modal_name' => $modalname
        ]);
    }

    public function openModal($modalname)
    {
        $this->dispatchBrowserEvent('openModal', [
            'modal_name' => $modalname
        ]);
    }

    public function refreshParent()
    {
        $this->dispatchBrowserEvent('refreshParent');
    }
    #endregion
}
