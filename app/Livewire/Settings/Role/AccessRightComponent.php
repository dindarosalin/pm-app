<?php

namespace App\Livewire\Settings\Role;

use Livewire\Component;

use App\Livewire\Base\BaseComponent;
// use App\Models\Admin\ActivityLogModel;
use App\Models\Settings\AccessRightModel;
use App\Models\Settings\Menu;
use App\Models\Settings\Role;

class AccessRightComponent extends BaseComponent
{
    public $menu_id;
    public $role_id;
    public $url_segment;

    public $rs_menu_parent;
    public $rs_menu_child;
    public $rs_menu_control;
    public $rs_menu_accessright;
    public $rs_role;

    public $list_menu_id = [];
    public $list_control_id = [];
    public $list_updated_menu_id = [];
    public $list_updated_control_id = [];

    public $cbControlList = [];
    public $cbMenuList = [];
    public $cbAll = [];
    public $isFirstRender = true;

    public function render()
    {
        $this->rs_menu_parent = Menu::getAllParent("");
        $this->rs_menu_child = Menu::getAllChild("");
        $this->rs_menu_control = AccessRightModel::getAllMenuControl();
        $this->rs_menu_accessright = AccessRightModel::getAllMenuAccessRight($this->role_id);
        $this->rs_role = (array)Role::getById($this->role_id);

        if ($this->isFirstRender) {
            $this->firstRender();
            $this->isFirstRender = false;
        }

        return view("livewire.settings.role.access-right-component",);
    }

    public function firstRender()
    {
        foreach ($this->rs_menu_parent as $item) {
            $this->list_menu_id[] = $item->menu_id;
        }

        foreach ($this->rs_menu_child as $item) {
            $this->list_menu_id[] = $item->menu_id;
        }

        foreach ($this->rs_menu_control as $item) {
            $this->list_control_id[] = $item->menu_id . "-" . (string)$item->id;
        }

        foreach ($this->rs_menu_accessright as $control_item) {
            $this->cbControlList[] = $control_item->menu_id . "-" . (string)$control_item->menu_control_id;
        }
        $this->cbControlList_Clicked();
    }

    public function btnSaveAccessRight_clicked()
    {
        // AccessRightModel::authorize($this->menu_id, 'UAR');
        $this->SaveAccessRight();
    }

    public function cbAll_Clicked()
    {
        if ($this->cbAll) {
            foreach ($this->rs_menu_parent as $item) {
                $this->cbMenuList[] = $item->menu_id;
            }
            foreach ($this->rs_menu_child as $item) {
                $this->cbMenuList[] = $item->menu_id;
            }
            foreach ($this->rs_menu_control as $item) {
                $this->cbControlList[] = (string)$item->menu_id . "-" . (string)$item->id;
            }
        } else {
            $this->cbMenuList = [];
            $this->cbControlList = [];
        }

        //remove duplicate
        $this->cbControlList = array_unique($this->cbControlList);
        $this->cbControlList = array_values($this->cbControlList);

        $this->list_updated_menu_id = $this->cbMenuList;
        $this->list_updated_control_id = $this->cbControlList;
    }

    public function cbMenuList_Clicked()
    {
        //get unchecked menu
        $list_menu_unchecked_id = array_diff($this->list_updated_menu_id, $this->cbMenuList);
        if (count($list_menu_unchecked_id) > 0) {

            //Unchecked all control for unchecked menu
            foreach ($this->list_updated_control_id as $index => $control_item) {
                foreach ($list_menu_unchecked_id as $menu_unchecked_item) {
                    if (explode("-", $control_item)[0] == $menu_unchecked_item) {
                        unset($this->cbControlList[$index]);
                    }
                }
            }
            $this->cbControlList = array_values($this->cbControlList);
        }

        //Checked all control for checked menu
        $list_menu_checked_id = array_diff($this->cbMenuList, $this->list_updated_menu_id);
        foreach ($list_menu_checked_id as $menu_checked_item) {
            foreach ($this->list_control_id as $index => $control_item) {
                if (explode("-", $control_item)[0] == $menu_checked_item) {
                    $this->cbControlList[] = $control_item;
                }
            }
        }
        $this->list_updated_control_id = $this->cbControlList;

        //remove duplicate
        $this->cbControlList = array_unique($this->cbControlList);
        $this->cbControlList = array_values($this->cbControlList);
        // dd($this->list_updated_control_id, $this->cbControlList);

        $this->list_updated_menu_id = $this->cbMenuList;
        $this->list_updated_control_id = $this->cbControlList;

        //update checkbox all
        $list_menu_unchecked_id = array_diff($this->list_menu_id, $this->list_updated_menu_id);
        if (count($list_menu_unchecked_id) > 0) {
            $this->cbAll = false;
        } else {
            $this->cbAll = true;
        }
    }

    public function cbControlList_Clicked()
    {
        //get unnchecked control
        $list_control_unchecked_id = array_diff($this->list_updated_control_id, $this->cbControlList);
        if (count($list_control_unchecked_id) > 0) {
            $list_menu_unchecked_id = [];
            foreach ($list_control_unchecked_id as $control_unchecked_item) {
                $list_menu_unchecked_id[] = explode("-", $control_unchecked_item)[0];
            }

            $this->cbMenuList = array_diff($this->cbMenuList, $list_menu_unchecked_id);
            $this->cbMenuList = array_values($this->cbMenuList);
        } else {
            $list_control_unchecked_id = array_diff($this->list_control_id, $this->cbControlList);
            $list_menu_unchecked_id = [];
            foreach ($list_control_unchecked_id as $control_unchecked_item) {
                $list_menu_unchecked_id[] = explode("-", $control_unchecked_item)[0];
            }
            $this->cbMenuList = array_diff($this->list_menu_id, $list_menu_unchecked_id);
            $this->cbMenuList = array_values($this->cbMenuList);
        }
        $this->list_updated_menu_id = $this->cbMenuList;
        $this->list_updated_control_id = $this->cbControlList;

        //update checkbox all
        $list_menu_unchecked_id = array_diff($this->list_menu_id, $this->list_updated_menu_id);
        if (count($list_menu_unchecked_id) > 0) {
            $this->cbAll = false;
        } else {
            $this->cbAll = true;
        }
    }

    public function SaveAccessRIght()
    {
        $params = [];
        // dd($this->cbControlList);
        foreach ($this->cbControlList as $control_item) {
            $control = explode("-", $control_item);
            $data = [
                "role_id" => $this->role_id,
                "menu_id" => $control[0],
                "menu_control_id" => $control[1]
            ];
            $params[] = $data;
        }
        if (AccessRightModel::update($this->role_id, $params)) {
            // ActivityLogModel::addLog('Mengubah hak akses user', ['id' => $this->role_id, 'params' => $params]);
            session()->flash('success', 'Data berhasil disimpan.');
        } else {
            abort('500', 'Internal server error');
        }
        // dd($params);
    }
}
