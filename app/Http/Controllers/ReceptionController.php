<?php

namespace App\Http\Controllers;

use App\Models\aas;
use App\Models\demandes;
use App\Models\elements;
use App\Models\employes;
use App\Models\echantillons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Echantillon_elements;


class ReceptionController extends Controller
{
    public function reception(){


        if(session()->has('employe_id')){
            $log=true;
         }else{
            $log=FALSE;
         }

         if($log==FALSE){
             return view('loginForm',[
                 'NamePrepa' => 'reception_']);
         }else
            $nbDemande = demandes::all()->count();
            $nbEch = echantillons::all()->count();
           $elements = elements::all();
            $employe=employes::where('matricule',session('employe_id'))->first();
           return view('reception.reception',[
            'nbEchantillon' => $nbEch,
            'nbDemande' => $nbDemande,
            'elements' =>$elements,
            'employe' => $employe

        ]);
    }

    public function AjouterDemande(Request $request){
        if(
            isset($_POST['demandeur']) && isset($_POST['societe'])&&
            isset($_POST['numDemande']) && isset($_POST['emplacement']) &&
            isset($_POST['etat']) && isset($_POST['nombre']) &&
            isset($_POST['identificateur'])
        ){
            $request->validate([
                'demandeur' => 'bail|required',
                'numDemande' => 'bail|required',
                'emplacement' => 'required',
                'nombre' => 'bail|required|min:1|not_in:0'
            ]);

                $demande = new demandes();
                $demande->demande_id =htmlspecialchars($_POST['numDemande']) ;
                $demande->society = $_POST['societe'];
                $demande->identification_echantillon = $_POST['identificateur'];
                $demande->demandeur =htmlspecialchars($_POST['demandeur']) ;
                $demande->emplacement =htmlspecialchars($_POST['emplacement']) ;
                $demande->etat = $_POST['etat'];
                $demande->echantillonnage = "non renseigner pour le moment";
                $demande->nombre_echantillons = $_POST['nombre'];
                $demande->observation =htmlspecialchars($_POST['observation']) ;
                $demande->livraison =htmlspecialchars($_POST['livraison']) ;
                $demande->created_at = new \DateTime();
                if($_POST['etat']=='liquide'){
                    $demande->niveau=3;
                }
                else $demande->niveau=1;
                if(isset($_POST['depot'])){
                    $demande->depot = $_POST['depot'];
                }

                if(isset($_POST['etatSolid'])){
                    $demande->etat_solid = $_POST['etatSolid'];
                }

                $demande->save();

               DB::table('employe_touchers')
               ->updateOrInsert(
                   [
                       'employe_id' => session('employe_id'),
                        'demande_id' => $_POST['numDemande']
                       ],
                   ['date_modif' => new \DateTime()]
               );
               return redirect('/reception/echantillon/save/'.$_POST['numDemande']);

        }
    }

    public function AjouterDesEchantillons(Request $request,$damande_path){
        $dat=explode('0',date('Y')) ;
        if(
            isset($_POST['designation1']) && isset($_POST['elementAna1'])


        ){


            $nbrECH=(count($_POST)-1)/2;
            for ($i=0; $i <$nbrECH-1 ; $i++) {
                $et1="designation".($i+1);
                $et2="elementAna".($i+1);
                if($i<9){
                    $reference='R/'.$damande_path.'-'. $dat[1].'-0'. ($i+1);
                }
                else
                    $reference='R/'.$damande_path.'-'.$dat[1].'-'. ($i+1);

                $chaineCode=substr($_POST[$et2],0,-1);
                $code = array_unique(explode(';' ,$chaineCode));

                $elements_d_analyse=implode(';',$code);
                DB::table('echantillons')
                    ->updateOrInsert(
                    [
                        'reference_labo' => $reference,
                        'demande_id' => $damande_path
                    ],
                    ['designation' => htmlspecialchars($_POST[$et1]),
                    'elements_d_analyse' => htmlspecialchars($elements_d_analyse),
                    'created_at'=> new \DateTime(),
                    ]
                );
                foreach ($code as $c) {
                    str_replace(array("(", ")"), '', $c);
                    $ti=substr($c,0,3);
                    $t=str_replace(array("(", ")"), '', $ti);
                    $echElem=new Echantillon_elements();
                    $echElem->reference_labo=$reference;
                    $echElem->code_element=(int)$t;
                    $echElem->save();
                }
            }
        }
        return redirect('/reception');

    }
    public function modificationPage(Request $request){

        $demandes=DB::table('demandes')->where('demande_id',htmlspecialchars($request->input('demande_id')))->where('niveau','<=',2)->first();
        if (empty($demandes)) {
            $message="Il y'a aucune demande pour la rception  corrspondant a : ".htmlspecialchars($request->input('demande_id'))." <<ou la demande est deja en cours d'analyse>>";
            return view('404',[
                'message' =>$message,
                'retourPage'=>'/reception'
            ]);
        }
        else{
            $echantillons=DB::table('echantillons')->where('demande_id',htmlspecialchars($request->input('demande_id')))->orderBy('reference_labo')->get();
            $elements = elements::all();
            return view('reception.modification',
            [
                'demande_id' =>$request->input('demande_id'),
                'demandes' => $demandes,
                'echantillons' => $echantillons,
                'elements' => $elements
            ]);
        }
    }
    public function demandeUpdate(Request $request,$demande_id){

        if(
            isset($_POST)

        ){

            $demande = demandes::find($demande_id);
            $data=$request->input();
            $demande->society =htmlspecialchars( $data['society']);
            $demande->identification_echantillon = htmlspecialchars( $data['identif']);
            $demande->demandeur =htmlspecialchars( $data['demandeur']);
            $demande->emplacement = htmlspecialchars( $data['emplacement']);
            $demande->nombre_echantillons= htmlspecialchars( $data['nbrEch']);
            $demande->etat = htmlspecialchars( $data['etat']);
            $demande->save();
        }

        return redirect('reception/');

    }

