<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings\Menu;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;

class MenuController extends BaseController
{
    public function index()
    {
        // view
        return view('settings.menu.index' );
    }

    public function add()
    {
        // Menu::authorize('C');
        $rs_menu = Menu::getAll();
        $data = [
            'rs_menu' => $rs_menu,
        ];
        return view('settings.menu.add', $data);
    }

    public function addProcess(Request $request)
    {
        // authorize
        // Menu::authorize('C');

        // Validate & auto redirect when fail
        $rules = [
            'parent_menu_id' => 'required',
            'menu_name' => 'required',
            'menu_description' => 'required',
            'menu_url' => 'required',
            'menu_sort' => 'required',
            'menu_group' => 'required',
            'menu_active' => 'required',
            'menu_display' => 'required',
        ];
        $request->validate($rules);

        // cek if new menu
        if($request->parent_menu_id == 'parent') {
            $parent_menu_id = NULL;
        }
        else {
            $parent_menu_id = $request->parent_menu_id;
        }

        $menu_id = Menu::makeShortId();

        // params
        $params =[
            'menu_id' => $menu_id,
            'parent_menu_id' => $parent_menu_id,
            'menu_name' => $request->menu_name,
            'menu_description' => $request->menu_description,
            'menu_url' => $request->menu_url,
            'menu_sort' => $request->menu_sort,
            'menu_group' => $request->menu_group,
            'menu_icon' => $request->menu_icon,
            'menu_active' => $request->menu_active,
            'menu_display' => $request->menu_display,
            'created_by'   => Auth::user()->user_id,
            'created_date'  => date('Y-m-d H:i:s')
        ];

        // process
        if (Menu::insert($params)) {
            // insert to app role menu
            // system adminitrator
            $params = [
                'role_id' => '01',
                'menu_id' => $menu_id,
            ];
            Menu::insert_role_menu($params);

            // flash message
            session()->flash('success', 'Data berhasil disimpan.');
            return redirect('/settings/menu/add');
        }
        else {
            // flash message
            session()->flash('danger', 'Data gagal disimpan.');
            return redirect('/settings/menu/add');
        }
    }

    public function edit($id)
    {
        // authorize
        // Menu::authorize('U');

        // get data
        $menu = Menu::getById($id);
        $rs_menu = Menu::getAll();

        // data
        $data = [
            'menu'  => $menu,
            'rs_menu' => $rs_menu,
        ];
        //view
        return view('settings.menu.edit', $data);
    }

    public function editProcess(Request $request)
    {
        // authorize
        // Menu::authorize('U');

        // Validate & auto redirect when fail
        $rules = [
            'menu_id' => 'required',
            'parent_menu_id' => 'required',
            'menu_name' => 'required',
            'menu_description' => 'required',
            'menu_url' => 'required',
            'menu_sort' => 'required',
            'menu_group' => 'required',
            'menu_active' => 'required',
            'menu_display' => 'required',
        ];
        $request->validate($rules);

        // cek if new menu
        if($request->parent_menu_id == 'parent') {
            $parent_menu_id = NULL;
        }
        else {
            $parent_menu_id = $request->parent_menu_id;
        }

        // params
        $params =[
            'parent_menu_id' => $parent_menu_id,
            'menu_name' => $request->menu_name,
            'menu_description' => $request->menu_description,
            'menu_url' => $request->menu_url,
            'menu_sort' => $request->menu_sort,
            'menu_group' => $request->menu_group,
            'menu_icon' => $request->menu_icon,
            'menu_active' => $request->menu_active,
            'menu_display' => $request->menu_display,
            'modified_by'   => Auth::user()->user_id,
            'modified_date'  => date('Y-m-d H:i:s')
        ];

        // process
        if (Menu::update($request->menu_id,$params)) {
            // flash message
            session()->flash('success', 'Data berhasil disimpan.');
            return redirect('/settings/menu');
        }
        else {
            // flash message
            session()->flash('danger', 'Data gagal disimpan.');
            return redirect('/settings/menu/edit/'.$request->menu_id);
        }
    }

    public function deleteProcess($id)
    {
        // authorize
        // Menu::authorize('D');

        // get data
        $menu = Menu::getById($id);
    
        // if exist
        if(!empty($menu)) {
            // cek sub menu
            if(Menu::cekSubMenu($id)){
                // process
                if(Menu::delete($id)) {
                    // flash message
                    session()->flash('success', 'Data berhasil dihapus.');
                    return redirect('/settings/menu');
                }
                else {
                    // flash message
                    session()->flash('danger', 'Data gagal dihapus.');
                    return redirect('/settings/menu');
                }
            }
            else {
                // flash message
                session()->flash('danger', 'Data gagal dihapus,silahkan hapus sub-menu terlebih dahulu.');
                return redirect('/settings/menu');
            }
        }
        else {
            // flash message
            session()->flash('danger', 'Data tidak ditemukan.');
            return redirect('/settings/menu');
        }
    }

    public function accessControl($menu_id)
    {
        // authorize
        // Menu::authorize($this->menu_id, 'C');

        // data
        $data = [
            'menu_id'  => $menu_id
        ];
        //view
        return view('settings.menu.accesscontrol', $data);
    }
}
