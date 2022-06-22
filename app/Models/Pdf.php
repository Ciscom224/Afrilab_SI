<?php

namespace App\Models;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\DB;


class Pdf extends fpdf
{
    public function Header()
    {
        $this->Image(storage_path() . '/fontRapport.jpeg', 0, 0, $this->w, $this->h);
        $this->Image(storage_path() . '/logoAfri.png',5,15,70);
        $this->SetDrawColor(3, 73, 119);
        $this->SetLineWidth(0.4);
        $this->Line(4,6,205,6);
        $this->SetFont('Arial','B',17);
        $this->Cell(89);
        $this->Cell(30,20,'FORMULAIRE DE REALISATION',0,1,'C');
        $this->SetFont('Arial','I',12);
        $this->Cell(20);
        $this->Cell(0,0,"RAPPORT D'ANALYSE - ANALYTICAL REPORT",0,0,'C');
        $this->Image(storage_path() . '/sgs.jpeg',168,7,38);
        $this->SetFont('Arial','B',10);
        $this->Cell(5,30,"Certificat N° : MA20/819942595",0,0,'R');

        $this->Line(4,47,205,47);
        $this->Ln(30);
    }

    public function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('Arial','B',10);
        $this->Cell(0,0,'Page '.$this->PageNo().'/{nb}',0,1,'R');
        $this->SetDrawColor(3, 73, 119);
        $this->SetLineWidth(0.9);
        $this->Line(5,280,200,280);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,"Adresse : N°344 zone industrielle Sidi Ghanem (près de la poste) - Marrakech- BP : 40 000-Maroc/ Mobile: (+212) 6 61 60 15 15   Fixe/Fax: (+212) 5 24 35 81 81 ",0,1,"C");
        $this->Cell(0,0,"ICE: 001627543000055- Patente: 64094960- IF: 18777160- RC: 74473-CNSS: 4887058",0,1,"C");

    }



    public function dataIcp($demande_id,$debut,$largeur){

        $data_ppm=[];
        $data=[];
        $dataAll=[];
        // $heade=DB::table('echantillons')->where('reference_labo','LIKE',"%{$demande_id}%")
        //     ->select('reference_labo')
        //     ->where('echantillons.reference_labo','NOT LIKE',"%*")
        //     ->distinct()->get();
        // $i=1;
        // foreach ($heade as $k) {
        //     $data[0][$i]=$k->reference_labo;
        //     $i++;
        // }

        $c=1;
        $l=0;
        $echantillon_p=DB::table('analyse_icps')->where('reference_labo','LIKE',"%{$demande_id}%")
                                                ->where('element','LIKE',"%(\%)")
                                                ->select('element','reference_labo','result')
                                                ->distinct('element')->get();
            foreach ($echantillon_p as $ech) {
                $data[$l][0]=$ech->element;
                $c=1;
                foreach ($echantillon_p as $e) {
                    if (strcmp($ech->element,$e->element)==0 ) {
                        $data[$l][$c]=$e->result;
                        $c++;
                    }
                }
                $l++;
            }

        $echantillon_ppm=DB::table('analyse_icps')->where('reference_labo','LIKE',"%{$demande_id}%")
                                                ->where('element','NOT LIKE',"%(\%)")
                                                ->select('element','reference_labo','result')
                                                ->get();
        $l=0;
        foreach ($echantillon_ppm as $ech) {
            $data_ppm[$l][0]=$ech->element;
            $c=1;
            foreach ($echantillon_ppm as $e) {
                if (strcmp($ech->element,$e->element)==0 ) {
                    $data_ppm[$l][$c]=$e->result;
                    $c++;
                }
                else
                    $data_ppm[$l][$c]=$e->result;

            }
            $l++;
        }
       $dataICP=$data+$data_ppm;
       // humidites
       $taille=count($dataAll);
       $humid[$taille][0]="H2O (%)";
      $humdite=DB::table('humidites')->where('reference_labo','LIKE',"R/{$demande_id}%")->get();
      $humd=DB::table('humidites')->where('reference_labo','LIKE',"R/{$demande_id}%")->first();
      if(!empty($humd)){
            $hi=1;
          foreach ($humdite as $e) {
            $p=$e->poids_seche - $e->poids_tar;
            $humid[$taille][$hi]=round((($e->poids_humid-$p)/$e->poids_humid)*100,2);
            $hi++;
          }
          $dataAll=$dataAll+$humid;
      }
          //densite
       $taille=count($dataAll);
        $dens[$taille][0]="Densite";
        $densi=DB::table('densites')->where('reference_labo','LIKE',"%{$demande_id}%")->get();
        $den=DB::table('densites')->where('reference_labo','LIKE',"R/{$demande_id}%")->first();
        if(!empty($den)){
            $di=1;
            foreach ($densi as $d) {
                $dens[$taille][$di]=round(($d->masse/($d->vol_v1-$d->vol_initial)),3);
                $di++;
            }
            $dataAll=$dataAll+$dens;
        }

        //volumetrie
        $taille=count($dataAll);
        $volume[$taille][0]="C(%)";
        $vol=DB::table('volumetries')->where('reference_labo','LIKE',"R/{$demande_id}%")->first();

        if(!empty($vol)){
            $echantillonsVols = DB::table('echantillons')->where('demande_id',$demande_id)
            ->join('volumetries', 'echantillons.reference_labo', 'like', 'volumetries.reference_labo')
            ->select('volumetries.vol_edta', 'echantillons.masse_pc','echantillons.reference_labo')
            ->where('echantillons.reference_labo','NOT LIKE',"%*")
            -> get();
            $temoin=DB::table('temoin_volums')->where('demande_id',$demande_id)->first();
            $sd1=DB::table('sampleds')->where('demande_id',$demande_id)->where('nom','sd1')->first();
            $sd2=DB::table('sampleds')->where('demande_id',$demande_id)->where('nom','sd2')->first();
            $const1=((float)$sd1->masse/(float)$sd1->volume)*100;
            $const2=((float)$sd2->masse/(float)$sd2->volume)*100;
            $sd1=$const1*((float)$temoin->volume/(float)$temoin->masse);
            $sd2=$const2*((float)$temoin->volume/(float)$temoin->masse);
            $ci=1;
            foreach ($echantillonsVols as $echantillonsVol) {
                $volume[$taille][$ci]=round(((float)$temoin->valeur/(((float)$sd1+(float)$sd2)/2))*((float)$echantillonsVol->vol_edta/(float)$echantillonsVol->masse_pc),3);
                $ci++;
            }
            $dataAll=$dataAll+$volume;
        }

          //     //aa
            //la liste des elements]
        $taille=count($dataAll);

        $aa =DB::table('echantillons')
                ->join('aas', 'echantillons.reference_labo', 'like', 'aas.reference_labo')
                ->select('aas.*', 'echantillons.masse_pc', 'echantillons.vol_pc', 'echantillons.vid', 'echantillons.pd')
                ->where('demande_id',$demande_id)
                ->get();

        $a=DB::table('aas')->where('reference_labo','LIKE',"R/{$demande_id}%")->first();

        $temoin=DB::table('temoin_a_a_s')->where('demande_id',$demande_id)->first();
        $dataAg=[];
        $dataCu=[];
        $dataPb=[];
        $dataZn=[];
        $dataMn=[];
        $dataCo=[];
        $dataNi=[];
        $dataFe=[];

        if(!empty($a)){
            foreach ($aa as $name) {
                switch ($name->code_element) {
                    case 8:
                        $dataAg[0][0]="Ag (%)";
                        break;
                    case 9:
                        $dataCu[0][0]="Cu (%)";
                        break;
                    case 10:
                        $dataPb[0][0]="Pb (%)";
                        break;
                    case 11:
                        $dataZn[0][0]="Zn (%)";
                        break;
                    case 12:
                        $dataMn[0][0]="Mn (%)";
                        break;
                    case 13:
                        $dataCo[0][0]="Co (%)";
                        break;
                    case 14:
                        $dataNi[0][0]="Ni (%)";
                        break;
                    case 15:
                        $dataFe[0][0]="Fe (%)";
                        break;
                }
                $currentEleme=$name->code_element;
                $agi=$cui=$pbi=$zni=$mni=$coi=$nii=$fei=1;
                foreach ($aa as $ea) {
                    $teneurCalculer=(((float)$temoin->lecture*(float)$temoin->volume)/((float)$temoin->masse*(float)$ea->vid))/(float)$ea->pd;
                    $coefficient=((float)$teneurCalculer)/(float)$temoin->teneur_certif;
                    $teneur=(((float)$ea->lecture*(float)$ea->vol_pc)/((float)$ea->masse_pc*(float)$ea->vid))/(float)$ea->pd;
                    $correcteur=$coefficient*$teneur;
                    if ($ea->code_element==$currentEleme && $ea->code_element==15) {
                        $dataFe[0][$fei]=round($correcteur,3) ;
                        $fei++;
                    }
                    elseif ($ea->code_element==$currentEleme && $ea->code_element==11) {
                        $dataZn[0][$zni]=round($correcteur,3) ;
                        $zni++;
                    }
                    elseif ($ea->code_element==$currentEleme && $ea->code_element==8) {
                        $dataAg[0][$agi]=round($correcteur,3) ;
                        $agi++;
                    }
                    elseif ($ea->code_element==$currentEleme && $ea->code_element==9) {
                        $dataCu[0][$cui]=round($correcteur,3) ;
                        $cui++;
                    }
                    elseif ($ea->code_element==$currentEleme && $ea->code_element==10) {
                        $dataPb[0][$pbi]=round($correcteur,3) ;
                        $pbi++;
                    }
                    elseif ($ea->code_element==$currentEleme && $ea->code_element==12) {
                        $dataMn[0][$mni]=round($correcteur,3) ;
                        $mni++;
                    }
                    elseif ($ea->code_element==$currentEleme && $ea->code_element==13) {
                        $dataCo[0][$coi]=round($correcteur,3) ;
                        $coi++;
                    }
                    elseif ($ea->code_element==$currentEleme && $ea->code_element==13) {
                        $dataNi[0][$nii]=round($correcteur,3) ;
                        $nii++;
                    }

                }

            }

        }
        if (count($dataICP)!=0) {
            if (count($dataICP)>18) {
                for ($i=1; $i <18; $i++) {
                    if (strcmp($dataICP[$i][0],$dataICP[$i-1][0])!=0) {

                        for ($l=0; $l <$largeur; $l++) {
                            if ($l==0) {
                                $this->Cell(35,10,$dataICP[$i-1][$l],1,0,'C',1);

                            }
                            else
                                $this->Cell(35,10,$dataICP[$i-1][$l],1,0,'C',0);
                        }
                        $this->Ln();
                    }

                }
                $this->dataHead($debut,$largeur,$demande_id);
                for ($i=18; $i <count($dataICP); $i++) {
                    if (strcmp($dataICP[$i][0],$dataICP[$i-1][0])!=0) {

                        for ($l=0; $l <$largeur; $l++) {
                            if ($l==0) {
                                $this->Cell(35,10,$dataICP[$i-1][$l],1,0,'C',1);

                            }
                            else
                                $this->Cell(35,10,$dataICP[$i-1][$l],1,0,'C',0);
                        }
                        $this->Ln();
                    }

                }

            }
            else{
                for ($i=0; $i <count($dataICP); $i++) {
                    if (strcmp($dataICP[$i][0],$dataICP[$i-1][0])!=0) {

                        for ($l=0; $l <$largeur; $l++) {
                            if ($l==0) {
                                $this->Cell(35,10,$dataICP[$i-1][$l],1,0,'C',1);

                            }
                            else
                                $this->Cell(35,10,$dataICP[$i-1][$l],1,0,'C',0);
                        }
                        $this->Ln();
                    }

                }
            }

        }
        if(count($dataAg)){
            for ($l=0; $l <$largeur ; $l++) {
                if ($l==0) {
                    $this->Cell(35,10,$dataAg[0][$l],1,0,'C',1);

                }
                else
                    $this->Cell(35,10,$dataAg[0][$l],1,0,'C',0);
            }
            $this->Ln();
        }
        if(count($dataFe)){
            for ($l=0; $l <$largeur ; $l++) {
                if ($l==0) {
                    $this->Cell(35,10,$dataFe[0][$l],1,0,'C',1);

                }
                else
                    $this->Cell(35,10,$dataFe[0][$l],1,0,'C',0);
            }
            $this->Ln();
        }
        if(count($dataZn)){
            for ($l=0; $l <$largeur ; $l++) {
                if ($l==0) {
                    $this->Cell(35,10,$dataZn[0][$l],1,0,'C',1);

                }
                else
                    $this->Cell(35,10,$dataZn[0][$l],1,0,'C',0);
            }
            $this->Ln();
        }
        if(count($dataCu)){
            for ($l=0; $l <$largeur ; $l++) {
                if ($l==0) {
                    $this->Cell(35,10,$dataCu[0][$l],1,0,'C',1);

                }
                else
                    $this->Cell(35,10,$dataCu[0][$l],1,0,'C',0);
            }
            $this->Ln();
        }

        if(count($dataPb)){
            for ($l=0; $l <$largeur ; $l++) {
                if ($l==0) {
                    $this->Cell(35,10,$dataPb[0][$l],1,0,'C',1);

                }
                else
                    $this->Cell(35,10,$dataPb[0][$l],1,0,'C',0);
            }
            $this->Ln();
        }
        if(count($dataCo)){
            for ($l=0; $l <$largeur ; $l++) {
                if ($l==0) {
                    $this->Cell(35,10,$dataCo[0][$l],1,0,'C',1);

                }
                else
                    $this->Cell(35,10,$dataCo[0][$l],1,0,'C',0);
            }
            $this->Ln();
        }
        if(count($dataMn)){
            for ($l=0; $l <$largeur ; $l++) {
                if ($l==0) {
                    $this->Cell(35,10,$dataMn[0][$l],1,0,'C',1);

                }
                else
                    $this->Cell(35,10,$dataMn[0][$l],1,0,'C',0);
            }
            $this->Ln();
        }
        if(count($dataNi)){
            for ($l=0; $l <$largeur ; $l++) {
                if ($l==0) {
                    $this->Cell(35,10,$dataNi[0][$l],1,0,'C',1);

                }
                else
                    $this->Cell(35,10,$dataNi[0][$l],1,0,'C',0);
            }
            $this->Ln();
        }
        //dd(count($dataAll));
        if (count($dataAll)!=0) {
            for ($i=0; $i <count($dataAll); $i++) {

                    for ($l=0; $l <$largeur; $l++) {
                        if ($l==0) {
                            $this->Cell(35,10,$dataAll[$i][$l],1,0,'C',1);

                        }
                        else
                            $this->Cell(35,10,$dataAll[$i][$l],1,0,'C',0);
                    }
                    $this->Ln();

            }
        }

    }
    public function dataHead($debut,$largeur,$demande_id){
        $data[0][0]="Ref_lab";
        $heade=DB::table('echantillons')->where('reference_labo','LIKE',"%{$demande_id}%")
        ->select('reference_labo')
        ->where('echantillons.reference_labo','NOT LIKE',"%*")
        ->distinct()->get();
    $i=1;
    foreach ($heade as $k) {
        $data[0][$i]=$k->reference_labo;
        $i++;
    }
    //dd($heade);
        $this->SetFillColor(22, 105, 160);
        $this->SetFont('Times','B',12);
        $this->Cell(35,10,$data[0][0],1,0,'C',1);
        for ($f=$debut; $f <$largeur ; $f++) {
            $this->Cell(35,10,$data[0][$f],1,0,'C',1);
        }
        $this->Ln();
    }




}
