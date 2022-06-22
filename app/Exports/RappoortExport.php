<?php

namespace App\Exports;

use App\Models\demandes;
use App\Models\employes;
use App\Models\echantillons;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ToArray;

class RappoortExport implements FromArray ,WithHeadings
{

    /**
    * @return \Illuminate\Support\Collection
    */
    function __construct($demande_id )
    {
        $this->demande_id=$demande_id;
       // $this->data=$data;
    }
    public function array() :array
    {
        $data=[];

        //humoidites
        $i=1;
        $humd=DB::table('humidites')->where('reference_labo','LIKE',"R/{$this->demande_id}%")->first();
        if(!empty($humd)){
            $data['humidite'][0]='H2O (%)';
            $humidites=DB::table('humidites')->where('reference_labo','LIKE',"R/{$this->demande_id}%")
            ->select([
                'reference_labo',
                'poids_tar',
                'poids_humid',
                'poids_seche',
            ])->get();

            //humidite
            foreach ($humidites as $db) {
                $p=$db->poids_seche - $db->poids_tar;
                $data['humidite'][$i]=round((($db->poids_humid-$p)/$db->poids_humid)*100,2);
                $i++;
            }

        }
            $k=1;
            //densites
            $den=DB::table('densites')->where('reference_labo','LIKE',"R/{$this->demande_id}%")->first();
            if(!empty($den)){
                $data['densite'][0]='densité (%)';
                $densi=DB::table('densites')->where('reference_labo','LIKE',"%{$this->demande_id}%")->get();
                $i=1;
                foreach ($densi as $d) {
                    $data['densite'][$k]=round(($d->masse/($d->vol_v1-$d->vol_initial)),3);
                    $k++;
                }
            }


            //perte feu

            $f=1;
            $pfs=DB::table('pertefeus')->where('reference_labo','LIKE',"R/{$this->demande_id}%")->get();
            $pf=DB::table('pertefeus')->where('reference_labo','LIKE',"R/{$this->demande_id}%")->first();
            if(!empty($pf)){
                $data['pertefeu'][0]='PF (%)';
                foreach ($pfs as $e) {
                    $m=$e->masse_2h - $e->masse_creuse;
                    $data['pertefeu'][$f]=round((($e->masse_initiale-$m)/$e->masse_initiale)*100,3);
                    $f++;
                }
            }
                    //aa
           //la liste des elements]

        $Ag =DB::table('echantillons')
            ->join('aas', 'echantillons.reference_labo', 'like', 'aas.reference_labo')
            ->select('aas.*', 'echantillons.masse_pc', 'echantillons.vol_pc', 'echantillons.vid', 'echantillons.pd')
            ->where('demande_id',$this->demande_id)->where('code_element',8)
            ->get();

        $Cu =DB::table('echantillons')
                ->join('aas', 'echantillons.reference_labo', 'like', 'aas.reference_labo')
                ->select('aas.*', 'echantillons.masse_pc', 'echantillons.vol_pc', 'echantillons.vid', 'echantillons.pd')
                ->where('demande_id',$this->demande_id)->where('code_element',9)
                ->get();

        $Pb =DB::table('echantillons')
                ->join('aas', 'echantillons.reference_labo', 'like', 'aas.reference_labo')
                ->select('aas.*', 'echantillons.masse_pc', 'echantillons.vol_pc', 'echantillons.vid', 'echantillons.pd')
                ->where('demande_id',$this->demande_id)->where('code_element',10)
                ->get();

        $Zn =DB::table('echantillons')
                ->join('aas', 'echantillons.reference_labo', 'like', 'aas.reference_labo')
                ->select('aas.*', 'echantillons.masse_pc', 'echantillons.vol_pc', 'echantillons.vid', 'echantillons.pd')
                ->where('demande_id',$this->demande_id)->where('code_element',11)
                ->get();

        $Mn =DB::table('echantillons')
                ->join('aas', 'echantillons.reference_labo', 'like', 'aas.reference_labo')
                ->select('aas.*', 'echantillons.masse_pc', 'echantillons.vol_pc', 'echantillons.vid', 'echantillons.pd')
                ->where('demande_id',$this->demande_id)->where('code_element',12)
                ->get();

        $Co =DB::table('echantillons')
                ->join('aas', 'echantillons.reference_labo', 'like', 'aas.reference_labo')
                ->select('aas.*', 'echantillons.masse_pc', 'echantillons.vol_pc', 'echantillons.vid', 'echantillons.pd')
                ->where('demande_id',$this->demande_id)->where('code_element',13)
                ->get();

        $Ni =DB::table('echantillons')
                ->join('aas', 'echantillons.reference_labo', 'like', 'aas.reference_labo')
                ->select('aas.*', 'echantillons.masse_pc', 'echantillons.vol_pc', 'echantillons.vid', 'echantillons.pd')
                ->where('demande_id',$this->demande_id)->where('code_element',14)
                ->get();

        $Fe =DB::table('echantillons')
                ->join('aas', 'echantillons.reference_labo', 'like', 'aas.reference_labo')
                ->select('aas.*', 'echantillons.masse_pc', 'echantillons.vol_pc', 'echantillons.vid', 'echantillons.pd')
                ->where('demande_id',$this->demande_id)->where('code_element',15)
                ->get();


        $temoin=DB::table('temoin_a_a_s')->where('demande_id',$this->demande_id)->first();
        if (!count($Ag)==0 && !empty($temoin)) {
            $agi=1;
            $data['Ag'][0]='Ag (%)';
            foreach ($Ag as $ea) {
                $teneurCalculer=(((float)$temoin->lecture*(float)$temoin->volume)/((float)$temoin->masse*(float)$ea->vid))/(float)$ea->pd;
                $coefficient=((float)$teneurCalculer)/(float)$temoin->teneur_certif;
                $teneur=(((float)$ea->lecture*(float)$ea->vol_pc)/((float)$ea->masse_pc*(float)$ea->vid))/(float)$ea->pd;
                $correcteur=$coefficient*$teneur;
                $data['Ag'][$agi]=round($teneur,3);
                $agi++;
            }
        }

        if (!count($Cu)==0 && !empty($temoin)) {
            $cui=1;
            $data['Cu'][0]='Cu (%)';
            foreach ($Ag as $ea) {
                $teneurCalculer=(((float)$temoin->lecture*(float)$temoin->volume)/((float)$temoin->masse*(float)$ea->vid))/(float)$ea->pd;
                $coefficient=((float)$teneurCalculer)/(float)$temoin->teneur_certif;
                $teneur=(((float)$ea->lecture*(float)$ea->vol_pc)/((float)$ea->masse_pc*(float)$ea->vid))/(float)$ea->pd;
                $correcteur=$coefficient*$teneur;
                $data['Cu'][$cui]=round($teneur,3);
                $cui++;
            }
        }

        if (!count($Pb)==0 && !empty($temoin)) {
            $pbi=1;
            $data['Pb'][0]='Pb (%)';
            foreach ($Pb as $ea) {
                $teneurCalculer=(((float)$temoin->lecture*(float)$temoin->volume)/((float)$temoin->masse*(float)$ea->vid))/(float)$ea->pd;
                $coefficient=((float)$teneurCalculer)/(float)$temoin->teneur_certif;
                $teneur=(((float)$ea->lecture*(float)$ea->vol_pc)/((float)$ea->masse_pc*(float)$ea->vid))/(float)$ea->pd;
                $correcteur=$coefficient*$teneur;
                $data['Pb'][$pbi]=round($teneur,3);
                $pbi++;
            }
        }

        if (!count($Zn)==0 && !empty($temoin)) {
            $zni=1;
            $data['Zn'][0]='Zn (%)';
            foreach ($Zn as $ea) {
                $teneurCalculer=(((float)$temoin->lecture*(float)$temoin->volume)/((float)$temoin->masse*(float)$ea->vid))/(float)$ea->pd;
                $coefficient=((float)$teneurCalculer)/(float)$temoin->teneur_certif;
                $teneur=(((float)$ea->lecture*(float)$ea->vol_pc)/((float)$ea->masse_pc*(float)$ea->vid))/(float)$ea->pd;
                $correcteur=$coefficient*$teneur;
                $data['Zn'][$zni]=round($teneur,3);
                $zni++;
            }
        }

        if (!count($Mn)==0 && !empty($temoin)) {
            $mni=1;
            $data['Mn'][0]='Mn (%)';
            foreach ($Mn as $ea) {
                $teneurCalculer=(((float)$temoin->lecture*(float)$temoin->volume)/((float)$temoin->masse*(float)$ea->vid))/(float)$ea->pd;
                $coefficient=((float)$teneurCalculer)/(float)$temoin->teneur_certif;
                $teneur=(((float)$ea->lecture*(float)$ea->vol_pc)/((float)$ea->masse_pc*(float)$ea->vid))/(float)$ea->pd;
                $correcteur=$coefficient*$teneur;
                $data['Mn'][$mni]=round($teneur,3);
                $mni++;
            }
        }

        if (!count($Co)==0 && !empty($temoin)) {
            $coi=1;
            $data['Co'][0]='Co (%)';
            foreach ($Co as $ea) {
                $teneurCalculer=(((float)$temoin->lecture*(float)$temoin->volume)/((float)$temoin->masse*(float)$ea->vid))/(float)$ea->pd;
                $coefficient=((float)$teneurCalculer)/(float)$temoin->teneur_certif;
                $teneur=(((float)$ea->lecture*(float)$ea->vol_pc)/((float)$ea->masse_pc*(float)$ea->vid))/(float)$ea->pd;
                $correcteur=$coefficient*$teneur;
                $data['Co'][$coi]=round($teneur,3);
                $coi++;
            }
        }

        if (!count($Ni)==0 && !empty($temoin)) {
            $nii=1;
            $data['Ni'][0]='Ni (%)';
            foreach ($Ni as $ea) {
                $teneurCalculer=(((float)$temoin->lecture*(float)$temoin->volume)/((float)$temoin->masse*(float)$ea->vid))/(float)$ea->pd;
                $coefficient=((float)$teneurCalculer)/(float)$temoin->teneur_certif;
                $teneur=(((float)$ea->lecture*(float)$ea->vol_pc)/((float)$ea->masse_pc*(float)$ea->vid))/(float)$ea->pd;
                $correcteur=$coefficient*$teneur;
                $data['Ni'][$nii]=round($teneur,3);
                $nii++;
            }
        }

        if (!count($Fe)==0 && !empty($temoin)) {
            $fei=1;
            $data['Fe'][0]='Fe (%)';
            foreach ($Fe as $ea) {
                $teneurCalculer=(((float)$temoin->lecture*(float)$temoin->volume)/((float)$temoin->masse*(float)$ea->vid))/(float)$ea->pd;
                $coefficient=((float)$teneurCalculer)/(float)$temoin->teneur_certif;
                $teneur=(((float)$ea->lecture*(float)$ea->vol_pc)/((float)$ea->masse_pc*(float)$ea->vid))/(float)$ea->pd;
                $correcteur=$coefficient*$teneur;
                $data['Fe'][$fei]=round($teneur,3);
                $fei++;
            }
        }



        //volumetries
        $echantillonsVols = DB::table('echantillons')->where('demande_id',$this->demande_id)
            ->join('volumetries', 'echantillons.reference_labo', 'like', 'volumetries.reference_labo')
            ->select('volumetries.vol_edta', 'echantillons.masse_pc', 'echantillons.reference_labo')
            -> get();
            $temoin=DB::table('temoin_volums')->where('demande_id',$this->demande_id)->first();
            $sd1=DB::table('sampleds')->where('demande_id',$this->demande_id)->where('nom','sd1')->first();
            $sd2=DB::table('sampleds')->where('demande_id',$this->demande_id)->where('nom','sd2')->first();
        if (!count($echantillonsVols)==0 && !empty($sd1) && !empty($sd2)) {
            $const1=((float)$sd1->masse/(float)$sd1->volume)*100;
            $const2=((float)$sd2->masse/(float)$sd2->volume)*100;
            $sd1=$const1*((float)$temoin->volume/(float)$temoin->masse);
            $sd2=$const2*((float)$temoin->volume/(float)$temoin->masse);
                        $fei=1;
            $data['Correction'][0]='Correction';
            foreach ($echantillonsVols as $echantillonsVol) {
                $correction=((float)$temoin->valeur/(((float)$sd1+(float)$sd2)/2))*((float)$echantillonsVol->vol_edta/(float)$echantillonsVol->masse_pc);
                $data['Correction'][$fei]=round($correction,3);
                $fei++;
            }
        }

// ---------------------------------------
    $data[0][0]="Ref_lab";
    $data_ppm=[];
    $heade=DB::table('analyse_icps')->where('reference_labo','LIKE',"%{$this->demande_id}%")->select('reference_labo')->distinct()->get();

    $i=1;
    foreach ($heade as $k) {
        $data[0][$i]=$k->reference_labo;
        $i++;
    }

    $c=1;
    $l=1;
    $echantillon_p=DB::table('analyse_icps')->where('reference_labo','LIKE',"%{$this->demande_id}%")
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

    $echantillon_ppm=DB::table('analyse_icps')->where('reference_labo','LIKE',"%{$this->demande_id}%")
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
        }
        $l++;
    }
    //dd($data+$data_ppm);
    $dataAll=$data+$data_ppm;
    

// -----------------------------------

        if (count($dataAll)!=0) {
            return $dataAll ;

        }
        else dd("Aucune information trouvéé ...");



    }

    public function headings(): array
    {
        $header[0]='Ref_lab';
        $h=DB::table('echantillons')->where('demande_id',$this->demande_id)->select('reference_labo')->get();
        //dd($h);
        $i=1;
        foreach ($h as $he) {
            $header[$i]=$he->reference_labo;
            $i++;
        }

        return $header;
    }
    // public function map($row): array
    // {
    //     return[
    //         $row->designation,
    //         $row->reference_labo,
    //         $row->masse_pc>10? 20:'-10',
    //         $row->vol_pc<20 ? 20:$this->demande_id,

    //     ];
    // }
}
