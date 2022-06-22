<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
@extends('baseLabo')
    @section('titleHead')
        AfriLab|Laboratoire Absorption
    @endsection
    @section('titlePage')

       <a class="navbar-brand" style='color:black !important;' href="#">Laboratoire Absorption</a>
    @endsection
    @section('barreRecherche')
    <a href="/laboratoire/readFile">
        <button class="btn btn-outline-success">
            Chargement <i class="bi bi-file-earmark-plus"></i>
        </button>
    </a>

    @endsection
    @section('content')
    <?php if (count($demandes)==0) {
        echo "aucun echantillon pour le moment";
    }
    else{
        ?>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Numéro de Demade </th>
                    <th scope="col">Client</th>
                    <th scope="col">Nombre d'echatiollons</th>
                    <th scope="col">Date de Réception</th>
                    <th style="background:none"></th>
                    <th style="background:none"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nb=1;
                        foreach ($demandes as $demande) {
                            $demandePath="/Labortoire/Absorption/details/demande/".$demande->demande_id;
                            $demandeEnvoie="/Labortoire/Absorption/envoie/demande/".$demande->demande_id;
                            ?>
                            <tr class="line" href="1">
                                    <td>{{$demande->demande_id}}</td>
                                    <td>{{$demande->demandeur}}</td>
                                    <td>{{$demande->nombre_echantillons}}</td>
                                    <?php

                                        $dat=explode(" ", $demande->created_at);
                                        $datd=explode('-',$dat[0])
                                    ?>
                                    <td>{{ $datd[2]}}/{{$datd[1]}}/{{$datd[0]}}</td>
                                    <td class="detaille">
                                        <a href="{{url($demandePath)}}" class="link">
                                            <button class="btn btn-outline-success">Resultat</button>

                                        </a>
                                    </td>
                                    <td class="detaille">
                                        <a href="{{url($demandeEnvoie)}}" class="link">
                                            <button class="btn btn-outline-success">Envoyer</button>

                                        </a>
                                    </td>
                            </tr>

                        <?php
                        $nb++;
                        }

                        ?>

                </tbody>
            </table>
     <?php } ?>
    @endsection
