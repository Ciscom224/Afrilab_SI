<link rel="stylesheet" href="{{asset('css/preparation/baseTable.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<script src="/jquery.js"></script>

@extends('preparation.registreBase')
    @section('titleHead')
        AfriLab|Salle de Préparation Chimique
    @endsection
    @section('titlePage')

       <a class="navbar-brand" href="{{route('homePagePC')}}">Préparation Chimique</a>
    @endsection
    @section('registreName')

      Registre Humidite
    @endsection

    @section('content')
        <div>
            <div class="row autoEditTareHumid" style="
                width: 25%;
                border:2px solid #f9bc14;
                border-radius:10px;
                position:absolute;
                left:25%;
                top:25%;
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
                                <input type="number" name="" id="applyHumidTare" placeholder="Entrer une valeur" class="form-control" >
                            </td>

                        </tr>
                    </table>
                </div>
                <div class="col-md-12 mt-3 mb-2">
                    <div class="btn btn-primary" style="background-color: #f9bc14;" id="editHumidTare">Appliquer</div>
                    <div class="btn btn-danger" id="delHumidTare">Fermer</div>
                </div>
            </div>

            <div class="row autoEditHumideHumid" style="
                width: 25%;
                border:2px solid #f9bc14;
                border-radius:10px;
                position:absolute;
                left:50%;
                top:25%;
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
                                <input type="number" name="" id="applyHumidHumide" placeholder="Entrer une valeur" class="form-control">
                            </td>

                        </tr>
                    </table>
                </div>
                <div class="col-md-12 mt-3 mb-2">
                    <div class="btn btn-primary" style="background-color: #f9bc14;" id="editHumidHumide">Appliquer</div>
                    <div class="btn btn-danger" id="delHumidHumide">Fermer</div>
                </div>
            </div>


            <div class="row autoEditSecheHumid" style="
                width: 25%;
                border:2px solid #f9bc14;
                border-radius:10px;
                position:absolute;
                left:65%;
                top:25%;
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
                                <input type="number" name="" id="applyHumidSeche" placeholder="Entrer une valeur" class="form-control">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-12 mt-3 mb-2">
                    <div class="btn btn-primary" style="background-color: #f9bc14;" id="editHumidSeche">Appliquer</div>
                    <div class="btn btn-danger" id="delHumidSeche">Fermer</div>
                </div>
            </div>
        </div>

        <form action="/Préparation/Chimique/RegistreAdd/humidite" method="post">
            @csrf
            <table class="table" width="100%">
                <thead>
                    <tr>
                        <th scope="col">Designation</th>
                        <th scope="col">Reference</th>
                        <th scope="col">P.Tare(g)
                            <i class="bi bi-pencil-square autoTare" style="cursor: pointer;" ></i>
                        </th>
                        <th scope="col">P.Humide(g)
                            <i class="bi bi-pencil-square autoHumide" style="cursor: pointer;" ></i>
                        </th>
                        <th scope="col">P.sèche(g)
                            <i class="bi bi-pencil-square autoSeche" style="cursor: pointer;" ></i>
                        </th>
                        <th scope="col">Poids(g)</th>
                        <th scope="col">H<SUB>2</SUB>O(%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $nb=1;
                    ?>
                    @forelse ($echantillons as $echantillon)

                        <?php

                            $references[$nb-1]=$echantillon->reference_labo;
                            $PT="poidsTare".($nb-1);
                            $PH="poidsHumide".($nb-1);
                            $PS="poidsSeche".($nb-1);
                            $P="poids".($nb-1);
                            $EAU="eau".($nb-1);
                            $ref='ref'.($nb-1);
                        ?>
                    <tr class="line" >
                        <td>{{$echantillon->designation}}</td>
                        <td>
                            <input type="text" readonly step="0.00001" class="form-control input " min="0" name="{{$ref}}"  value="{{$echantillon->reference_labo}}" >
                        </td>
                        <td>
                            <input type="number" step="0.00001" class="form-control input autoValueTare" min="0" name="<?=$PT?>" id="<?=$PT?>" placeholder="Entrer le Poids Tare ici" >
                        </td>
                        <td>
                            <input type="number" step="0.00001" class="form-control input autoValueHumide" min="0" name="<?=$PH?>" id="<?=$PH?>" placeholder="Entrer le Poids Humide ici" >
                        </td>
                        <td>
                            <input type="number" step="0.00001" class="form-control input autoValueSeche" min="0" name="<?=$PS?>" id="<?=$PS?>" placeholder="Entrer le Poids sèche ici" >
                        </td>
                        <td id="{{$P}}">...</td>
                        <td id="{{$EAU}}">...</td>
                    </tr>

                        <?php
                            $nb++;
                        ?>
                    @empty
                        <tr>
                            <td colspan="8">
                                Aucun echantillon pour l'humidite
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <input type="hidden" value="{{$nb-1}}" id="nombreEchantillon">
            </table>
            <center class="btns">
                <button type="button" class="btn valide " id="calculer">Calculer</button>
                <button type="submit" class="btn valide  ">Registrer</button>
            </center>
        </form>

            <script>
                  $('.autoTare').on('click',()=>{
                    $('.autoEditTareHumid').show(100).css({
                        'visibility':'visible'
                    })

                })
                $('#delHumidTare').on('click',()=>{
                    $('.autoEditTareHumid').hide(100).css({
                            'visibility':'hidden'
                        })
                })
                $('#editHumidTare').on('click',()=>{
                    $('.autoValueTare').val(+$('#applyHumidTare').val())
                })


                $('.autoHumide').on('click',()=>{
                    $('.autoEditHumideHumid').show(100).css({
                        'visibility':'visible'
                    })

                })
                $('#delHumidHumide').on('click',()=>{
                    $('.autoEditHumideHumid').hide(100).css({
                            'visibility':'hidden'
                        })
                })
                $('#editHumidHumide').on('click',()=>{
                    $('.autoValueHumide').val(+$('#applyHumidHumide').val())
                })


                $('.autoSeche').on('click',()=>{
                    $('.autoEditSecheHumid').show(100).css({
                        'visibility':'visible'
                    })

                })
                $('#delHumidSeche').on('click',()=>{
                    $('.autoEditSecheHumid').hide(100).css({
                            'visibility':'hidden'
                        })
                })
                $('#editHumidSeche').on('click',()=>{
                    $('.autoValueSeche').val(+$('#applyHumidSeche').val())
                })
            </script>
    @endsection
