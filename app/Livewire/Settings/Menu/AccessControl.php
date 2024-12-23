<?php

namespace App\Livewire\Settings\Menu;

use Livewire\Component;
use App\Models\Settings\Menu;
use App\Livewire\Base\BaseComponent;

class AccessControl extends BaseComponent
{
    public $menu_id;
    public $menu_control_id;
    public $code;
    public $control_name;
    public $order_no;

    protected $listeners = ['clearForm'];

    public function render()
    {
        // authorize
        // Menu::authorize($this->menu_id, 'R');

        $menu             = Menu::getById($this->menu_id);
        $rs_menu_access   = Menu::getMenuAccessById($this->menu_id);

        $data = [
            'menu'          => $menu,
            'rs_menu_access' => $rs_menu_access
        ];

        // ActivityLogModel::addLog('Melihat menu control', ["menu" => $menu]);

        return view('livewire.settings.menu.access-control', $data);
    }

    public function clearForm()
    {
        $this->resetExcept('menu_id');
        $this->resetValidation();
    }

    public function accessControlAdd()
    {
        // authorize
        // Menu::authorize($this->menu_id, 'C');

        $this->validate([
            'code'          => 'required',
            'control_name'  => 'required',
            'order_no'      => 'required|numeric',
        ]);

        // params
        $params = [
            'menu_id'       => $this->menu_id,
            'code'          => $this->code,
            'control_name'  => $this->control_name,
            'order_no'      => $this->order_no,
        ];

        // process
        $menu_control_id = Menu::insertControlGetId($params);
        if (!empty($menu_control_id)) {

            // ActivityLogModel::addLog('Menambah menu control', ["params" => $params]);

            $role_id = Menu::getUserRoleId();
            $params = [
                'role_id'           => $role_id,
                'menu_id'           => $this->menu_id,
                'menu_control_id'   => $menu_control_id,
            ];
            Menu::insertRoleControl($params);

            // ActivityLogModel::addLog('Menambah role menu control', ["params" => $params]);

            // flash message
            session()->flash('success', 'Data berhasil disimpan.');

            //For hide modal after success
            $this->dispatch('close-modal');
        } else {
            // flash message
            session()->flash('danger', 'Data gagal disimpan.');
        }
    }

    public function accessControlDefaultAdd()
    {
        // authorize
        // Menu::authorize($this->menu_id, 'C');

        // params
        $arr_code = ['C', 'R', 'U', 'D'];
        foreach ($arr_code as $key => $code) {
            $check_control = Menu::checkMenuContol($this->menu_id, $code);
            if (!$check_control) {
                # code...
                if ($code == 'C') {
                    $control_name = "Create";
                } elseif ($code == 'R') {
                    $control_name = "Read";
                } elseif ($code == 'U') {
                    $control_name = "Update";
                } elseif ($code == 'D') {
                    $control_name = "Delete";
                }
                $params = [
                    'menu_id' => $this->menu_id,
                    'code' => $code,
                    'control_name' => $control_name,
                    'order_no' => '0' . $key + 1,
                ];

                $menu_control_id = Menu::insertControlGetId($params);
                if (!empty($menu_control_id)) {
                    $role_id = Menu::getUserRoleId();
                    $params2 = [
                        'role_id' => $role_id,
                        'menu_id' => $this->menu_id,
                        'menu_control_id' => $menu_control_id,
                    ];
                    Menu::insertRoleControl($params2);
                }
            }
        }

        // ActivityLogModel::addLog('Menambah default menu control', ["menu_id" => $this->menu_id]);

        session()->flash('success', 'Data berhasil disimpan.');
    }

    public function accessControlEdit($menu_control_id)
    {
        // authorize
        // Menu::authorize($this->menu_id, 'R');

        $this->clearForm();

        $menu_control = Menu::getMenuControlById($menu_control_id);
        if (!empty($menu_control)) {
            $this->menu_control_id = $menu_control->id;
            $this->code             = $menu_control->code;
            $this->control_name     = $menu_control->control_name;
            $this->order_no         = $menu_control->order_no;
        } else {
            // flash message
            session()->flash('danger', 'Menu tidak ditemukan!');
        }
    }

    public function accessControlEditProcess()
    {
        // authorize
        // Menu::authorize($this->menu_id, 'U');

        $this->validate([
            'menu_control_id'          => 'required',
            'code'          => 'required',
            'control_name'  => 'required',
            'order_no'      => 'required|numeric',
        ]);

        // params
        $params = [
            'code'          => $this->code,
            'control_name'  => $this->control_name,
            'order_no'      => $this->order_no,
        ];

        // process
        if (Menu::updateMenuControl($this->menu_control_id, $params)) {

            // ActivityLogModel::addLog('Mengubah menu control', ["menu_control_id" => $this->menu_control_id]);

            // flash message
            session()->flash('success', 'Data berhasil disimpan.');

            // clear form
            $this->clearForm();

            //For hide modal after success
            $this->dispatch('close-modal');
        } else {
            // flash message
            session()->flash('danger', 'Data gagal disimpan.');
        }
    }

    public function deleteControlProcess($menu_control_id)
    {
        // authorize
        // Menu::authorize($this->menu_id, 'D');

        // get data
        $menu_control = Menu::getMenuControlById($menu_control_id);

        // if exist
        if (!empty($menu_control)) {

            // process
            if (Menu::deleteControl($menu_control_id)) {
                // ActivityLogModel::addLog('Menghapus menu control', ["menu_control" => $menu_control]);
                // flash message
                session()->flash('success', 'Data berhasil dihapus.');
            } else {
                // flash message
                session()->flash('danger', 'Data gagal dihapus.');
            }
        } else {
            // flash message
            session()->flash('danger', 'Data tidak ditemukan.');
        }
    }
}
