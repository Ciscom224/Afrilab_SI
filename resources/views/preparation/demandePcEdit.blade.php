<script src="/jquery.js"></script>
<link rel="stylesheet" href="{{asset('css/preparation/baseTable.css')}}">
@extends('baseLabo')
    @section('titleHead')
        AfriLab|Salle de Préparation Chimique
    @endsection
    @section('titlePage')

       <a class="navbar-brand" href="{{route('homePagePC')}}">Préparation Chimique</a>
    @endsection

@section('content')
  <h1 style='text-align:center'>DEMANDE : {{$demande_id}}</h1>
  <?php
       $path='/Préparation/Chimique/MasseVolume/'.$demande_id;
  ?>
    <div>
        <div class="row autoEditMasse" style="
            width: 25%;
            border:2px solid #f9bc14;
            border-radius:10px;
            position:absolute;
            left:30%;
            top:29%;
            z-index:10;
            background:#034a78;
            box-shadow:0px 0px 10px black;
            visibility:hidden

            "
            >

            <div class="col-md-12 mt-2">
                <table>
                    <tr>
                        <td>
                            <input type="number" name="" id="applyMas" placeholder="Entrer une valeur" class="form-control">
                        </td>

                    </tr>
                </table>
            </div>
            <div class="col-md-12 mt-3 mb-2">
                <div class="btn btn-primary" style="background-color: #f9bc14;" id="editMas">Appliquer</div>
                <div class="btn btn-danger" id="delMas">Fermer</div>
            </div>
        </div>

        <div class="row autoEditVolume" style="
            width: 25%;
            border:2px solid #f9bc14;
            border-radius:10px;
            position:absolute;
            left:50%;
            top:29%;
            z-index:10;
            background:#034a78;
            box-shadow:0px 0px 10px black;
            visibility:hidden
            "
            >

            <div class="col-md-12 mt-2">
                <table>
                    <tr>
                        <td>
                            <input type="number" name="" id="applyVol" placeholder="Entrer une valeur" class="form-control">
                        </td>

                    </tr>
                </table>
            </div>
            <div class="col-md-12 mt-3 mb-2">
                <div class="btn btn-primary" style="background-color: #f9bc14;" id="editVol">Appliquer</div>
                <div class="btn btn-danger" id="delVol">Fermer</div>
            </div>
        </div>

        <div class="row autoEditVolumeD" style="
            width: 25%;
            border:2px solid #f9bc14;
            border-radius:10px;
            position:absolute;
            left:60%;
            top:29%;
            z-index:10;
            background:#034a78;
            box-shadow:0px 0px 10px black;
            visibility:hidden
            "
            >

            <div class="col-md-12 mt-2">
                <table>
                    <tr>
                        <td>
                            <input type="number" name="" id="applyVolD" placeholder="Entrer une valeur" class="form-control">
                        </td>

                    </tr>
                </table>
            </div>
            <div class="col-md-12 mt-3 mb-2">
                <div class="btn btn-primary" style="background-color: #f9bc14;" id="editVolD">Appliquer</div>
                <div class="btn btn-danger" id="delVolD">Fermer</div>
            </div>
        </div>

        <div class="row autoEditVolumePD" style="
        width: 25%;
        border:2px solid #f9bc14;
        border-radius:10px;
        position:absolute;
        left:70%;
        top:29%;
        z-index:10;
        background:#034a78;
        box-shadow:0px 0px 10px black;
        visibility:hidden
        "
        >

        <div class="col-md-12 mt-2">
            <table>
                <tr>
                    <td>
                        <input type="number" name="" id="applyVolPD" placeholder="Entrer une valeur" class="form-control">
                    </td>

                </tr>
            </table>
        </div>
        <div class="col-md-12 mt-3 mb-2">
            <div class="btn btn-primary" style="background-color: #f9bc14;" id="editVolPD">Appliquer</div>
            <div class="btn btn-danger" id="delVolPD">Fermer</div>
        </div>
    </div>
    </div>
    <form action="{{$path}}" method="post" name="myform">
        @csrf

                    <table class="table" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">Designation</th>
                                <th scope="col">Reference</th>
                                <th scope="col">Masse(g)
                                    <i class="bi bi-pencil-square autoMasse" style="cursor: pointer;" ></i>
                                </th>
                                <th scope="col">Volume(ml)
                                    <i class="bi bi-pencil-square autoVolume" style="cursor: pointer;" ></i>

                                </th>
                                <th scope="col"> Volume D
                                    <i class="bi bi-pencil-square autoVolumeD" style="cursor: pointer;" ></i>

                                </th>
                                <th scope="col">PD
                                    <i class="bi bi-pencil-square autoVolumePD" style="cursor: pointer;" ></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                                <?php
                                $nb=1;
                                foreach ($echantillons as $echantillon) {
                                    $references[$nb-1]=$echantillon->reference_labo;
                                    $nameMasse="masse".($nb-1);
                                    $nameVolume="volume".($nb-1);
                                    $nameVolumeD="volumeD".($nb-1);
                                    $PD="PD".($nb-1);
                                    $ref='ref'.($nb-1);
                                    ?>

                                    <tr class="line" >
                                            <td>{{$echantillon->designation}}</td>
                                            <td>{{$echantillon->reference_labo}}
                                                <input id="prodId" name="{{$ref}}" type="hidden" value="{{$echantillon->reference_labo}}">
                                            </td>
                                            <td>
                                                <input type="number" value="{{$echantillon->masse_pc}}" step="0.0001" class="form-control autoIntMasse" min="0" name="<?=$nameMasse?>" placeholder="Entrer la masse ici" required>
                                            </td>
                                            <td>
                                                <input type="number" value="{{$echantillon->vol_pc}}" step="0.0001" class="form-control autoIntVolume" min="0" name="<?=$nameVolume?>" placeholder="Entrer le Volume ici" required>
                                            </td>
                                            <td>
                                                <input type="number" value="{{$echantillon->vid}}" step="0.0001" class="form-control autoIntVolumeD" min="0" name="<?=$nameVolumeD?>" placeholder="Entrer le Volume ici" required>
                                            </td>
                                            <td>
                                                <input type="number" value="{{$echantillon->pd}}" step="0.0001" class="form-control autoIntVolumePD" min="0" name="<?=$PD?>" placeholder="Entrer le Volume ici" required>
                                            </td>
                                    </tr>

                                    <?php
                                    $nb++;
                                    }

                                ?>

                        </tbody>
                    </table>
                </div>
                <center class="btns">
                    <button type="submit" class="btn valide ">Valider</button>
                    <button type="reset" class="btn danger  "><a href="/Préparation/Chimique" style="text-decoration: none">Retour</a> </button>

                </center>
    </form>
    <script>
           $('.autoMasse').on('click',()=>{
                $('.autoEditMasse').show(100).css({
                    'visibility':'visible'
                })

        })
        $('#delMas').on('click',()=>{
            $('.autoEditMasse').hide(100).css({
                    'visibility':'hidden'
                })
        })
        $('#editMas').on('click',()=>{
         console.log($('#applyMas').val());
         $('.autoIntMasse').val(+$('#applyMas').val())
        })


        $('.autoVolume').on('click',()=>{
                $('.autoEditVolume').show(100).css({
                    'visibility':'visible'
                })

        })
        $('#delVol').on('click',()=>{
            $('.autoEditVolume').hide(100).css({
                    'visibility':'hidden'
                })
        })
        $('#editVol').on('click',()=>{
         console.log($('#applyVol').val());
         $('.autoIntVolume').val(+$('#applyVol').val())
        })


        $('.autoVolumeD').on('click',()=>{
                $('.autoEditVolumeD').show(100).css({
                    'visibility':'visible'
                })

        })
        $('#delVolD').on('click',()=>{
            $('.autoEditVolumeD').hide(100).css({
                    'visibility':'hidden'
                })
        })
        $('#editVolD').on('click',()=>{
         console.log($('#applyVolD').val());
         $('.autoIntVolumeD').val(+$('#applyVolD').val())
        })


        $('.autoVolumePD').on('click',()=>{
                $('.autoEditVolumePD').show(100).css({
                    'visibility':'visible'
                })

        })
        $('#delVolPD').on('click',()=>{
            $('.autoEditVolumePD').hide(100).css({
                    'visibility':'hidden'
                })
        })
        $('#editVolPD').on('click',()=>{
         console.log($('#applyVolPD').val());
         $('.autoIntVolumePD').val(+$('#applyVolPD').val())
        })

    </script>
@endsection
