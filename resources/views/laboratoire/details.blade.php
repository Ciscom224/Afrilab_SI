
<link rel="stylesheet" href="{{asset('css/preparation/baseTable.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<script src="/jquery.js"></script>

@extends('preparation.registreBase')
    @section('titleHead')
        AfriLab|Laboratoire Volumetrie
    @endsection
    @section('titlePage')

       <a class="navbar-brand" href="{{route('homeVolumetrie')}}">Laboratoire Volumetrie</a>
    @endsection
    @section('registreName')


    @endsection

@section('content')


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
        $path="addTemoin/volumetrie/".$demande_id;
    ?>
    <form action="{{$path}}" method="post" style="width: 100%">
        @csrf
        <div class="row">
            <div class="col-xl-2 col-md-4" >
                <h4>Sd1</h4>
                <input type="hidden" name="sd1" value="sd1">
            </div>
            <div class="col-xl-5 col-md-4">
                <input type="number" step="0.0001" name="sd1Masse" class="form-control input" min="0"  id="m_sd1" placeholder="Entrer la Masse de Sd1 ici" required>
            </div>
            <div class="col-xl-5 col-md-4">
                <input type="number" step="0.0001" name="sd1Volume" class="form-control input" min="0"  id="v_sd1" placeholder="Entrer le Volume ETDA ici" required>

            </div>
        </div>
        <div class="row">
            <div class="col-xl-2 col-md-4 mt-2">
                <h3>Sd2</h3>
                <input type="hidden" name="sd2" value="sd2">
            </div>
            <div class="col-xl-5 col-md-4">
                <input type="number" step="0.0001" name="sd2Masse" class="form-control input " min="0"  id="m_sd2" placeholder="Entrer la Masse " required>
            </div>
            <div class="col-xl-5 col-md-4">
                <input type="number" step="0.0001" name="sd2Volume" class="form-control input " min="0" id="v_sd2" placeholder="Entrer le Volume ETDA ici" required>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-1 col-md-1"><span>Témoin</span></div>
            <div class="col-xl-3 col-md-3">
                <input type="number" step="0.0001" name="ValTemoin" class="form-control input" min="0"  id="temoinVal" placeholder="Entrer la valeur du temoin ici" required>
            </div>
            <div class="col-xl-4 col-md-4">
                <input type="number" step="0.0001" name="masseTemoin" class="form-control input" min="0"  id="masseTemoin" placeholder="Entrer la Masse du Temoin" required>

            </div>
            <div class="col-xl-4 col-md-4">
                <input type="number" step="0.0001" name="volTemoin" class="form-control input" min="0"  id="volTemoin" placeholder="Entrer le Volume ETDA ici" required>

            </div>
        </div>
        <center>
            <div class=" col-sm-12 col-md-12  col-xl-12 mt-3 mb-2">
                <button class="btn btn-primary" type="submit" style="background-color: #f9bc14;" id="editHumidSeche">Appliquer</button>
                <div class="btn btn-danger" id="delForm">Fermer</div>
            </div>
        </center>

    </form>


</div>

<div>
    <button class="btn shpwForm" style="position: absolute;">Temoin
        <i class="bi bi-pencil-square temoin" style="cursor: pointer;" ></i>
    </button>
