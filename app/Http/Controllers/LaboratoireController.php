<?php

namespace App\Http\Controllers;

use App\Models\echantillons;
use App\Models\employes;
use App\Imports\ipcFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class LaboratoireController extends Controller
{
    public function homeVolumetrie(){
        $demandes=DB::table('demandes')->where('niveau',4)->whereIn('demande_id',function($s1){
            $s1->select('demande_id')
            ->from('echantillons')
                ->whereIn('reference_labo',function($s2){
                    $s2->select('reference_labo')
                        ->from('echantillon_elements')
                            ->whereIn('code_element',function($s3){
                                $s3->select('id')
                                    ->from('elements')
                                    ->where('code','like','PRE.MO/ANA/002')
                                    ->orWhere('code','like','PRE.MO/ANA/004')
                                    ->orWhere('code','like','PRE.MO/ANA/003')
                                    ->orWhere('code','like','PRE.MO/ANA/005')
                                ;
                            })->get()
                        ;
                })->get()
            ;
        })->get();

        $employe=employes::where('matricule',session('employe_id'))->first();
        $nbrDemChi= count($demandes);
        $nbrEchChi=DB::table('demandes')->where('niveau',4)->whereIn('demande_id',function($s1){
            $s1->select('demande_id')
            ->from('echantillons')
                ->whereIn('reference_labo',function($s2){
                    $s2->select('reference_labo')
                        ->from('echantillon_elements')
                            ->whereIn('code_element',function($s3){
                                $s3->select('id')
                                    ->from('elements')
                                    ->where('code','like','PRE.MO/ANA/002')
                                    ->orWhere('code','like','PRE.MO/ANA/004')
                                    ->orWhere('code','like','PRE.MO/ANA/003')
                                    ->orWhere('code','like','PRE.MO/ANA/005')
                                ;
                            })->get()
                        ;
                })->get()
            ;
        })->sum('nombre_echantillons');
        return view('laboratoire.volumetrie',[
            'nbEchantillon' => $nbrEchChi,
            'nbDemande' => $nbrDemChi,
            'demandes' => $demandes,
            'employe' => $employe,
            'nameRegistre' =>'Registre volumetrie'
            ]
        );
    }
    public function demandeDetailsVolumetrie($demande_id){
        $echantillons=DB::table('echantillons')->where('demande_id',$demande_id)->get();
        $echantillonsVols = DB::table('echantillons')->where('demande_id',$demande_id)
                    ->join('volumetries', 'echantillons.reference_labo', 'like', 'volumetries.reference_labo')
                    ->select('volumetries.vol_edta', 'echantillons.masse_pc', 'echantillons.reference_labo')
                    -> get();
        $temoin=DB::table('temoin_volums')->where('demande_id',$demande_id)->first();
        $sd1=DB::table('sampleds')->where('demande_id',$demande_id)->where('nom','sd1')->first();
        $sd2=DB::table('sampleds')->where('demande_id',$demande_id)->where('nom','sd2')->first();
        //dd($sd1);

        return view('laboratoire.Details',[
            'demande_id' => $demande_id,
            'echantillons' => $echantillons,
            'temoin'=>$temoin,
            'sd1'=>$sd1,
            'sd2'=>$sd2,
            'echantillonsVols'=>$echantillonsVols,
            'nameRegistre' =>'volumetrie'
            ]
        );
    }

    public function essaieVolumetrie(Request $request){
        //dd($request->all());
        $temoin=DB::table('temoin_volums')->where('demande_id',$request->demande_id)->first();
        $sd1=DB::table('sampleds')->where('demande_id',$request->demande_id)->where('nom','sd1')->first();
        $sd2=DB::table('sampleds')->where('demande_id',$request->demande_id)->where('nom','sd2')->first();
        $data= DB::table('echantillons')->where('demande_id',$request->demande_id)->where('echantillons.reference_labo',$request->reference)
            ->join('volumetries', 'echantillons.reference_labo', 'like', 'volumetries.reference_labo')
            ->select('volumetries.vol_edta', 'echantillons.masse_pc', 'echantillons.reference_labo')
            -> first();

        return view('preparation.resistres.FormEssaiVolumetrie',[
            'sd1'=>$sd1,
            'sd2'=>$sd2,
            'temoin'=>$temoin,
            'data'=>$data,
            'demande_id'=>$request->demande_id
        ]);
    }

    public function addEssaie(Request $request){
        $ech=DB::table('echantillons')->where('reference_labo',$request->ref)->first();

        DB::table('echantillons')->updateOrInsert(
            [
                'reference_labo'=>$ech->reference_labo."*",
            ]
            ,
            [
            'designation'=>$ech->designation,
            'elements_d_analyse'=>$ech->elements_d_analyse,
            'masse_pc'=>$ech->masse_pc,
            'vid'=>$ech->vid,
            'pd'=>$ech->pd,
            'vol_pc'=>$ech->vol_pc,
            'created_at'=>new \DateTime(),
            'demande_id'=>$ech->demande_id

            ]
        );
        DB::table('volumetries')->updateOrInsert(
            [
                'reference_labo'=>$request->ref."*",
            ],
            [
            'vol_edta'=>$request->volTemoin2,
            'created_at'=>new \DateTime()
            ]
        );
        $path='/Labortoire/Volumetrie/demande/autreEssaie?reference='.$request->ref.'&demande_id='.$ech->demande_id;
        return redirect($path);
    }

    public function addTemoinVolumetrie(Request $request,$demande_id){
        DB::table('temoin_volums')
        ->updateOrInsert(
        [   'demande_id'=>$demande_id],
        [   'masse' => $request->input('masseTemoin'),
            'volume' => $request->input('volTemoin'),
            'valeur'=> $request->input('ValTemoin'),
        ]);
        $idT=DB::table('temoin_volums')->where('demande_id',$demande_id)->first('temoin_id');
        for ($i=0; $i <2 ; $i++) {
            $sdvol='sd'.($i+1).'Volume';
            $sdMas='sd'.($i+1).'Masse';
            $sd='sd'.($i+1);

            DB::table('sampleds')
                ->updateOrInsert(
                [   'demande_id'=>$demande_id,
                    'temoin_id' =>$idT->temoin_id,
                    'nom' => $request->input($sd)
                ],
                [   'masse' => $request->input($sdMas),
                    'volume' => $request->input($sdvol),
                ]);
        }
        $path='/Labortoire/Volumetrie/detatils/demande/'.$demande_id;
        return redirect($path);
    }
    public function demandeDetailsAbsorption($demande_id){
        $echantillons=DB::table('aas')->where('reference_labo', 'LIKE',"%{$demande_id}%")
                        ->select('reference_labo')->distinct() ->get();
        $elements = DB::table('echantillons')
                           ->join('aas', 'echantillons.reference_labo', 'like', 'aas.reference_labo')
                           ->select('aas.*', 'echantillons.masse_pc', 'echantillons.vol_pc', 'echantillons.vid', 'echantillons.pd')
                           ->where('demande_id',$demande_id)
                           ->orderBy('reference_labo')-> paginate(7);
        $temoin=DB::table('temoin_a_a_s')->where('demande_id',$demande_id)->first();
       return view('laboratoire.absorptionDetail',[
            'echantillons'=>$echantillons,
            'elements'=>$elements,
            'demande_id'=>$demande_id,
            'temoin'=>$temoin,
           'nameRegistre' =>'absorption'


       ]);
    }

    public function addTemoin(Request $request,$demande_id){
        DB::table('temoin_a_a_s')
        ->updateOrInsert(
        ['demande_id'=>$demande_id],
        ['masse' => $request->input('masse'),
        'volume' => $request->input('volume'),
        'teneur_certif'=> $request->input('teneurCertifie'),
        'lecture'=>$request->input('lecture'),
        ]

        );
        $path="/Labortoire/Absorption/details/demande/".$demande_id;
        return redirect($path);
    }
    public function addRegistre(Request $request,$demande_id){
        $nbech=DB::table('demandes')->where('demande_id',$demande_id)->first('nombre_echantillons');
        for ($i=0; $i <$nbech->nombre_echantillons ; $i++)
        {
            $VETDA="vol".($i);
            $ref='ref'.($i);
            DB::table('volumetries')->updateOrInsert([
                'reference_labo'=>$_POST[$ref]
            ],[
                'vol_edta'=>$_POST[$VETDA],
                'created_at'=>new \DateTime()
            ]);
        }

        $path='Labortoire/Volumetrie/detatils/demande/'.$demande_id;
        return redirect($path);
    }


    public function readFile(){
        return view('/laboratoire/readFileAA');
    }

    public function addDataFromFile(Request $request){

        //dd('bien');
        $path = $request->file('AAFile')->storeAs(
            'local',
            'AAfile.csv'
        );
        $fullPath=Storage::path($path);
        $fh = fopen($fullPath, 'r');
        $i=0;
        while(!feof($fh)) {
            $line = fgets($fh,255);

           $data=explode(',',strtr($line, "\"", " "));
          switch (trim($data[0])) {
            case 'Ag':
                $Resultant=mb_strstr($data[1],'R/',false,"ASCII");
                if (!empty($Resultant)) {
                    $reference_labo=(string)trim($data[1]);
                    $echantillons =  echantillons::where('reference_labo',$reference_labo)->get();
                    if ($echantillons!=null) {
                        DB::table('aas')
                        ->updateOrInsert(
                            ['reference_labo' =>$reference_labo,
                             'code_element' => 8],
                            ['lecture' => (float)$data[2] ]
                        );
                    }
                    else echo "l'echantiollon :".$data[1]." n'existe pas dans la base de donnees<br>";

                }
                  break;
            case 'Cu':
                $Resultant=mb_strstr($data[1],'R/',false,"ASCII");
                if (!empty($Resultant) ) {
                    $reference_labo=(string)trim($data[1]);
                    $echantillons =  echantillons::where('reference_labo',$reference_labo)->get();
                    if ($echantillons!=NULL) {
                        DB::table('aas')
                            ->updateOrInsert(
                                ['reference_labo' =>$reference_labo,
                                 'code_element' => 9],
                                ['lecture' => (float)$data[2] ]
                            );
                    }
                    else echo "l'echantiollon :".$data[1]." n'existe pas dans la base de donnees<br>";
                }
                  break;
            case 'Pb':
                $Resultant=mb_strstr($data[1],'R/',false,"ASCII");
                    if (!empty($Resultant) ) {
                        $reference_labo=(string)trim($data[1]);
                        $echantillons =  echantillons::where('reference_labo',$reference_labo)->get();
                        if ($echantillons!=NULL) {
                            DB::table('aas')
                            ->updateOrInsert(
                                ['reference_labo' =>$reference_labo,
                                 'code_element' => 10],
                                ['lecture' => (float)$data[2] ]
                            );
                        }
                        else echo "l'echantiollon :".$data[1]." n'existe pas dans la base de donnees<br>";
                    }
                    break;
            case 'Zn':
                $Resultant=mb_strstr($data[1],'R/',false,"ASCII");
                    if (!empty($Resultant) ) {
                        $reference_labo=(string)trim($data[1]);
                        $echantillons =  echantillons::where('reference_labo',$reference_labo)->get();
                        if ($echantillons!=NULL) {
                            DB::table('aas')
                            ->updateOrInsert(
                                ['reference_labo' =>$reference_labo,
                                 'code_element' => 11],
                                ['lecture' => (float)$data[2] ]
                            );
                        }
                        else echo "l'echantiollon :".$data[1]." n'existe pas dans la base de donnees<br>";
                    }
                    break;
            case 'Mn':
                $Resultant=mb_strstr($data[1],'R/',false,"ASCII");
                    if (!empty($Resultant) ) {
                        $reference_labo=(string)trim($data[1]);
                        $echantillons =  echantillons::where('reference_labo',$reference_labo)->get();
                        if ($echantillons!=NULL) {
                            DB::table('aas')
                            ->updateOrInsert(
                                ['reference_labo' =>$reference_labo,
                                 'code_element' => 12],
                                ['lecture' => (float)$data[2] ]
                            );
                        }
                        else echo "l'echantiollon :".$data[1]." n'existe pas dans la base de donnees<br>";
                    }
                    break;
            case 'Co':
                $Resultant=mb_strstr($data[1],'R/',false,"ASCII");
                    if (!empty($Resultant) ) {
                        $reference_labo=(string)trim($data[1]);
                        $echantillons =  echantillons::where('reference_labo',$reference_labo)->get();
                        if ($echantillons!=NULL) {
                            DB::table('aas')
                            ->updateOrInsert(
                                ['reference_labo' =>$reference_labo,
                                 'code_element' => 13],
                                ['lecture' => (float)$data[2] ]
                            );
                        }
                        else echo "l'echantiollon :".$data[1]." n'existe pas dans la base de donnees<br>";
                    }
                    break;
            case 'Ni':
                $Resultant=mb_strstr($data[1],'R/',false,"ASCII");
                    if (!empty($Resultant) ) {
                        $reference_labo=(string)trim($data[1]);
                        $echantillons =  echantillons::where('reference_labo',$reference_labo)->get();
                        if ($echantillons!=NULL) {
                            DB::table('aas')
                            ->updateOrInsert(
                                ['reference_labo' =>$reference_labo,
                                 'code_element' => 14],
                                ['lecture' => (float)$data[2] ]
                            );
                        }
                        else echo "l'echantiollon :".$data[1]." n'existe pas dans la base de donnees<br>";
                    }
                    break;
            case 'Fe':
                $Resultant=mb_strstr($data[1],'R/',false,"ASCII");
                    if (!empty($Resultant) ) {
                        $reference_labo=(string)trim($data[1]);
                        $echantillons =  echantillons::where('reference_labo',$reference_labo)->get();
                        if ($echantillons!=NULL) {
                            DB::table('aas')
                            ->updateOrInsert(
                                ['reference_labo' =>$reference_labo,
                                 'code_element' => 15],
                                ['lecture' => (float)$data[2] ]
                            );
                        }
                            else echo "l'echantiollon Fe :".$data[1]." n'existe pas dans la base de donnees<br>";
                    }
                    break;
          }
            $i++;
          }
        fclose($fh);
        // $data=Excel::import(new Lecture, $request->file('AAFile'));
        return redirect('/laboratoire/Absorption');
    }

    public function resultAA(Request $request,$element){


        switch ($element) {
            case 'Ag':
                $code_ele=8;
                break;
            case 'Cu':
                $code_ele=9;
                break;
            case 'Pb':
                $code_ele=10;
                break;
            case 'Zn':
                $code_ele=11;
                break;
            case 'Mn':
                $code_ele=12;
                break;
            case 'Co':
                $code_ele=13;
                break;
            case 'Ni':
                $code_ele=14;
                    break;
            case 'Fe':
                $code_ele=15;
                    break;
        }

        $nbrEch='nombreEchantillon'.$element;
        for ($i=0; $i < $_POST[$nbrEch]; $i++) {
            $ref='ref'.$element.'_'.($i);
            $volD='vol'.$element.'_'.($i);
            $PD='pd'.$element.'_'.($i);
            $pd=(double)$_POST[$PD]+0.0;
            // dd($pd);
            try {
                DB::table('aas')
              ->where('reference_labo', $_POST[$ref])
              ->where('code_element',$code_ele)
              ->update(['vid' => $_POST[$volD],'pd'=>$pd ]);
            } catch (\Throwable $th) {
                dd($th);
            }

        }
        return redirect('/laboratoire/Absorption');
    }

    public function homeAbsorption (){
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
                                ;
                            })->get()
                        ;
                })->get()
            ;
        })->get();

        $nbrDemChi= count($demandes);
        $nbrEchChi=DB::table('demandes')->where('niveau',4)->whereIn('demande_id',function($s1){
            $s1->select('demande_id')
            ->from('echantillons')
                ->whereIn('reference_labo',function($s2){
                    $s2->select('reference_labo')
                        ->from('echantillon_elements')
                            ->whereIn('code_element',function($s3){
                                $s3->select('id')
                                    ->from('elements')
                                    ->where('code','like','PRE.MO/ANA/006')
                                ;
                            })->get()
                        ;
                })->get()
            ;
        })->sum('nombre_echantillons');
        $employe=employes::where('matricule',session('employe_id'))->first();
        return view('laboratoire.absorption',[
            'nbEchantillon' => $nbrEchChi,
            'nbDemande' => $nbrDemChi,
            'demandes' => $demandes,
            'employe' => $employe,
            'nameRegistre' =>'absorption'
            ]
        );
    }

    public function indexRegistreVolumetrie(Request $request){
        $demande=DB::table('demandes')->where('niveau',4)->whereIn('demande_id',function($s1){
            $s1->select('demande_id')
            ->from('echantillons')->where('demande_id',$_GET['demande_id'])
                ->whereIn('reference_labo',function($s2){
                    $s2->select('reference_labo')
                        ->from('echantillon_elements')
                            ->whereIn('code_element',function($s3){
                                $s3->select('id')
                                    ->from('elements')
                                    ->where('code','like','PRE.MO/ANA/002')
                                    ->orWhere('code','like','PRE.MO/ANA/004')
                                    ->orWhere('code','like','PRE.MO/ANA/003')
                                    ->orWhere('code','like','PRE.MO/ANA/005')
                                ;
                            })->get()
                        ;
                })->get()
            ;
        })->first();
      if (empty($demande)) {
        $message="Aucune Demande pour la Volumetrie correspondant à : ".$request->input('demande_id');
        return view('404',[
            'message' =>$message,
            'retourPage' =>"/laboratoire/Volumetrie"
        ]);
      }
        $temoin=DB::table('temoin_volums')->where('demande_id',$request->input('demande_id'))->first();
        $sd1=DB::table('sampleds')->where('demande_id',$request->input('demande_id'))->where('nom','sd1')->first();
        $sd2=DB::table('sampleds')->where('demande_id',$request->input('demande_id'))->where('nom','sd2')->first();
        $echantillons = DB::table('volumetries')
        ->join('echantillons', 'echantillons.reference_labo', '=', 'volumetries.reference_labo')
        ->select('volumetries.*', 'echantillons.masse_pc', 'echantillons.reference_labo','echantillons.designation','echantillons.demande_id')
        ->orderBy('volumetries.reference_labo')->paginate(7);
        return view('preparation.resistres.volumetrie',[
            'echantillons' => $echantillons,
            'temoin'=>$temoin,
            'sd1'=>$sd1,
            'sd2'=>$sd2,

        ]);
    }

    public function validerDemandeVolumetrie($demande_id){
        DB::table('demandes')->where('demande_id',$demande_id)->update([
            'niveau'=>5
        ]);
        return redirect('/laboratoire/Volumetrie');
    }

    public function validerDemandeAbsorption($demande_id){
        DB::table('demandes')->where('demande_id',$demande_id)->update([
            'niveau'=>6
        ]);
        return redirect('/laboratoire/Absorption');
    }

    public function homeICP(){
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
                                ;
                            })->get()
                        ;
                })->get()
            ;
        })->get();

        $nbrDemChi= count($demandes);
        $nbrEchChi=DB::table('demandes')->where('niveau',4)->whereIn('demande_id',function($s1){
            $s1->select('demande_id')
            ->from('echantillons')
                ->whereIn('reference_labo',function($s2){
                    $s2->select('reference_labo')
                        ->from('echantillon_elements')
                            ->whereIn('code_element',function($s3){
                                $s3->select('id')
                                    ->from('elements')
                                    ->where('code','like','PRE.MO/ANA/006')
                                ;
                            })->get()
                        ;
                })->get()
            ;
        })->sum('nombre_echantillons');
        $employe=employes::where('matricule',session('employe_id'))->first();

        return view('laboratoire.ipc',[
            'nbEchantillon' => $nbrEchChi,
            'nbDemande' => $nbrDemChi,
            'demandes' => $demandes,
            'employe' => $employe,
            'nameRegistre' =>'ICP',

        ]);
    }


    public function import()
    {
        (new ipcFile())->import(request()->file('upload'));

        return redirect('/laboratoire/ICP')->with([
            "message"=>'Le fichier a été charger avec succes....'
        ]);

    }

    public function showDemandeIcp(Request $request){

        $demande_id=htmlentities($request->input('demande_id'));
        $echantillons=DB::table('analyse_icps')->where('reference_labo', 'LIKE',"R/{$demande_id}%")->orderBy('reference_labo')->orderBy('element')->paginate(7);
        $e=DB::table('analyse_icps')->where('reference_labo', 'LIKE',"%{$demande_id}%")->first();
        $header=DB::table('echantillons')->where('demande_id',$demande_id)->select('reference_labo')->get();
        //dd($echantillons);
       if (empty($e)) {
            $message="Il y'a aucun resultat pour cette demande(".$demande_id.") Veillez charger le fichier contenant la demande. MERCI....";
            return view('404',[
                'message' =>$message,
                'retourPage' =>"/laboratoire/ICP"
            ]);
       }
       else
            return view('laboratoire.indexIcp',[
                'echantillons'=>$echantillons,
                'demande_id'=>$demande_id,
                'headers'=>$header
            ]);

    }
}
