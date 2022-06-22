<link href="/bootstrap.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="{{url('css/baseAdmin.css')}}">

    <?php
        $path="/generationRapport".'/'.$demande_id;
    ?>

        <div class="container" page="A4" >
            <table width='100%'>
                <thead>
                    <tr>
                        <td><a href="{{$path}}" style="text-decoration: none" class="genere">
                            {{-- <img src="{{ asset('Images/logoAfri.png') }}" width="80%"> --}}
                            logo
                        </a></td>
                        <th> <h4>FORMULAIRE DE REALISATION</h4>
                            <span >RAPPORT D'ANALYSE - ANALYTICAL REPORT</span>
                        </th>
                        <td>
                            logo
                            {{-- <img src="{{ asset('Images/sgs.jpeg') }}" width="40%"> --}}
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3">
                            <h4 style="text-align:center">RAPPORT D'ANALYSE</h4>
                           <em>ANALYTICAL REPORT</em>
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <div >N<sup>0</sup> du rapport :</div >
                            <em>Report number</em>
                        </td>
                        <td>
                            <div >Commande/Contrat : {{$demande->demande_id}}</div >
                            <em>Order/Contract N<sup>0</sup></em>
                        </td>
                        <td>
                            <?php
                                $date = new DateTime();
                                $date->format('d-m-Y');
                            ?>
                            <div >Date d'édition: {{$date->format('d/m/Y')}}</div >
                            <em>Date of issue</em>
                        </td>

                    </tr>
                </tbody>
            </table>
            <table width='100%'>
                <tr>
                    <td colspan="2" >
                        <div class="ssTitle"> I - IDENTIFICATION DU CLIENT - <em>CUSTOMER IDENTIFICATION</em></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div >Client/Société : {{$demande->society}}</div >
                        <em>customer/company</em>
                    </td>
                    <td>
                        <div >Interlocuteur :</div >
                        <em>Interlocuteur</em>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div >Adresse Client :</div >
                        <em>Customer Adress</em>
                    </td>
                    <td>
                        <div >Adresse Client :</div >
                        <em>Customer Adress</em>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" >
                        <div class="ssTitle"> II - IDENTIFICATION DU MATERIAU ANALYSE - <em>IDENTIFICATION THE MATERIAL ANALYZED</em></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div >Réference Client </div >
                           <em>Client reference</em>
                    </td>
                    <td>
                        <div >Nature de l'echantillon : {{$demande->etat}}</div >
                        <em>Nature of the sample</em>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div >Date de prélèvement</div >
                           <em>Sampling date </em>
                    </td>
                    <td>
                        <div >Prélèvement effectué par :</div >
                           <em>Sampled by</em>
                    </td>
                </tr>
                <tr>
                    <?php

                        $dat=explode(" ", $demande->created_at);
                        $datd=explode('-',$dat[0])
                        ?>
                    <td>
                        <div >Date de réception : {{ $datd[2]}}/{{$datd[1]}}/{{$datd[0]}}</div >
                           <em>Date of receipt</em>
                    </td>

                    <td>
                        <div >Numéro de réception :{{$demande->demande_id}}</div >
                        <em>Date of analysis</em>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <em>Observation of the condition of the material upon receipt</em>
                        <div >Observation sur l'état du matériau à la reception :{{$demande->observation}}</div >
                    </td>
                </tr>
            </table>
           <hr>
           <div class="row">

                   <div >* Prestation n'est pa couvert par l'accréditation </div >
                   <em>- Service not covered by accreditation</em>


                    <div > ** Information fournis par le Client</div >
                    <em>- Information provided by the customer</em>


                <div class="col-md-12">
                  <div >- Conformité déclarée sans prise en compte de l'incertitude de mesure</div >
                   <em>Conformity declared without taking into account the measurement uncertainty</em>
                </div>


           </div>
           <div class="row mt-3">
               <span class="avert">Avertissement -<em> WARNINGS</em> </span>
               <ul>
                   <li><div >Les résultats présentés dans ce rapport d'analyse ne concernent que les échantillons soumis aux analyses definis dans ce rapport</div >
                        <em>The results presented in this analysis report concern only the samples emjected to the analyzes defined in this report</em>
                    </li>
                    <li>
                        <div >La reproduction de ce rapport d’analyse ne peut être faite sans accord écrit de la direction générale d’AFRILAB</div >
                        <em>Reproduction of this analysis report may not be made without the written consent of the general management of AFRILAB</em>
                    </li>
                    <li>
                        <div >AFRILAB Décline toute responsabilité quant aux informations fournis par le client</div >
                        <em>AFRILAB declines all responsibility for the information provided by the customer</em>
                    </li>
                    <li>
                        <div >Les résultats s’appliquent à l’échantillon tel qu’il a été reçu</div >
                        <em>Results apply to the sample as received</em>
                    </li>
               </ul>
           </div>
           <div class="row">
               <div class="col-md-7"></div>
               <div class="col-md-5" style="text-align: center;">
                   <div >Directeur Technique du Laboratoire</div >
                   <div>Redouane HARRARA</div>
               </div>
           </div>
           <hr>
            <p style="text-align: center;">Adresse : N°344 zone industrielle Sidi Ghanem (près de la poste) - Marrakech- BP : 40 000-Maroc/ Mobile: (+212) 6 61 60 15 15 Fixe/Fax: (+212) 5 24 35 81 81
                ICE: 001627543000055- Patente: 64094960- IF: 18777160- RC: 74473-CNSS: 4887058
            </p>
        <div  class="echantillon mt-5">
            <table width='100%'>
                <thead>
                    <tr>
                        <td>Logo</td>
                        <th> <h3>FORMULAIRE DE REALISATION</h3>
                            <em >RAPPORT D'ANALYSE - ANALYTICAL REPORT</em>
                        </th>
                        <td>
                            logo
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2" >
                            <div class="ssTitle"> III - IDENTIFICATION DU CLIENT - <em>CUSTOMER IDENTIFICATION</em></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div >Numéro de Réception:</div >
                               <em>Reception number</em>
                        </td>
                        <td>
                            <div >Méthode utilisée:</div >
                            <em>Used method</em>
                        </td>
                    </tr>
                    @forelse($echantillons as $chantillon)
                        <tr>
                            <td>{{$chantillon->reference_labo}}</td>
                        </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


        <style>
            .container{
                margin: 0%;
                font-family: Arial, Helvetica, sans-serif
            }

         thead{
             border-bottom: 2px solid #034a78;
             border-top: 2px solid #034a78;
             font-weight: bold;
             font-family: sans-serif;

         }
         em{
            font-size: 15px;
            color: gray
         }
         .ssTitle{
            border:2px solid #034a78;
            margin-bottom: 1%
         }
         div {
             font-size: 16px;
             margin-bottom: -1%;
         }
         h4{
             font-size: 18px;
         }
         td{
             color: black;
             text-align: center;
         }
         th{
            text-align: center;
            color: #034a78
         }
         .echantillon{
             margin-top: 1%
         }
        </style>

