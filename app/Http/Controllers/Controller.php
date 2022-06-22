<?php

namespace App\Http\Controllers;

use App\Models\employes;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function home(){
        if(session()->has('employe_id')){
            employes::where('matricule',session('employe_id'))
            ->update(['connecte' => 0]);
            session()->pull('employe_id');

        }
        return view('home');
    }
}
