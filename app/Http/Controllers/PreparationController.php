<?php

namespace App\Http\Controllers;

use App\Models\densites;
use App\Models\humidite;
use App\Models\pertefeu;
use App\Models\employes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PreparationController extends Controller
{
    public function showPage($name){
        if(session()->has('receptor_id')){
           $log=true;
        }else{
           $log=FALSE;

        }
        // var_dump($log);

        if($log==FALSE){
            return view('loginForm',[
                'NamePrepa' => $name]);
        }
        elseif ($name=='PM') {
            return redirect('/Préparation/Mecanique');
        }
        elseif ($name=='PC') {
            return redirect('/Préparation/Chimique');

        }
        elseif ($name=='V') {

        }

    }

    public function homePagePM(){
        $demandes=DB::table('demandes') ->where('niveau',1)->paginate(7);

        $nbrEch= DB::table('demandes')->where('niveau',1)->sum('nombre_echantillons');
        $nbrDem=DB::table('demandes')->where('niveau',1)->count();
        $employe=employes::where('matricule',session('employe_id'))->first();

        return view('preparation.homePM',[
            'nbEchantillon' => $nbrEch,
            'nbDemande' =>$nbrDem,
            'demandes' => $demandes,
            'employe' => $employe
            ]

        );

    }
    // cette fonction permet de changer la changer la variable pm (la demande est deja passer par la preparation mecanique)
    public function validationMecanique($demande_id){
        DB::table('demandes')->where('demande_id',$demande_id)->update([
            'niveau'=>3
        ]);
        DB::table('employe_touchers')
            ->updateOrInsert(
                [
                    'employe_id' => session('employe_id'),
                     'demande_id' => $demande_id
                    ],
                ['date_modif' => new \DateTime()]
            );

            return redirect('/Préparation/Mecanique');
    }
    public function homePagePC(){
        $demandes=DB::table('demandes')->where('niveau',3)->paginate(5);

        $nbrDemChi= DB::table('demandes')->where('niveau',3)->count();
        $nbrEchChi=DB::table('demandes')->where('niveau',3)->sum('nombre_echantillons');
        $employe=employes::where('matricule',session('employe_id'))->first();

        return view('preparation.homePC',[
            'nbEchantillon' => $nbrEchChi,
            'nbDemande' => $nbrDemChi,
            'demandes' => $demandes,
            'employe' => $employe
            ]
        );
    }

    public function demandeDetails($demande_id){
        $nbrDemChi= DB::table('demandes')->where('niveau',3)->count();
        $nbrEchChi=DB::table('demandes')->where('niveau',3)->sum('nombre_echantillons');
        $echantillons=DB::table('echantillons')->where('demande_id',$demande_id)->get();
        $employe=employes::where('matricule',session('employe_id'))->first();
        return view('preparation.demandeDetails',[
            'nbEchantillon' => $nbrEchChi,
            'nbDemande' => $nbrDemChi,
            'demande_id' => $demande_id,
            'echantillons' => $echantillons,
            'employe' => $employe
            ]
        );
    }

    public function demandeUpdate(Request $request){
        $demandePathEdit="/Préparation/Chimique/detatils/demande/edit/".htmlspecialchars($request->input('demande_id'));
        return redirect($demandePathEdit);
    }
    public function demandeEdit($demande_id){



        $echantillons=DB::table('echantillons')->where('demande_id',$demande_id)->get();

        $employe=employes::where('matricule',session('employe_id'))->first();
        $nbrDemChi= DB::table('demandes')->where('niveau',3)->count();
        $nbrEchChi=DB::table('demandes')->where('niveau',3)->sum('nombre_echantillons');
        return view('preparation.demandePcEdit',[
            'nbEchantillon' => $nbrEchChi,
            'nbDemande' => $nbrDemChi,
            'demande_id' => $demande_id,
            'echantillons' => $echantillons,
            'employe' => $employe
            ]
        );
    }

    public function validerDemandePc($demande_id){
        DB::table('demandes')->where('demande_id',$demande_id)->update([
            'niveau'=>4
        ]);
        return redirect('/Préparation/Chimique');
    }
    public function demandeAddMasseVolume(Request $request,$demande_id){
        $nbech=(count($_POST)-1)/5;
        for ($i=0; $i <$nbech ; $i++) {
            $masse="masse".($i);
            $volume="volume".($i);
            $volumeD="volumeD".($i);
            $PD="PD".($i);
            $ref='ref'.($i);
            DB::table('echantillons')->where('reference_labo',$_POST[$ref])
                    ->update([
                        'pc'=>1,
                        'masse_pc' => $_POST[$masse],
                        'vol_pc' => $_POST[$volume],
                        'vid' => $_POST[$volumeD],
                        'pd' => $_POST[$PD],
                    ]);

        }

        DB::table('employe_touchers')
               ->updateOrInsert(
                   [
                       'employe_id' => session('employe_id'),
                        'demande_id' => $demande_id
                       ],
                   ['date_modif' => new \DateTime()]
               );
        return redirect('/Préparation/Chimique');
    }

    public function registres($nameRegistre){

        if ($nameRegistre=='humidite') {
            $registre='Registre Humidité';
        }
        elseif ($nameRegistre=='densite') {
            $registre='Registre Densité';
        }
        elseif ($nameRegistre=='pertefeu') {
            $registre='Registre Perte Feu';

        }
        $demandes=DB::table('demandes')->where('niveau',4)->whereIn('demande_id',function($s1){
            $s1->select('demande_id')
            ->from('echantillons')
                ->whereIn('reference_labo',function($s2){
                    $s2->select('reference_labo')
                        ->from('echantillon_elements')
                            ->whereIn('code_element',function($s3){
                                $s3->select('id')
                                    ->from('elements')
                                    ->where('code','like','PRE.MO/ANA/006')
                                    ->orWhere('code','like','PRE.MO/ANA/016')
                                    ->orWhere('code','like','PRE.MO/ANA/007')
                                ;
                            })->get()
                        ;
                })->get()
            ;
        })->paginate(7);
        return view('preparation.registre',[
            'demandes' => $demandes,
            'nameRegistre' => $registre]
        );
    }

    public function registreEnregistrement($nameRegistre,$demande_id)
    {
        if ($nameRegistre=='nameRegistre') {
            $path='/registreHumidite'.'/'.$demande_id;
            return redirect($path);
        }

     }
     public function humiditeHome(){
        $demandes=DB::table('demandes')->where('niveau',4)->whereIn('demande_id',function($s1){
            $s1->select('demande_id')
            ->from('echantillons')
                ->whereIn('reference_labo',function($s2){
                    $s2->select('reference_labo')
                        ->from('echantillon_elements')
                            ->whereIn('code_element',function($s3){
                                $s3->select('id')
                                    ->from('elements')
                                    ->where('code','like','PRE.MO/ANA/006')
                                    ->orWhere('code','like','PRE.MO/ANA/016')
                                    ->orWhere('code','like','PRE.MO/ANA/007')
                                ;
                            })->get()
                        ;
                })->get()
            ;
        })->paginate(7);
        return view('preparation.resistres.humites.humiditeHome',[
            'demandes' => $demandes,

            ]
        );
     }
     public function createHumidite($demande_id){
        $echantillons=DB::table('echantillons')->where('reference_labo', 'LIKE',"%{$demande_id}%")
        ->distinct() ->get();

        return view('preparation.resistres.humites.himidityForm',[
            'demande_id' => $demande_id,
            'echantillons' => $echantillons,
        ]

        );
     }
    public function addRegistreHumidite()
    {


            $nbech=(count($_POST)-1)/4;
            for ($i=0; $i <$nbech ; $i++)
            {
                $PT="poidsTare".($i);
                $PH="poidsHumide".($i);
                $PS="poidsSeche".($i);
                $ref='ref'.($i);
                    $humidite = new humidite();
                    $humidite->reference_labo = $_POST[$ref];
                    $humidite->poids_tar =$_POST[$PT];
                    $humidite->poids_humid =$_POST[$PH];
                    $humidite->poids_seche =$_POST[$PS];
                    $humidite->created_at = new \DateTime();

                    $humidite->save();

            }
            return redirect('Préparation/Chimique/Registre/humidite');

    }
    public function indexRegistreHumidite(){
        $echantillons = DB::table('humidites')
        ->join('echantillons', 'echantillons.reference_labo', '=', 'humidites.reference_labo')
        ->select('humidites.*', 'echantillons.designation')
        ->paginate(7);
        return view('preparation.resistres.humites.humidite',[
            'echantillons' => $echantillons
        ]);
    }

    public function densiteHome(){
        $demandes=DB::table('demandes')->where('niveau',4)->whereIn('demande_id',function($s1){
            $s1->select('demande_id')
            ->from('echantillons')
                ->whereIn('reference_labo',function($s2){
                    $s2->select('reference_labo')
                        ->from('echantillon_elements')
                            ->whereIn('code_element',function($s3){
                                $s3->select('id')
                                    ->from('elements')
                                    ->where('code','like','PRE.MO/ANA/006')
                                    ->orWhere('code','like','PRE.MO/ANA/016')
                                    ->orWhere('code','like','PRE.MO/ANA/007')
                                ;
                            })->get()
                        ;
                })->get()
            ;
        })->paginate(7);
        return view('preparation.resistres.densites.densiteHome',[
            'demandes' => $demandes,
            ]
        );
    }
    public function addRegistreDensite(){


        $nbech=(count($_POST)-1)/5;
        for ($i=0; $i <$nbech ; $i++)
        {
            $M="masse".$i;
            $T="temperature".$i;
            $Vo="v_initial".$i;
            $V1="v_1".$i;
            $ref='ref'.($i);
                $densite = new densites();
                $densite->reference_labo = $_POST[$ref];
                $densite->vol_initial =$_POST[$Vo];
                $densite->vol_v1 =$_POST[$V1];
                $densite->masse =$_POST[$M];
                $densite->created_at = new \DateTime();

                $densite->save();

        }

        return redirect('Préparation/Chimique/Registre/densite');
    }
    public function createDensite($demande_id){
        $echantillons=DB::table('echantillons')->where('reference_labo', 'LIKE',"%{$demande_id}%")

       ->distinct() ->get();

        return view('preparation.resistres.densites.densiteForm',[
            'demande_id' => $demande_id,
            'echantillons' => $echantillons,
            'nameRegistre' => 'Registre Humidite'
        ]

        );
    }
     public function indexRegistreDensite(){
        $echantillons = DB::table('densites')
        ->join('echantillons', 'echantillons.reference_labo', '=', 'densites.reference_labo')
        ->select('densites.*', 'echantillons.designation')
        ->paginate(7);
        return view('preparation.resistres.densites.densite',[
            'echantillons' => $echantillons
        ]);
    }


    public function pertefeuHome(){
        $demandes=DB::table('demandes')->where('niveau',4)->whereIn('demande_id',function($s1){
            $s1->select('demande_id')
            ->from('echantillons')
                ->whereIn('reference_labo',function($s2){
                    $s2->select('reference_labo')
                        ->from('echantillon_elements')
                            ->whereIn('code_element',function($s3){
                                $s3->select('id')
                                    ->from('elements')
                                    ->where('code','like','PRE.MO/ANA/006')
                                    ->orWhere('code','like','PRE.MO/ANA/016')
                                    ->orWhere('code','like','PRE.MO/ANA/007')
                                ;
                            })->get()
                        ;
                })->get()
            ;
        })->paginate(7);
        return view('preparation.resistres.pertefeus.pertefeuHome',[
            'demandes' => $demandes,
            ]
        );
    }
    public function createPertfeu($demande_id){
        $echantillons=DB::table('echantillons')->where('reference_labo', 'LIKE',"%{$demande_id}%")

       ->distinct() ->get();

        return view('preparation.resistres.pertefeus.pertefeuForm',[
            'demande_id' => $demande_id,
            'echantillons' => $echantillons,
            'nameRegistre' => 'Registre Humidite'
        ]

        );
    }

    public function addRegistrePertefeu(){


        $nbech=(count($_POST)-2)/5;
        for ($i=0; $i <$nbech ; $i++)
        {
            $MC="masse_c".$i;
            $T="temperature".$i;
            $Mo="masse_o".$i;
            $M2h="masse_2h".$i;
            $ref='ref'.($i);
                $densite = new pertefeu();
                $densite->reference_labo = $_POST[$ref];
                $densite->temperature =$_POST[$T];
                $densite->masse_creuse =$_POST[$MC];
                $densite->masse_initiale =$_POST[$Mo];
                $densite->masse_2h =$_POST[$M2h];
                $densite->created_at = new \DateTime();

                $densite->save();

        }

        return redirect('Préparation/Chimique/Registre/pertefeu');
    }

    public function indexRegistrePertefeu(){
        $echantillons = DB::table('pertefeus')
        ->join('echantillons', 'echantillons.reference_labo', '=', 'pertefeus.reference_labo')
        ->select('pertefeus.*', 'echantillons.designation')
        ->paginate(7);
        return view('preparation.resistres.pertefeus.pertefeu',[
            'echantillons' => $echantillons
        ]);
    }

}
