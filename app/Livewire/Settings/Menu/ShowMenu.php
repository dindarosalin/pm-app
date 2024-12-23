<?php

namespace App\Livewire\Settings\Menu;

use Livewire\Component;
use App\Livewire\Base\BaseComponent;
use App\Models\Settings\Menu;
use Livewire\WithPagination;

class ShowMenu extends BaseComponent
{
    use WithPagination;
    public $menu_id;
    protected $paginationTheme = 'bootstrap';

    public $txtKeyword = "";

    public function render()
    {
        // get data with pagination
        $rs_menu_parent = Menu::getAllParent($this->txtKeyword);
        $rs_menu_child = Menu::getAllChild($this->txtKeyword);
        // data
        $data = [
            'rs_menu_parent' => $rs_menu_parent,
            'rs_menu_child' => $rs_menu_child
        ];

        // dd($data);
        return view('livewire.settings.menu.show-menu', $data);
    }

    public function tblUpdateParentMenuOrder($lists)
    {
        // dd($lists);
        foreach ($lists as $key => $item) {
            $id = $item["value"];
            $params = ["menu_sort" => $item["order"]];
            Menu::update($id, $params);
        }
    }

    public function tblUpdateChildMenuOrder($lists)
    {
        // dd($lists);
        foreach ($lists as $key => $parent) {
            $id = $parent["value"];
            $params = ["menu_sort" => $parent["order"]];
            Menu::update($id, $params);

            foreach ($parent["items"] as $key => $child) {
                $id = $child["value"];
                $params = [
                    "parent_menu_id" => $parent["value"],
                    "menu_sort" => $child["order"]
                ];
                Menu::update($id, $params);
            }
        }
    }

    public function btnSearchClicked()
    {
    }

    public function btnResetClicked()
    {
        $this->txtKeyword = "";
    }
}
