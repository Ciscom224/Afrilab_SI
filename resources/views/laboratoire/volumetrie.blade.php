@extends('baseLabo')
    @section('titleHead')
        AfriLab|Laboratoire Volumetrie
    @endsection
    @section('titlePage')

       <a class="navbar-brand" style='color:black !important;' href="#">Laboratoire Volumetrie</a>
    @endsection
    @section('barreRecherche')
        <form class="form-inline my-2 my-lg-0" method="get"  action="/Preparation/Volumetrie/Registre/">
            @csrf
            <input class="form-control mr-sm-2" type="number" placeholder="Search" name="demande_id" aria-label="Search" required>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Recherche</button>
        </form>
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
                        <th scope="col">Demade </th>
                        <th scope="col">Client</th>
                        <th scope="col">Nombre d'echatiollons</th>
                        <th scope="col">Réception</th>
                        <th style="background:none"></th>
                        <th style="background:none"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                        foreach ($demandes as $demande) {
                            $demandePath="/Labortoire/Volumetrie/detatils/demande/".$demande->demande_id;
                            $demandeEnvoie="/Labortoire/Volumetrie/demande/envoie/".$demande->demande_id;
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
                                <td>
                                    <a href="{{url($demandePath)}}" style="text-decoration: none">
                                        <button class="btn btn-outline-success">Saisir</button>
                                    </a>
                                </td>
                                <td ><a href="{{url($demandeEnvoie)}}" class="link" style="text-decoration: none"><button class="btn btn-outline-success">Envoyer</button> </a></td>

                            </tr>

                        <?php

                        }

                        ?>

                </tbody>
            </table>
     <?php } ?>
    @endsection
