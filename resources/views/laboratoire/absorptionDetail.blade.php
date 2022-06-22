<script src="/jquery.js"></script>
<link rel="stylesheet" href="{{asset('css/preparation/baseTable.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

@extends('preparation.registreBase')
    @section('titleHead')
        AfriLab|Laboratoire Absorption
    @endsection
    @section('titlePage')

       <a class="navbar-brand" href="{{route('homeAbsorption')}}">Laboratoire Absorption</a>
    @endsection
    @section('registreName')


    @endsection

@section('content')
    <div class="container">



            <div class="row form" style="

                border:2px solid #f9bc14;
                border-radius:10px;
                position:absolute;
                left:15%;
                top:25%;
                z-index:10;
                background:#034a78;
                box-shadow:0px 0px 10px black;
                visibility:hidden

                "
                >
                    <?php
                        $path="addTemoinAA/".$demande_id;
                    ?>
                <form action="{{$path}}" method="post" style="width: 100%">
                    @csrf
                    <div class="col-sm-12  col-md-12 col-xl-12 mt-2">
                        <input type="number" name="teneurCertifie" id="applyHumidSeche" step="0.0001" placeholder="Teneur certifié" class="form-control" required>
                    </div>
                    <div class="col-sm-12 col-md-12 col-xl-12 mt-2">
                        <input type="number" name="lecture" min="0" step="0.0001" id="applyHumidSeche" placeholder="Lecture" class="form-control" required>
                    </div>
                    <div class=" col-sm-12 col-md-12 col-xl-12 mt-2">
                        <input type="number" name="masse" id="applyHumidSeche" step="0.0001" placeholder="Masse" class="form-control" required>
                    </div>
                    <div class="col-sm-12 col-md-12 col-xl-12 mt-2">
                        <input type="number" name="volume" id="applyHumidSeche" step="0.0001" placeholder="Volume" class="form-control" required>
                    </div>
                    <div class=" col-sm-12 col-md-12  col-xl-12 mt-3 mb-2">
                        <button class="btn btn-primary" type="submit" style="background-color: #f9bc14;" id="editHumidSeche">Appliquer</button>
                        <div class="btn btn-danger" id="delForm">Fermer</div>
                    </div>
                </form>


            </div>

        <h1 scope="col" style="text-align: center">
            Resultat de l'analyse
        </h1>
        <div>
            <button class="btn shpwForm" style="position: absolute;">Temoin
                <i class="bi bi-pencil-square temoin" style="cursor: pointer;" ></i>

            </button>
        </div>
        <table class="table" width="100%">
            <thead>

                <tr>
                    <th scope="col">Elements</th>
                    <th scope="col">Reference </th>
                    <th scope="col">Lecture </th>
                    <th scope="col">Masse(g) </th>
                    <th scope="col">Volume(ml) </th>
                    <th scope="col">Volume D </th>
                    <th scope="col">PD </th>
                    <th scope="col">Teneur </th>
                    <th scope="col">Correction</th>
                </tr>
            </thead>
            <tbody>
                @if(empty($temoin))
                    <tr>
                        <th colspan="9">
                            vous devriez ajouter le temoin pour voir les resultats... Cliquez sur Temoin
                        </th>
                    </tr>

                @else
                    @forelse ($elements as $element)
                        <?php
                            $teneurCalculer=(((float)$temoin->lecture*(float)$temoin->volume)/((float)$temoin->masse*(float)$element->vid))/(float)$element->pd;
                            $coefficient=((float)$teneurCalculer)/(float)$temoin->teneur_certif;
                            $teneur=(((float)$element->lecture*(float)$element->vol_pc)/((float)$element->masse_pc*(float)$element->vid))/(float)$element->pd;
                            $correcteur=$coefficient*$teneur;
                        ?>
                        <tr>
                            @switch($element->code_element)
                                    @case(8)
                                        <th>Ag</th>
                                        @break
                                    @case(9)
                                        <th>Cu</th>
                                        @break
                                    @case(10)
                                        <th>Pb</th>
                                        @break
                                    @case(11)
                                        <th>Zn</th>
                                        @break
                                    @case(12)
                                        <th>Mn</th>
                                        @break
                                    @case(13)
                                        <th>Co</th>
                                        @break
                                    @case(14)
                                        <th>Ni</th>
                                        @break
                                    @case(15)
                                        <th>Fe</th>
                                        @break

                                    @default

                            @endswitch
                            <td>{{$element->reference_labo}}</td>
                            <td>{{$element->lecture}}</td>
                            <td>{{$element->masse_pc}}</td>
                            <td>{{$element->vol_pc}}</td>
                            <td>{{$element->vid}}</td>
                            <td>{{$element->pd}}</td>

                            <td>{{$teneur}}</td>
                            <td>{{$correcteur}}</td>


                        </tr>
                    @empty
                        <tr>
                            <th colspan="9">
                                vous  devriez charger le fichier ou le fichier chargé ne contient pas la lecture de cette demande
                            </th>
                        </tr>
                    @endforelse
                @endif
            </tbody>
        </table>
        <span>{{$elements->links()}}</span>
    </div>
    <script>

        $('.shpwForm').on('click',()=>{
                    $('.form').show(100).css({
                        'visibility':'visible'
                    })

            })
            $('#delForm').on('click',()=>{
                $('.form').hide(100).css({
                        'visibility':'hidden'
                    })
            })
    </script>

@endsection