    public function delete(Request $request,$id){
        $idDem=explode('_',$id);
        $ref="R/".$id;
        try {
            $nbEch=DB::table('demandes')
                                ->where('demande_id', (int)$idDem[0])
                                ->get('nombre_echantillons')
                                ->first();
            $n= (int)$nbEch->nombre_echantillons;
            DB::table('demandes')
              ->where('demande_id', (int)$idDem[0])
              ->update(['nombre_echantillons' => $n-1]);
            DB::table('echantillons')->where('reference_labo', $ref)->delete();
            return redirect('/reception');
        } catch (\Throwable $th) {
            echo "Erreur je sais pas";
            dd();
        }
    }
    public function updatePage($id){
        $ref='R/'.$id;
        $echantillon=DB::table('echantillons')->where('reference_labo',$ref)->first();
        $elements = elements::all();
        return view('Reception.updateEcha',[
            'echantillon' =>$echantillon,
            'elements' => $elements
        ]);

    }
    public function update(Request $request){
        DB::table('echantillons')->where('reference_labo',$request->input('ref'))->update([
            'elements_d_analyse' =>htmlspecialchars($request->input('elements')) ,
            'designation'=>htmlspecialchars($request->input('degn')),
            'created_at'=>new \DateTime(),
        ]);
        $chaineCode=substr($request->input('elements'),0,-1);
        $code = array_unique(explode(';' ,$chaineCode));
        DB::table('echantillon_elements')->where('reference_labo',$request->input('ref'))->delete();
        foreach ($code as $c) {
            str_replace(array("(", ")"), '', $c);
            $ti=substr($c,0,3);
            $t=str_replace(array("(", ")"), '', $ti);
            $echElem=new Echantillon_elements();
            $echElem->reference_labo=$request->input('ref');
            $echElem->code_element=(int)$t;
            $echElem->save();
        }
        return redirect('/reception');
    }
    public function ajouterEchantillon($demande_id){

        $elements = elements::all();
        return view('Reception.ajoutEcha',[
            'demande_id' =>$demande_id,
            'elements' => $elements
        ]);
    }
    public function store(Request $request){
        $demande = demandes::find($request->input('demande_id'));
        $oldNbrEch=$demande->nombre_echantillons;
            DB::table('echantillons')->updateOrInsert(
            [
                'reference_labo'=>htmlspecialchars($request->input('ref')),
                'demande_id'=>$request->input('demande_id')
            ],
            [
                'designation'=>htmlspecialchars($request->input('degn')),
                'elements_d_analyse'=>htmlspecialchars($request->input('elements')),
                'created_at'=>new \DateTime(),
            ]

            );

            DB::table('demandes')->where('demande_id',$request->input('demande_id'))->update([
                'nombre_echantillons'=>$oldNbrEch+1
            ]);

        $chaineCode=substr($request->input('elements'),0,-1);
        $code = array_unique(explode(';' ,$chaineCode));
        foreach ($code as $c) {
            str_replace(array("(", ")"), '', $c);
            $ti=substr($c,0,3);
            $t=str_replace(array("(", ")"), '', $ti);
            $echElem=new Echantillon_elements();
            $echElem->reference_labo=$request->input('ref');
            $echElem->code_element=(int)$t;
            $echElem->save();
        }
        return redirect('/reception');
    }
    public function echantillonPage($demande_id){

        $elements = elements::all();
        $nbDemande = demandes::all()->count();
        $nbrECH=echantillons::all()->count();
        $employe=employes::where('matricule',session('employe_id'))->first();
       $currentDemande=DB::table('demandes')->where('demande_id',$demande_id)->first();
        return view('reception.echantillons',[
            'nbEchantillon' => $nbrECH,
            'nbDemande' => $nbDemande,
            'elements' =>$elements,
            'demande_id' => $demande_id,
            'societe' =>$currentDemande->society,
            'demandeur' => $currentDemande->demandeur,
            'NombreEch' =>$currentDemande->nombre_echantillons,
            'employe' => $employe


        ]);
        return redirect('/reception');
    }
    public function page404( $message){
        return view('404',[
            'message' =>$message
        ]);

    }
}
