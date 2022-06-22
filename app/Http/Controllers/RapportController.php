<?php

namespace App\Http\Controllers;

use App\Exports\RappoortExport;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RapportController extends Controller
{
    protected $pdf;

    public function __construct(\App\Models\Pdf $pdf)
    {
        $this->pdf = $pdf;
    }

    public function createPdf($demande_id)
    {

        $demande=DB::table('demandes')->where('demande_id',$demande_id)->first();
        $this->pdf->AliasNbPages();
        $this->pdf->AddPage();
        //titre le rapport
        $this->pdf->SetFont('Arial','B',15);
        $this->pdf->Cell(0,0,"RAPPORT D'ANALYSE",0,1,'C');
        $this->pdf->SetFont('Arial','I',14);
        $this->pdf->Cell(0,12,"ANALYTICAL REPORT",0,1,'C');
        $this->pdf->Ln(10);
        //le cotenu du rapport
        $this->pdf->SetFont('Arial','B',12);
        $this->pdf->Cell(0,0,utf8_decode("N° du rapport :").$demande_id,0,1,'L');
        $this->pdf->Cell(0,0,"Commande/Contrat :",0,1,'C');
        $this->pdf->Cell(0,0,utf8_decode("Date d'édition: ").date('d/m/Y'),0,1,'R');
        //traduction en anglais
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial','I',10);
        $this->pdf->Cell(0,0,"Report number",0,1,'L');
        $this->pdf->Cell(0,0,utf8_decode("Order/Contract N° "),0,1,'C');
        $this->pdf->Cell(0,0,"Date of issue ",0,1,'R');

        //le premier sous titre
        $this->pdf->Ln(10);
        $this->pdf->SetFont('Arial','B',12);
        $this->pdf->Cell(0,5,"I - IDENTIFICATION DU CLIENT - CUSTOMER IDENTIFICATION",1,1);
        // contenu
        $this->pdf->Ln(7);
        $this->pdf->SetFont('Arial','B',12);
        $this->pdf->Cell(0,0,utf8_decode("Client/Société : ").$demande->society,0,1,'L');
        $this->pdf->Cell(0,0,"Interlocuteur :",0,1,'R');

        //traduction en anglais
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial','I',10);
        $this->pdf->Cell(0,0,"customer/company",0,1,'L');
        $this->pdf->Cell(0,0,"Interlocuteur ",0,1,'R');
            ///
        $this->pdf->Ln(7);
        $this->pdf->SetFont('Arial','B',12);
        $this->pdf->Cell(0,0,"Adresse Client :",0,1,'L');
        $this->pdf->Cell(0,0,utf8_decode("Prestation Demandée :"),0,1,'R');

        //traduction en anglais
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial','I',10);
        $this->pdf->Cell(0,0,"Customer Adress",0,1,'L');
        $this->pdf->Cell(0,0,"Service requested ",0,1,'R');

        //le premier sous titre
        $this->pdf->Ln(7);
        $this->pdf->SetFont('Arial','B',12);
        $this->pdf->Cell(0,5,"II - IDENTIFICATION DU MATERIAU ANALYSE - IDENTIFICATION THE MATERIAL ANALYZED",1,1);
        // contenu
        $this->pdf->Ln(7);
        $this->pdf->SetFont('Arial','B',12);
        $this->pdf->Cell(0,0,utf8_decode("Réference Client: "),0,1,'L');
        $this->pdf->Cell(0,0,"Nature de l'echantillon :".$demande->etat,0,1,'R');
        //traduction en anglais
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial','I',10);
        $this->pdf->Cell(0,0,"Client reference",0,1,'L');
        $this->pdf->Cell(0,0,"Nature of the sample ",0,1,'R');

        $this->pdf->Ln(7);
        $this->pdf->SetFont('Arial','B',12);
        $this->pdf->Cell(0,0,utf8_decode("Date de prélèvement: "),0,1,'L');
        $this->pdf->Cell(0,0,utf8_decode("Prélèvement effectué par :"),0,1,'R');
        //traduction en anglais
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial','I',10);
        $this->pdf->Cell(0,0,"Sampling date",0,1,'L');
        $this->pdf->Cell(0,0,"Sampled by ",0,1,'R');

        $this->pdf->Ln(7);
        $this->pdf->SetFont('Arial','B',12);
        $dat=explode(" ", $demande->created_at);
                            $datd=explode('-',$dat[0]);
        $this->pdf->Cell(0,0,utf8_decode("Date de réception :").$datd[2]."/".$datd[1]."/".$datd[0],0,1,'L');
        $this->pdf->Cell(0,0,utf8_decode("Numéro de réception :").$demande->demande_id,0,1,'R');
        //traduction en anglais
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial','I',10);
        $this->pdf->Cell(0,0,"Date of receipt",0,1,'L');
        $this->pdf->Cell(0,0,"Date of analysis",0,1,'R');

        $this->pdf->Ln(7);
        $this->pdf->SetFont('Arial','B',12);
        $this->pdf->Cell(0,0,utf8_decode("Observation sur l'état du matériau à la reception :"),0,1,'L');
        //traduction en anglais
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial','I',10);
        $this->pdf->Cell(0,0,"Observation of the condition of the material upon receipt",0,1,'L');
        $this->pdf->Line(5,192,205,192);


        $this->pdf->Ln(10);
        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->Cell(0,0,utf8_decode("* Prestation n'est pas couverte par l'accréditation "),0,0);
        $this->pdf->SetFont('Arial','I',9);
        $this->pdf->Cell(-125,0,"- Service not covered by accreditation ",0,1,"C");
        $this->pdf->Ln(5);

        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->Cell(0,0,"** Information fournis par le client  ",0,0);
        $this->pdf->SetFont('Arial','I',9);
        $this->pdf->Cell(-205,0,"- Information provided by the customer ",0,1,"C");
        $this->pdf->Ln(7);
        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->Cell(0,0,utf8_decode("-	 Conformité déclarée sans prise en compte de l'incertitude de mesure"),0,1);
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial','I',9);
        $this->pdf->Cell(0,0,"Conformity declared without taking into account the measurement uncertainty ",0,1,"L");


        $this->pdf->Ln(7);
        $this->pdf->SetFont('Arial','B',15);
        $this->pdf->Cell(0,0,"Avertissement ",0,0);
        $this->pdf->SetFont('Arial','I',12);
        $this->pdf->Cell(-280,0," - WARNING",0,1,"C");

        $this->pdf->Ln(7);
        $this->pdf->SetFont('Arial','B',7);
        $this->pdf->Cell(0,0,utf8_decode("Les résultats présentés dans ce rapport d'analyse ne concernent que les échantillons soumis aux analyses définies dans ce rapport"),0,1);
        $this->pdf->Ln(4);
        $this->pdf->SetFont('Arial','I',8);
        $this->pdf->Cell(0,0,"The results presented in this analysis report concern only the samples subjected to the analyzes defined in this report ",0,1,"L");
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial','B',7);
        $this->pdf->Cell(0,0,utf8_decode("La reproduction de ce rapport d’analyse ne peut être faite sans accord écrit de la direction générale d’AFRILAB"),0,1);
        $this->pdf->Ln(4);
        $this->pdf->SetFont('Arial','I',7);
        $this->pdf->Cell(0,0,"Reproduction of this analysis report may not be made without the written consent of the general management of AFRILAB",0,1,"L");
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial','B',8);
        $this->pdf->Cell(0,0,utf8_decode("AFRILAB Décline toute responsabilité quant aux informations fournis par le client "),0,1);
        $this->pdf->Ln(4);
        $this->pdf->SetFont('Arial','I',7);
        $this->pdf->Cell(0,0,"AFRILAB declines all responsibility for the information provided by the customer",0,1,"L");

        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial','B',8);
        $this->pdf->Cell(0,0, utf8_decode("Les résultats s'appliquent à l'échantillon tel qu'il a été reçu "),0,1);
        $this->pdf->Ln(4);
        $this->pdf->SetFont('Arial','I',7);
        $this->pdf->Cell(0,0,"Results apply to the sample as received ",0,1,"L");

        $this->pdf->SetFont('Arial','B',12);
        $this->pdf->Cell(0,0,"Directeur Technique du Laboratoire",0,1,'R');
        $this->pdf->SetFont('Arial','I',10);
        $this->pdf->Cell(0,6,"Technical Director of the Laboratory",0,1,'R');
        $this->pdf->SetFont('Arial','B',12);
        $this->pdf->Cell(0,8,"Redouane HARRARA",0,1,'R');

        //page 2


        $this->pdf->SetFont('Arial','B',12);
        $this->pdf->Cell(0,5,"III-	RESULTATS DES ANALYSES – RESULTS OF THE ANALYZES:",1,1);
        $this->pdf->Ln(7);
        $this->pdf->SetFont('Arial','B',12);
        $this->pdf->Cell(0,0,utf8_decode("Réception N° : ".$demande->demande_id),0,1,'L');
        $this->pdf->Cell(0,0,utf8_decode("Méthode utilisée :"),0,1,'R');
        //traduction en anglais
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial','I',10);
        $this->pdf->Cell(0,0,"Reception number ",0,1,'L');
        $this->pdf->Cell(0,0,"Used method ",0,1,'R');
        $this->pdf->Ln(10);



        // $this->pdf->HeadTable($demande_id);
        if ($demande->nombre_echantillons>5) {
            $this->pdf->dataHead(1,5,$demande_id);
            $this->pdf->dataIcp($demande_id,1,5);
        }
        else{
            $this->pdf->dataHead(1,$demande->nombre_echantillons+1,$demande_id);
            $this->pdf->dataIcp($demande_id,1,$demande->nombre_echantillons+1);
        }


        $this->pdf->Ln(8);


        $name='Rapport'.$demande_id."_".date('d-m-Y').'.pdf';
        $this->pdf->Output('I',$name,true);
            exit;
    }

    public function exportRapport($demande_id){

        $name='Rapport'.$demande_id."_".date('d-m-Y').'.xlsx';
        return Excel::download(new RappoortExport($demande_id),$name);
    }
}
