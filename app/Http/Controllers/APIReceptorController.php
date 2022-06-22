<?php

namespace App\Http\Controllers;

use App\Models\demandes;
use App\Models\elements;
use App\Models\employes;
use App\Models\echantillons;
use App\Models\EmployeTouchers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIReceptorController extends Controller
{
    public function registerReceptor(){
        if(isset($_GET['name']) && isset($_GET['password']) && isset($_GET['comfirmPassword']) && isset($_GET['matricule'])){
            if($_GET['password'] != $_GET['comfirmPassword']){
                return response()->json([
                    'success' => false,
                    'comfirmError' => true,
                    'userAlreadyExists' => false,
                ]);
            }else{
                $info = employes::where('matricule', $_GET['matricule'])->first();
                if(!empty($info)){
                    return response()->json([
                        'success' => false,
                        'comfirmError' => false,
                        'userAlreadyExists' => true,
                    ]);
                }else{
                    $employes = new employes();
                    $employes->name = htmlspecialchars($_GET['name']);
                    $employes->matricule = htmlspecialchars($_GET['matricule']);
                    $employes->password = sha1($_GET['password']);
                    $employes->service = "rien pour le moment";
                    $employes->save();
                }
            }
        }
    }



    public function login(Request $request,$page){


        if(isset($_POST['matricule']) && isset($_POST['password'])){
            $employe = employes::where([
                                    ['matricule',$_POST['matricule']],
                                    ['pass',sha1($_POST['password'])],
                                    ])->first();
            if(!empty($employe)){
                if ($page=="PreparationMecanique" && $employe->service=="mecanique") {
                    if(session()->has('employe_id')){
                        session()->pull('employe_id');
                        $request->session()->put('employe_id',$employe->matricule);
                    }else{
                        $request->session()->put('employe_id',$employe->matricule);
                    }

                    DB::table('employes')
                        ->updateOrInsert(
                        ['matricule' =>$_POST['matricule'],
                            'service' =>$employe->service],
                            ['connecte' => 1 ]
                    );
                    return redirect('/Préparation/Mecanique');


                }
                elseif ($page=="PreparationChimique" && $employe->service=="chimique") {
                    if(session()->has('employe_id')){
                        session()->pull('employe_id');
                        $request->session()->put('employe_id',$employe->matricule);
                    }else{
                        $request->session()->put('employe_id',$employe->matricule);
                    }
                    DB::table('employes')
                        ->updateOrInsert(
                        ['matricule' =>$_POST['matricule'],
                        'service' =>$employe->service],
                        ['connecte' => 1 ]
                    );
                    return redirect('/Préparation/Chimique');
                }
                elseif ($page=="Reception" && $employe->service=="reception") {
                    if(session()->has('employe_id')){
                        session()->pull('employe_id');
                        $request->session()->put('employe_id',$employe->matricule);
                    }else{
                        $request->session()->put('employe_id',$employe->matricule);
                    }
                    DB::table('employes')
                        ->updateOrInsert(
                        ['matricule' =>$_POST['matricule'],
                        'service' =>$employe->service],
                        ['connecte' => 1 ]
                    );
                    return redirect('/reception');
                }
                elseif ($page=="volumetrie" && $employe->service=="volumetrie")
                {
                    if(session()->has('employe_id')){
                        session()->pull('employe_id');
                        $request->session()->put('employe_id',$employe->matricule);
                    }else{
                        $request->session()->put('employe_id',$employe->matricule);
                    }
                    DB::table('employes')
                    ->updateOrInsert(
                        ['matricule' =>$_POST['matricule'],
                        'service' =>$employe->service],
                        ['connecte' => 1 ]
                    );
                    return redirect('laboratoire/Volumetrie');
                }
                elseif ($page=="absorption" && $employe->service=="absorption")
                {
                    if(session()->has('employe_id')){
                        session()->pull('employe_id');
                        $request->session()->put('employe_id',$employe->matricule);
                    }else{
                        $request->session()->put('employe_id',$employe->matricule);
                    }
                    DB::table('employes')
                        ->updateOrInsert(
                    ['matricule' =>$_POST['matricule'],
                        'service' =>$employe->service],
                        ['connecte' => 1 ]
                    );
                    return redirect('laboratoire/Absorption');
                }
                elseif ($page=="ICP" && $employe->service=="icp") {
                    if(session()->has('employe_id')){
                        session()->pull('employe_id');
                        $request->session()->put('employe_id',$employe->matricule);
                    }else{
                        $request->session()->put('employe_id',$employe->matricule);
                    }
                    DB::table('employes')
                        ->updateOrInsert(
                    ['matricule' =>$_POST['matricule'],
                        'service' =>$employe->service],
                        ['connecte' => 1 ]
                    );
                    return redirect('/laboratoire/ICP');
                }
                elseif ($page=="admin" && $employe->service=="admin"){
                    if ($_POST['password']=="adminRT@2022") {
                        if(session()->has('employe_id')){
                            session()->pull('employe_id');
                            $request->session()->put('employe_id',$employe->matricule);
                        }else{
                            $request->session()->put('employe_id',$employe->matricule);
                        }
                        return redirect('/administrationRT/index');
                    }
                    elseif ($_POST['password']=="afrilab@admin2022@") {
                        if(session()->has('employe_id')){
                            session()->pull('employe_id');
                            $request->session()->put('employe_id',$employe->matricule);
                        }else{
                            $request->session()->put('employe_id',$employe->matricule);
                        }
                        return redirect('/admin');

                    }
                    else{
                        $message="Vous etes pas un administrateur ";
                        return view('404',[
                            'message' =>$message,
                            'retourPage' =>"/"
                        ]);
                    }

                }
                else{
                    $message="Vous n'avez pas l'autorisation !!!";
                    return view('404',[
                        'message' =>$message,
                        'retourPage' =>"/"
                    ]);

                }
            }else{
                $message="Matricule ou Mot de passe Incorrect";
                return view('404',[
                    'message' =>$message,
                    'retourPage' =>"/"
                ]);


            }
        }else{
            echo "Page inconnue <a href='/'>Retour</a>";

        }
    }
    public function isLoggedIn(){
        if(session()->has('employe_id')){
            return response()->json([
                'isLoggedIn' => true
            ]);
        }else{
            return response()->json([
                'isLoggedIn' => false
            ]);
        }
    }

    public function logout(){
        if(session()->has('employe_id')){
            dd("bien");
            employes::where('matricule',session('employe_id'))
            ->update(['connecte' => 0]);
            session()->pull('employe_id');

        }
    }
}
