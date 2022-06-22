@extends('preparation.registreBase')
    @section('titleHead')
        AfriLab|Salle de Préparation Chimique
    @endsection
    @section('titlePage')

       <a class="navbar-brand" href="{{route('homePagePC')}}">Préparation Chimique</a>
    @endsection
    @section('registreName')
        Registre Humidité
    @endsection
    @section('affichage')
        <li class="nav-item">
            <a href="/registreHumiditeAll"><button class="btn ">Afficher</button></a>
        </li>
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
                    <th scope="col"></th>
                    <th scope="col">Numéro de Demade </th>
                    <th scope="col">Client</th>
                    <th scope="col">Nombre d'echatiollons</th>
                    <th scope="col">Date de Réception</th>
                    <th style="background:none"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nb=1;
                        foreach ($demandes as $demande) {
                            $demandePath="/registreHumidite"."/".$demande->demande_id;
                            ?>
                            <tr class="line" href="1">
                                    <th scope="row">{{$nb}}</th>
                                    <td>{{$demande->demande_id}}</td>
                                    <td>{{$demande->demandeur}}</td>
                                    <td>{{$demande->nombre_echantillons}}</td>
                                        <?php
                                            $dat=explode(" ", $demande->created_at);
                                            $datd=explode('-',$dat[0])
                                        ?>
                                    <td>{{ $datd[2]}}/{{$datd[1]}}/{{$datd[0]}}</td>
                                    <td>
                                        <a href="{{url($demandePath)}}" class="link">
                                            <button class="btn btn-outline-success">Registrer</button>

                                        </a>
                                    </td>
                            </tr>

                        <?php
                        $nb++;
                        }

                        ?>

                </tbody>
            </table>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    {{$demandes->links()}}
                </div>
                <div class="col-md-4"></div>
            </div>
            <?php }?>
@endsection
<style>
  .detaille{
    background-color: #f9bc14;

}
.detaille a {
  color:white;
  font-weight:bold;
  text-align:center !important;

}
.detaille a:hover{
  text-decoration:none;
}
</style>
