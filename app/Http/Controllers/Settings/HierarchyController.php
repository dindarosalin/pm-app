<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HierarchyController extends Controller
{
    public function index(){
        return view('settings.hierarchy.index');
    }
}
