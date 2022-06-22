@extends('baseAdmin')
    @section('titleHead')
        AfriLab|Responsable Technique
    @endsection
    @section('titlePage')
    <a class="navbar-brand" href="#">Responsable Technique</a>
    @endsection
    @section('barreRecherche')

        <a href=" {{route('home')}}" style="text-decoration: none"><button type="button" class="btn btn-outline-success mt-2">Déconnexion</button></a>


    @endsection

    @section('content')
        <div class="container" style="margin: 2%">
            <div class="row">
                <div class="col-md-10">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="4">Les demandes en cours de traitement</th>
                            </tr>
                            <tr>
                                <th scope="col">Demade</th>
                                <th  scope="col">N <sup>0</sup> Echantillon</th>
                                <th scope="col" >Date de Réception</th>
                                <th scope="col">Niveau</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($demandes as $demande)
                                @switch($demande->niveau)
                                    @case(1)
                                    <?php
                                        $niv='Réception'
                                    ?>

                                        @break
                                    @case(2)
                                        <?php
                                            $niv='Préparation  Mecanique'
                                        ?>
                                    @break
                                    @case(3)
                                        <?php
                                            $niv='Préparation  Chimique'
                                        ?>

                                    @break
                                    @default
                                        <?php
                                            $niv='inconnu'
                                        ?>
                                @endswitch
                                <tr>
                                    <td>{{$demande->demande_id}}</td>
                                    <td>{{$demande->nombre_echantillons}}</td>
                                    <?php

                                        $dat=explode(" ", $demande->created_at);
                                        $datd=explode('-',$dat[0])
                                    ?>
                                    <td>{{ $datd[2]}}/{{$datd[1]}}/{{$datd[0]}}</td>
                                    <td>{{$niv}}</td>
                                </tr>

                            @empty

                            @endforelse

                        </tbody>
                    </table>
                    <span>{{$demandes->links()}}</span>
                </div>
                <div class="col-md-2">
                    <a href="/Préparation/Chimique" style="text-decoration: none">
                        <button type="button" class="btn btn-outline-success mt-2">P.Chimique</button>
                    </a>
                    <a href="/laboratoire/Volumetrie" style="text-decoration: none">
                        <button type="button" class="btn btn-outline-success mt-2">Volumetrie</button>
                    </a>
                    <a href="/laboratoire/Absorption" style="text-decoration: none">
                        <button type="button" class="btn btn-outline-success mt-2">Absorption</button>
                    </a>

                    <button type="button" class="btn btn-outline-success mt-2">Labo ICP</button>
                </div>
        </div>
    @endsection

