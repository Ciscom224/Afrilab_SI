<?php

namespace App\Imports;



use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToArray;
use Illuminate\Support\Facades\DB;
class ipcFile implements ToArray
{

    use Importable;
    public function array(array $data)
    {
        $resultat=[];

        $ligne=count($data);
        $l=0;
        $k=0;
       for ($i=1; $i <$ligne ; $i++) {
           $c=count($data[$i]);
           $name=explode(' ',$data[$i][0]);
           $k=0;
           for ($j=4; $j < $c; $j++) {
               $ref=$data[0][$j];

               if(strpos($data[$i][0] , '%')){
                    $resultat[$l][$k]["Reference"]=$data[0][$j];
                    $resultat[$l][$k]["value"]=(($data[$i][1]/10000)/$data[$i][1])*$data[$i][$j];
                    $resultat[$l][$k]["element"]=$name[0]."(".$name[count($name)-1].")";
                }
               else{
                    $resultat[$l][$k]["element"]=$name[0]."(".$name[count($name)-1].")";
                    $resultat[$l][$k]["Reference"]=$data[0][$j];
                    $resultat[$l][$k]["value"]=($data[$i][2]/$data[$i][1])*$data[$i][$j];

               }
               $k++;
           }
           $l++;
       }
       $cr=$k;
       $lg=$l;
       for ($i=0; $i <$lg; $i++) {
           for ($j=0; $j <$cr ; $j++) {
               echo "j= ".$j."   ";
                if(strpos($resultat[$i][$j]["element"],'Al2O3') &&  $resultat[$i][$j]["value"] < 0.01){
                    $resultat[$i][$j]["value"] = '< 0.1';
                }elseif(strpos($resultat[$i][$j]["element"],'SiO2')   && (float) $resultat[$i][$j]["value"] < 0.1){
                    $resultat[$i][$j]["value"] = '< 0.1';
                }elseif(strpos($resultat[$i][$j]["element"],'CaO') && (float) $resultat[$i][$j]["value"] < 0.01){
                    $resultat[$i][$j]["value"] = '< 0.1';
                }elseif(strpos($resultat[$i][$j]["element"],'Fe2O3') &&(float) $resultat[$i][$j]["value"] < 0.01){
                    $resultat[$i][$j]["value"] = '< 0.1';
                }elseif(strpos($resultat[$i][$j]["element"],'K2O') &&(float) $resultat[$i][$j]["value"] < 0.01){
                    $resultat[$i][$j] = '< 0.1';
                }elseif(strpos($resultat[$i][$j]["element"],'MgO') &&(float) $resultat[$i][$j]["value"] < 0.01){
                    $resultat[$i][$j]["value"] = '< 0.01';
                }elseif(strpos($resultat[$i][$j]["element"],'MnO') &&(float) $resultat[$i][$j]["value"] < 0.01){
                    $resultat[$i][$j]["value"] = '< 0.01';
                }elseif(strpos($resultat[$i][$j]["element"] ,'P2O5') &&(float) $resultat[$i][$j]["value"] < 0.01){
                    $resultat[$i][$j]["value"] = '< 0.1';
                }elseif(strpos($resultat[$i][$j]["element"],'TiO2') &&(float) $resultat[$i][$j]["value"] < 0.001){
                $resultat[$i][$j]["value"] = '< 0.001';
              }elseif(strpos($resultat[$i][$j]["element"],'As')  && (float) $resultat[$i][$j]["value"] < 8){
                $resultat[$i][$j]["value"] = '< 8';
              }elseif(strpos($resultat[$i][$j]["element"],'B') &&(float) $resultat[$i][$j]["value"] < 5){
                $resultat[$i][$j]["value"] = '< 5';
              }elseif(strpos($resultat[$i][$j]["element"],'Ba') &&(float) $resultat[$i][$j]["value"] < 2){
                $resultat[$i][$j]["value"] = '< 2';
              }elseif(strpos($resultat[$i][$j]["element"],'Be') &&(float) $resultat[$i][$j]["value"] < 1){
                $resultat[$i][$j]["value"] = '< 1';
              }elseif(strpos($resultat[$i][$j]["element"],'Bi') &&(float) $resultat[$i][$j]["value"] < 10){
                $resultat[$i][$j]["value"] = '< 10';
              }elseif(strpos($resultat[$i][$j]["element"],'Cd') &&(float) $resultat[$i][$j]["value"] < 1){
                $resultat[$i][$j]["value"] = '< 1';
              }elseif(strpos($resultat[$i][$j]["element"],'Co') &&(float) $resultat[$i][$j]["value"] < 5){
                $resultat[$i][$j]["value"] = '< 5';
              }elseif(strpos($resultat[$i][$j]["element"],'Cr') &&(float) $resultat[$i][$j]["value"] < 5){
                $resultat[$i][$j]["value"] = '< 5';
              }elseif(strpos($resultat[$i][$j]["element"],'Cu') &&(float) $resultat[$i][$j]["value"] < 2){
                $resultat[$i][$j]["value"] = '< 2';
              }elseif(strpos($resultat[$i][$j]["element"],'Ge') &&(float) $resultat[$i][$j]["value"] < 10){
                $resultat[$i][$j] = '< 10';
              }elseif(strpos($resultat[$i][$j]["element"],'Li') &&(float) $resultat[$i][$j]["value"] < 20){
                $resultat[$i][$j]["value"] = '< 20';
              }elseif(strpos($resultat[$i][$j]["element"],'Mo') &&(float) $resultat[$i][$j]["value"] < 10){
                $resultat[$i][$j]["value"] = '< 10';
              }elseif(strpos($resultat[$i][$j]["element"],'Nb') &&(float) $resultat[$i][$j]["value"] < 1){
                $resultat[$i][$j]["value"] = '< 1';
              }elseif(strpos($resultat[$i][$j]["element"],'Ni')  && (float) $resultat[$i][$j]["value"] < 20){
                $resultat[$i][$j]["value"] = '< 20';
              }elseif(strpos($resultat[$i][$j]["element"],'Pb') &&(float) $resultat[$i][$j]["value"] < 26){
                $resultat[$i][$j]["value"] = '< 26';
              }elseif(strpos($resultat[$i][$j]["element"],'Sb') &&(float) $resultat[$i][$j]["value"] < 1){
                $resultat[$i][$j]["value"] = '< 1';
              }elseif(strpos($resultat[$i][$j]["element"],'Se') &&(float) $resultat[$i][$j]["value"] < 30){
                $resultat[$i][$j]["value"] = '< 30';
              }elseif(strpos($resultat[$i][$j]["element"],'Sn') &&(float) $resultat[$i][$j]["value"] < 20){
                $resultat[$i][$j]["value"] = '< 20';
              }elseif(strpos($resultat[$i][$j]["element"],'Sr') &&(float) $resultat[$i][$j]["value"] < 2){
                $resultat[$i][$j]["value"] = '< 2';
              }elseif(strpos($resultat[$i][$j]["element"],'W') &&(float) $resultat[$i][$j]["value"] < 30){
                $resultat[$i][$j]["value"] = '< 30';
              }elseif(strpos($resultat[$i][$j]["element"],'y') &&(float) $resultat[$i][$j]["value"] < 2){
                $resultat[$i][$j] = '< 2';
              }elseif(strpos($resultat[$i][$j]["element"],'Zn') &&(float) $resultat[$i][$j]["value"] < 2){
                $resultat[$i][$j]["value"] = '< 2';
              }elseif(strpos($resultat[$i][$j]["element"],'Ti') &&(float) $resultat[$i][$j]["value"] < 2){
                $resultat[$i][$j]["value"] = '< 0.01';
              }elseif(strpos($resultat[$i][$j]["element"],'Tl') &&(float) $resultat[$i][$j]["value"] < 2){
                $resultat[$i][$j] = '< 1';
              }elseif(strpos($resultat[$i][$j]["element"],'Ta') &&(float) $resultat[$i][$j]["value"] < 2){
                $resultat[$i][$j] = '< 1';
              }elseif(strpos($resultat[$i][$j]["element"],'V') &&(float) $resultat[$i][$j]["value"] < 2){
                $resultat[$i][$j]["value"] = '< 1';
              }elseif(strpos($resultat[$i][$j]["element"],'S') && (float) $resultat[$i][$j]["value"] < 0.01){
                $resultat[$i][$j]["value"] = '< 0.01';
              }
              elseif(strpos($resultat[$i][$j]["element"],'Y') && (float) $resultat[$i][$j]["value"] < 30){
                $resultat[$i][$j]["value"] = '< 30';
              }
              elseif(strpos($resultat[$i][$j]["element"],'Hg') && (float) $resultat[$i][$j]["value"] < 10){
                $resultat[$i][$j]["value"] = '< 10';
              }
              elseif(strpos($resultat[$i][$j]["element"],'Zr') && (float) $resultat[$i][$j]["value"] <1){
                $resultat[$i][$j]["value"] = '< 1';
              }
              elseif(strpos($resultat[$i][$j]["element"],'Ta') && (float) $resultat[$i][$j]["value"] < 1){
                $resultat[$i][$j]["value"] = '< 1';
              }
              else $resultat[$i][$j]["value"]=round($resultat[$i][$j]["value"],3);
               DB::table('analyse_icps')->updateOrInsert(
                   [
                        'reference_labo'=>$resultat[$i][$j]["Reference"],
                        'element'=>$resultat[$i][$j]["element"]
                   ]
                   ,
                   [
                        'result'=>$resultat[$i][$j]["value"] ,
                   ]
               );
           }
       }

    }

}
