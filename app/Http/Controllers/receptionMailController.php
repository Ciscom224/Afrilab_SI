<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;
use App\Mail\creationCompteRecepteur;
// use Illuminate\support\Facades\Mail;


class receptionMailController extends Controller
{
    public function bar(){
        $recepteur=['Nom'=>'Mamadou Cisse','Matricule'=>'A182380M'];
        mail::to('mamadouibncisse@gmail.com')->send(new creationCompteRecepteur($recepteur));
        return view('emails.bar');
    }
}
