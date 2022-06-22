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

      {{$nameRegistre}}
    @endsection

    @section('content')
    <div>
                    <div class="row autoEditMasseDensite" style="
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
                                        <input type="number" name="" id="applyDens" placeholder="Entrer une valeur" class="form-control">
                                    </td>

                                </tr>
                            </table>
                        </div>
                        <div class="col-md-12 mt-3 mb-2">
                            <div class="btn btn-primary" style="background-color: #f9bc14;" id="editDensMasse">Appliquer</div>
                            <div class="btn btn-danger" id="delDensMasse">Fermer</div>
                        </div>
                    </div>

                    <div class="row autoEditVoDensite" style="
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
                                        <input type="number"  id="applyVo" placeholder="Entrer une valeur" class="form-control">
                                    </td>

                                </tr>
                            </table>
                        </div>
                        <div class="col-md-12 mt-3 mb-2">
                            <div class="btn btn-primary" style="background-color: #f9bc14;" id="editDensVo">Appliquer</div>
                            <div class="btn btn-danger" id="delDensVo">Fermer</div>
                        </div>
                    </div>

                    <div class="row autoEditV1Densite" style="
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
                                        <input type="number"  id="applyV1" placeholder="Entrer une valeur" class="form-control">
                                    </td>

                                </tr>
                            </table>
                        </div>
                        <div class="col-md-12 mt-3 mb-2">
                            <div class="btn btn-primary" style="background-color: #f9bc14;" id="editDensV1">Appliquer</div>
                            <div class="btn btn-danger" id="delDensV1">Fermer</div>
                        </div>
                    </div>
                </div>
    <form action="/Préparation/Chimique/RegistreAdd/densite" method="post">
                @csrf

                    <table class="table" width="100%">
                        <thead>
                            <tr>
                            <th scope="col"></th>
                            <th scope="col">Designation</th>
                            <th scope="col">Reference</th>
                            <th scope="col">Masse(g)
                                <i class="bi bi-pencil-square autoDensMasse" style="cursor: pointer;" ></i>

                            </th>
                            <th scope="col">Vol initial(ml)
                                <i class="bi bi-pencil-square autoDensVo" style="cursor: pointer;" ></i>

                            </th>
                            <th scope="col">Vol  V1
                                <i class="bi bi-pencil-square autoDensV1" style="cursor: pointer;" ></i>

                            </th>
                            <th scope="col">Volume</th>
                            <th scope="col">Densité</th>
                            <th style="background:none"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $nb=1;
                                foreach ($echantillons as $echantillon) {
                                    $references[$nb-1]=$echantillon->reference_labo;
                                    $M="masse".($nb-1);
                                    $T="temperature".($nb-1);
                                    $Vo="v_initial".($nb-1);
                                    $V1="v_1".($nb-1);
                                    $V="volume".($nb-1);
                                    $D="densite".($nb-1);
                                    $ref='ref'.($nb-1);
                                    ?>
                                    <tr class="line" >
                                            <th scope="row">{{$nb}}</th>
                                            <td>{{$echantillon->designation}}</td>
                                            <td>{{$echantillon->reference_labo}}
                                                <input id="prodId" name="{{$ref}}" type="hidden" value="{{$echantillon->reference_labo}}">
                                            </td>
                                            <td>
                                                <input type="number" step="0.00001" class="form-control input autoValueMasseDensite" min="0" name="<?=$M?>" id="<?=$M?>" placeholder="La masse(g)" required>
                                            </td>
                                            <td>
                                                <input type="number" step="0.00001" class="form-control input autoValueVoDensite" min="0" name="<?=$Vo?>" id="<?=$Vo?>" placeholder="Volume V0(ml)" required>
                                            </td>
                                            <td>
                                                <input type="number" step="0.00001" class="form-control input autoValueV1Densite" min="0" name="<?=$V1?>" id="<?=$V1?>" placeholder="Volume V1(ml)" required>
                                            </td>
                                            <td id="{{$V}}">...</td>
                                            <td id="{{$D}}">...</td>
                                    </tr>

                                <?php
                                $nb++;
                                }

                                ?>

                        </tbody>
                    </table>
                    <input type="hidden" value="{{$nb-1}}" id="nombreEchantillon">
                </div>
                <center class="btns">
                    <button type="button" class="btn valide " id="calculerDensite">Calculer</button>
                    <button type="submit" class="btn valide  ">Enregistrer</button>
                </center>
            </form>
            <script>
                $('.autoDensMasse').on('click',()=>{
                    $('.autoEditMasseDensite').show(100).css({
                        'visibility':'visible'
                    })

                })
                $('#delDensMasse').on('click',()=>{
                    $('.autoEditMasseDensite').hide(100).css({
                            'visibility':'hidden'
                        })
                })
                $('#editDensMasse').on('click',()=>{
                    console.log($('#applyDens').val());
                    $('.autoValueMasseDensite').val(+$('#applyDens').val())
                })


                $('.autoDensVo').on('click',()=>{
                    $('.autoEditVoDensite').show(100).css({
                        'visibility':'visible'
                    })

                })
                $('#delDensVo').on('click',()=>{
                    $('.autoEditVoDensite').hide(100).css({
                            'visibility':'hidden'
                        })
                })
                $('#editDensVo').on('click',()=>{
                    console.log($('#applyDens').val());
                    $('.autoValueVoDensite').val(+$('#applyVo').val())
                })


                $('.autoDensV1').on('click',()=>{
                    $('.autoEditV1Densite').show(100).css({
                        'visibility':'visible'
                    })

                })
                $('#delDensV1').on('click',()=>{
                    $('.autoEditV1Densite').hide(100).css({
                            'visibility':'hidden'
                        })
                })
                $('#editDensV1').on('click',()=>{
                    console.log($('#applyDens').val());
                    $('.autoValueV1Densite').val(+$('#applyV1').val())
                })


            </script>


    @endsection
