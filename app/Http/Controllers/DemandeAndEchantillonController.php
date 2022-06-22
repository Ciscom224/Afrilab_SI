<?php

namespace App\Http\Controllers;

use App\Models\demandes;
use App\Models\elements;
use App\Models\echantillons;
use Illuminate\Http\Request;

class DemandeAndEchantillonController extends Controller {


    public function deleteDemande($demande_id){
        if(isset($demande_id)){
            // echantillons::where('demand_id',$demande_id)->delete();
            demandes::where('demande_id',$demande_id)->delete();
            return redirect('reception/');

        }
    }


    public function addEchantillon(Request $request,$damande_path){

        if(
            isset($_POST['designation1']) && isset($_POST['elementAna1'])


        ){


            $nbrECH=(count($_POST)-1)/2;
            for ($i=0; $i <$nbrECH ; $i++) {
                $et1="designation".($i+1);
                $et2="elementAna".($i+1);
                $reference='';
                $chaineCode=substr($_POST[$et2],0,-1);
                $code = array_unique(explode(';' ,$chaineCode));
                $elements_d_analyse=implode(';',$code);
                $echantillon = new echantillons();
                $echantillon->designation = htmlspecialchars($_POST[$et1]);
                $echantillon->reference_labo = $reference;
                $echantillon->elements_d_analyse = htmlspecialchars($elements_d_analyse);
                $echantillon->demande_id = $damande_path;
                $echantillon->created_at = new \DateTime();

                $echantillon->save();
            }
            return redirect('reception/');


        }else{
            dd('on est a la fin');
        }
    }

    public function getDemande(){
        if(isset($_GET['demandeId'])){
            $demande = demandes::where('demand_id',$_GET['demandeId'])->first();
            if(!empty($demande)){
                $echantillons =  echantillons::where('demand_id',$_GET['demandeId'])->get();
                return response()->json([
                    'demande' => $demande,
                    'echantillons' => $echantillons,
                    'demandeExist' => true,
                ]);
            }else{
                return response()->json([
                    'demandeExist' => false,
                    'message' => "Aucune demande trouvée pour le numéro de demande : "  .$_GET['demandeId'],
                ]);
            }
        }
    }

    public function demandeUpdate(Request $request,$demande_id){
        if(
            isset($_POST['demande_id']) && isset($_POST['societe'])

        ){
            dd($_POST);
            $demande = demandes::where("demand_id",$_POST['numDemande']);
            $demande->society = $_POST['societe'];
            $demande->identification_echantillon = $_POST['identification_echantillon'];
            $demande->demandeur = $_POST['demand'];
            $demande->emplacement = $_POST['emplacement'];
            $demande->etat = $_POST['etat'];
            $demande->echantillonnage = $_POST['echantillonnage'];

            if(isset($_POST['depot'])){
                $demande->depot = $_POST['depot'];
            }

            if(isset($_POST['etatSolid'])){
                $demande->etat_solid = $_POST['etatSolid'];
            }

            $demande->save();
            return response()->json([
                'success' => true,
            ]);
        }else{
            return response()->json([
                'success' => false,
            ]);
        }
    }

    public function updateEchantillon(Request $request){
        if(
            isset($_POST['designation']) && isset($_POST['reference'])
            && isset($_POST['elementAnalyse'])
            && isset($_POST['demandId'])
        ){
            $table = explode(';',$_POST['elementAnalyse']);
            $elements_d_analyse =  "";
            for($i=0;$i < count($table);$i++) {
                $element = elements::where("identicateur",trim($table[$i]))->first();
                if($i ==0){
                    $elements_d_analyse .= $element->nom_analyse;
                }else{
                    $elements_d_analyse .= ",".$element->nom_analyse;
                }
            }

            $echantillon = echantillons::where([
                ['demand_id',$_POST['demandeId']],
                ['reference_labo',$_POST['reference']]
            ])->first();

            $echantillon->designation = $_POST['designation'];
            $echantillon->elements_d_analyse = $elements_d_analyse;

            $echantillon->save();
            return response()->json([
                'success' => true,
            ]);
        }else{
            return response()->json([
                'success' => false,
            ]);
        }
    }

}

