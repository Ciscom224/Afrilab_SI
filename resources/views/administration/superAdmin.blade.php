@extends('baseAdmin')
    @section('titleHead')
        AfriLab|Administration
    @endsection
    @section('titlePage')
    <a class="navbar-brand" href="#">Administration</a>
    @endsection
    @section('barreRecherche')

        <a href=" {{route('home')}}" style="text-decoration: none"><button type="button" class="btn btn-outline-success mt-2">Déconnexion</button></a>


    @endsection

    @section('content')
        <div class="container" style="margin: 2%">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Demade</th>
                        <th  scope="col">N <sup>0</sup> Echantillon</th>
                        <th scope="col" >Date de Réception</th>
                        <th style="background:none"></th>
                        <th style="background:none"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($demandes as $demande)
                            <?php
                             $path="/formRapport".'/'.$demande->demande_id;
                             $pathExport="/exportRapport".'/'.$demande->demande_id;
                            ?>
                        <tr>
                            <td>{{$demande->demande_id}}</td>
                            <td>{{$demande->nombre_echantillons}}</td>
                            <?php

                                $dat=explode(" ", $demande->created_at);
                                $datd=explode('-',$dat[0])
                            ?>
                            <td>{{ $datd[2]}}/{{$datd[1]}}/{{$datd[0]}}</td>
                            <td>
                                <a href="{{$path}}" style="text-decoration: none">
                                    <button class="btn btn-outline-success">Rapport(PDF)</button>
                                </a>
                            </td>
                            <td>
                                <a href="{{$pathExport}}" style="text-decoration: none">
                                    <button class="btn btn-outline-success">Rapport(Excel)</button>
                                </a>
                            </td>
                        </tr>

                    @empty

                    @endforelse

                </tbody>
            </table>
            <span>{{$demandes->links()}}</span>
        </div>
    @endsection

