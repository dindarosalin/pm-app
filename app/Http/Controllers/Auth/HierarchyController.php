<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee\EmployeeHierarchy;
use Illuminate\Database\Eloquent\Collection;

class HierarchyController extends Controller
{
    public function index(){
        $userLogin = '16723865912539';

        $dataBawahanLangsung = [];
        // Get bawahan dari user login
        $employee = EmployeeHierarchy::where('user_id', $userLogin)->whereHas('child')->first();
        foreach($employee->child as $e){
            $param = [
                'id' => $e->user_id,
                'name' => $e->getEmploye()->user_name,
                'email' => $e->getEmploye()->user_email
            ];

            $dataBawahanLangsung[] = $param;
        }

        // return $dataBawahanLangsung;

        // Get All bawahan
        $usr = EmployeeHierarchy::where('parent_id', $employee->user_id)->get();
        $dataSemuaBawahan = [];

        while(count($usr) > 0){
            $nextUsr = [];
            foreach ($usr as $c) {
                $param = [
                    'id' => $c->user_id,
                    'name' => $c->getEmploye()->user_name,
                    'email' => $c->getEmploye()->user_email
                ];
                array_push($dataSemuaBawahan, $param);
                $nextUsr = array_merge($nextUsr, $c->child->all()); 
            }
            $usr = $nextUsr;
        }

        // return $dataSemuaBawahan;

        // Get semua atasan
        $usrLogin = '1672385124827';
        $parent = EmployeeHierarchy::where('user_id', $usrLogin)->first();
        // dd($parent);
        $current = $parent->parent;
        $atasan = [];
        while($current!=null){
            $parentEmployee = EmployeeHierarchy::where('user_id', $current->user_id)->first();
            $paramAtasan = [
                'id' => $parentEmployee->user_id,
                'name' => $parentEmployee->getEmploye()->user_name,
                'email' => $parentEmployee->getEmploye()->user_email
            ];
            array_push($atasan, $paramAtasan);
            $current = $current->parent;
        }
        
        return $atasan;
    }
}
