<?php

namespace App\Http\Controllers;

use App\Models\Spreadsheet_Excel_Reader;
use App\Models\employes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Dompdf\Dompdf;
use Dompdf\Options;

class adminController extends Controller
{
   public function adminPage(){
    $demandes=DB::table('demandes')->where('niveau','>=',3)
                                    ->select([
                                        'demande_id',
                                        'nombre_echantillons',
                                        'created_at'
                                        
                                    ])
                                   ->orderBy('created_at','desc') 
                                    ->paginate(5);
    $connectes=DB::table('employes')->where('connecte',1)->get();
    $nbrConnecter=count($connectes);

       return view('administration.superAdmin',[
        'demandes' => $demandes,
        'connectes' => $connectes,
            'nbrCon'=>$nbrConnecter
       ]);
   }

   public function adminRT()
   {
        $connectes=DB::table('employes')->where('connecte',1)->get();
        $nbrConnecter=count($connectes);
        $infos = DB::table('employe_touchers')
        ->join('demandes', 'employe_touchers.demande_id', '=', 'demandes.demande_id')
        ->select('demandes.demande_id', 'demandes.nombre_echantillons','demandes.created_at')
        ->distinct('demandes.demande_id')
        ->paginate(5);
        $demandes=DB::table('demandes')->where('niveau','<=',3)->paginate(5);
        return view('administration.adminRT',[
            'demandes' => $demandes,
            'connectes' => $connectes,
            'nbrCon'=>$nbrConnecter

        ]);
    }

    public function ajoutEmploye(){
        if(isset($_POST['nom']) && isset($_POST['password'])  && isset($_POST['matricule'])&& isset($_POST['service'])){
                    $receptor = new employes();
                    $receptor->name = htmlspecialchars($_POST['nom']);
                    $receptor->matricule = htmlspecialchars($_POST['matricule']);
                    $receptor->password = sha1($_POST['password']);
                    $receptor->service = $_POST['service'];
                    $receptor->save();
                    return redirect('admin');

        }
    }

    public function details($demande_id){


        $connectes=DB::select('select * from employes where connecte = ?', [1]);
        $nbrConnecter=count($connectes);
        $echantillons=DB::table('echantillons')->where('pm', 1)->where('pc', 1)->where('demande_id',$demande_id)->paginate(5);
        $employes = DB::table('employe_touchers')
        ->join('demandes', 'employe_touchers.demande_id', '=', 'demandes.demande_id')
        ->join('employes', 'employe_touchers.employe_id', '=', 'employes.matricule')
        ->select('employes.nom','employes.service','employes.matricule','employe_touchers.date_modif')
        ->get();
        $connectes=DB::table('employes')->where('connecte',1)->get();
        return view('administration.details',[
            'employes' => $employes,
            'echantillons' => $echantillons,
            'nbrCon'=>$nbrConnecter,
            'demade_id' =>$demande_id,
            'connectes' => $connectes

        ]);
    }
    public function rapport($demande_id){
        $demande=DB::table('demandes')->where('demande_id',$demande_id)->first();
        $echantillons=DB::table('echantillons')->where('demande_id',$demande_id)->get();
        return view('administration.formRapport',[
            'demande_id'=>$demande_id,
            'demande'=>$demande,
            'echantillons'=>$echantillons
        ]);
    }
    public function rapportGenere($demande_id){
        $demande=DB::table('demandes')->where('demande_id',$demande_id)->first();
        $echantillons=DB::table('echantillons')->where('demande_id',$demande_id)->get();

        //instancie et utilise la classe
        $options = new Options();
        $dompdf = new Dompdf(array('enable_remote' => true));
        $options = $dompdf->getOptions();
       // $options->set('isRemoteEnabled',true);
        $options->setDefaultFont('Courier');
        $dompdf->setOptions($options);
        $dompdf -> loadHtml (view('administration.formRapport',[
            'demande_id'=>$demande_id,
            'demande'=>$demande,
            'echantillons'=>$echantillons
        ]) );

        // (Facultatif) Configurez le format et l'orientation du papier
        $dompdf -> setPaper ( 'A4','portrait');

        // Rendu HTML au format PDF
        $dompdf -> render ();

        // Exporte le PDF généré vers le navigateur
        $name="Rapport_".$demande_id;
        $dompdf -> stream ($name);

    }


}
