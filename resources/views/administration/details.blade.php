@extends('baseAdmin')
    @section('titleHead')
        AfriLab|Responsable Technique
    @endsection
    @section('titlePage')
    <a class="navbar-brand" href=" {{route('adminRT')}}">Responsable Technique</a>
    @endsection
    @section('barreRecherche')
        <form class="form-inline my-2 my-lg-0" method="post"  action="demande/modification/absorption">
        @csrf
        <input class="form-control mr-sm-2" type="text" placeholder="Search" name="demande_id" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Recherche</button>
        </form>
    @endsection

    @section('content')
        <div class="container">
            <div class="row details">
                <div class="col-md-12">

                    <div class="list-group">
                        <button type="button" class="list-group-item list-group-item-action active headList" aria-current="true">
                            <h3><i class="bi bi-info-circle-fill"></i>Les informations : {{$demade_id}}</h3>
                        </button>
                        @foreach ($employes as $employe )
                            <?php $date=explode(" ",$employe->date_modif)?>
                            <button type="button" class="list-group-item list-group-item-action">
                                {{$employe->nom}} de matricule {{$employe->matricule}} du {{$employe->service}} a modifié cette demande le {{$date[0]}}  à {{$date[1]}}
                            </button>
                        @endforeach

                    </div>
                </div>
                <div class="col-md-12">
                <table class="table" width="100%">
                                <thead>
                                    <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Reference Labo</th>
                                    <th scope="col">Masse(g)</th>
                                    <th scope="col">Volume(ml)</th>
                                    <th scope="col">Lecture</th>
                                    <th scope="col">Concentration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $nb=1;
                                        foreach ($echantillons as $echantillon) {
                                            $references[$nb-1]=$echantillon->reference_labo;
                                            $nameMasse="masse".($nb-1);
                                            $nameVolume="volume".($nb-1);
                                            ?>
                                            <tr class="line" >
                                                    <th scope="row">{{$nb}}</th>
                                                    <td>{{$echantillon->reference_labo}}
                                                    </td>
                                                    <td>
                                                        ...
                                                    </td>
                                                    <td>
                                                        ...
                                                    </td>
                                                    <td>...</td>
                                                    <td>...</td>
                                            </tr>

                                        <?php
                                        $nb++;
                                        }

                                        ?>

                                </tbody>
                            </table>
                            {{$echantillons->links()}}
                </div>
            </div>
        </div>
    @endsection