</div>
<div class="container">
    <?php
    $path='/Laboratoire/volumetrie/RegistreAdd/'.$demande_id
    ?>
    <form action="{{$path}}" method="post">
        @csrf
        <div>
            <div class="row autoEditVolume " style="
                width: 25%;
                border:2px solid #f9bc14;
                border-radius:10px;
                position:absolute;
                left:30%;
                top:28%;
                z-index:10;
                background:#034a78;
                box-shadow:0px 0px 10px black;
                visibility:hidden

                "
                >

                <div class="col-md-12 col-sm-12 mt-2">
                    <table>
                        <tr>
                            <td>
                                <input type="number" name=""  placeholder="Entrer une valeur" class="form-control applyVolume">
                            </td>

                        </tr>
                    </table>
                </div>
                <div class="col-md-12 col-sm-12 mt-3 mb-2">
                    <div class="btn btn-primary editVolume" style="background-color: #f9bc14;"  >Appliquer</div>
                    <div class="btn btn-danger delVolume" >Fermer</div>
                </div>
            </div>

        </div>
            <table class="table" width="100%">
                <thead>
                    <tr>
                    <th scope="col">Réference</th>
                    <th scope="col">Masse (g)</th>
                    <th scope="col">V.ETDA (ml)
                        <i class="bi bi-pencil-square autoVolume" style="cursor: pointer;" ></i>
                    </th>
                    <th scope="col">Concentration std1(%)</th>
                    <th scope="col">Concentration std2(%)</th>
                    <th scope="col">Correction</th>
                    </tr>
                </thead>

                <tbody>

                    @if(empty($temoin))
                            <tr>
                                <th colspan="6">
                                    vous devriez ajouter le temoin pour voir les resultats... Cliquez sur Temoin plus haut
                                </th>
                            </tr>
                    @else
                            <?php
                                $const1=((float)$sd1->masse/(float)$sd1->volume)*100;
                                $const2=((float)$sd2->masse/(float)$sd2->volume)*100;
                                $sd1=$const1*((float)$temoin->volume/(float)$temoin->masse);
                                $sd2=$const2*((float)$temoin->volume/(float)$temoin->masse);
                                $nb=1;
                            ?>
                        @forelse($echantillonsVols as $echantillonsVol)
                            <?php
                                    $references[$nb-1]=$echantillonsVol->reference_labo;
                                    $VETDA="vol".($nb-1);
                                    $std1="std1_".($nb-1);
                                    $std2="std2_".($nb-1);
                                    $masse="masse".($nb-1);
                                    $correct="corect_".($nb-1);
                                    $ref='ref'.($nb-1);
                                    $std_1=$const1*((float)$echantillonsVol->vol_edta/(float)$echantillonsVol->masse_pc);
                                    $std_2=$const2*((float)$echantillonsVol->vol_edta/(float)$echantillonsVol->masse_pc);
                                    $correction=((float)$temoin->valeur/(((float)$sd1+(float)$sd2)/2))*((float)$echantillonsVol->vol_edta/(float)$echantillonsVol->masse_pc)
                            ?>
                                    <tr class="line" >
                                            <th>{{$echantillonsVol->reference_labo}}
                                                <input id="prodId" name="{{$ref}}" type="hidden" value="{{$echantillonsVol->reference_labo}}">
                                            </th>
                                            <td>
                                                {{$echantillonsVol->masse_pc}}
                                                <input id="{{$masse}}"  type="hidden" value="{{$echantillonsVol->masse_pc}}">
                                            </td>
                                            <td>
                                                <input type="number" step="0.0001" value="{{$echantillonsVol->vol_edta}}" class="form-control input autoValueVolume" min="0" name="<?=$VETDA?>" id="<?=$VETDA?>" placeholder="Entrer le Volume ETDA ici" required>
                                            </td>
                                            <td id="{{$std1}}">{{round($std_1,3)}}</td>
                                            <td id="{{$std2}}">{{round($std_2,3)}}</td>
                                            <td id="{{$correct}}">{{round($correction,3)}}</td>
                                    </tr>
                                    {{$nb++}}
                        @empty
                            <?php
                                $nb=1;
                                foreach ($echantillons as $echantillon) {
                                    $references[$nb-1]=$echantillon->reference_labo;
                                    $VETDA="vol".($nb-1);
                                    $std1="std1_".($nb-1);
                                    $std2="std2_".($nb-1);
                                    $masse="masse".($nb-1);
                                    $correct="corect_".($nb-1);
                                    $ref='ref'.($nb-1);
                                    ?>
                                    <tr class="line" >
                                            <th>{{$echantillon->reference_labo}}
                                                <input id="prodId" name="{{$ref}}" type="hidden" value="{{$echantillon->reference_labo}}">
                                            </th>
                                            <td>
                                                {{$echantillon->masse_pc}}
                                                <input id="{{$masse}}"  type="hidden" value="{{$echantillon->masse_pc}}">
                                            </td>
                                            <td>
                                                <input type="number" step="0.0001" class="form-control input autoValueVolume" min="0" name="<?=$VETDA?>" id="<?=$VETDA?>" placeholder="Entrer le Volume ETDA ici" required>
                                            </td>
                                            <td id="{{$std1}}">...</td>
                                            <td id="{{$std2}}">...</td>
                                            <td id="{{$correct}}">...</td>
                                    </tr>

                                    <?php
                                    $nb++;
                                        }
                                    ?>

                        @endforelse
                    @endif


                </tbody>
            </table>
        </div>
        <center class="btns">
            <button type="button" class="btn btn-danger " id="calculerConcentration">
                <a href="/laboratoire/Volumetrie" style="text-decoration: none">Retour</a>

            </button>
            <button type="submit" class="btn valide  ">Resultat</button>
        </center>
    </form>
</div>

    <script>
        $(function() {
            $('.autoVolume').on('click',()=>{
                $('.autoEditVolume').show(100).css({
                    'visibility':'visible'
                })

            })
            $('.delVolume').on('click',()=>{
                    $('.autoEditVolume').show(100).css({
                    'visibility':'hidden'
                    })
            })

            $('.delVolume').on('click',()=>{
                    $('.autoEditVolume').show(100).css({
                    'visibility':'hidden'
                    })
            })
            $('.editVolume').on('click',()=>{
                $('.autoValueVolume').val(+$('.applyVolume').val())
            })




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
        })

    </script>
@endsection

