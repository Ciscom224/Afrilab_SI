<link rel="stylesheet" href="{{asset('css/preparation/preparationPC.css')}}">
@extends('baseLabo')
    @section('titleHead')
        AfriLab|Salle de Préparation Chimique
    @endsection
    @section('titlePage')

       <a class="navbar-brand" style='color:black !important;' href="#">Préparation Chimique</a>
    @endsection
    @section('barreRecherche')
        <form class="form-inline my-2 my-lg-0" method="post"  action="/Préparation/Chimique/demande/edit">
        @csrf
        <input class="form-control mr-sm-2" type="text" placeholder="Search" name="demande_id" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Recherche</button>
        </form>
    @endsection

    @section('content')
    <?php if (count($demandes)==0) {
        echo "aucun echantillon pour le moment";
    }
    else{
        ?>
     <div class=" row">
        <div class="col-md-9">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Demade </th>
                    <th scope="col">Client</th>
                    <th scope="col">Nombre d'echatiollons</th>
                    <th scope="col">Réception</th>
                    <th style="background:none"></th>
                    <th style="background:none"></th>
                    <th style="background:none"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($demandes as $demande)
                        <?php
                            $demandePath="/Préparation/Chimique/detatils/demande/".$demande->demande_id;
                            $demandePathEnvoi="/Préparation/Chimique/demande/envoyer/".$demande->demande_id;
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
                                        <button class="btn btn-outline-success">Remplir</button>
                                    </a>
                                </td>
                                <td ><a href="{{url($demandePathEnvoi)}}" class="link" style="text-decoration: none"><button class="btn btn-outline-success">Envoyer</button> </a></td>
                        </tr>

                    @empty
                        <tr>
                            <th>
                                pas de dmandes pour l'instant
                            </th>
                        </tr>
                    @endforelse
                </tbody>
            </table>

                    {{$demandes->links()}}

                    <?php } ?>
        </div>
            <div class="col-md-3 btns">
                <a href="/Préparation/Chimique/Registre/humidite" class='link'><button type="button" style="opacity:1 " class="btn btn-registre btn-lg btn-block">Registre Humidité </button></a>
                <a href="/Préparation/Chimique/Registre/densite" ><button type="button" class="btn btn-registre btn-lg btn-block">Registre de Densité </button></a>
                <a href="/Préparation/Chimique/Registre/pertefeu" > <button type="button" class="btn btn-registre btn-lg btn-block ">Registre Perte Feu </button></a>
            </div>
     </div>



    @endsection

