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

      Registre perte feu
    @endsection

    @section('content')
    <div>
                    <div class="row autoEditTempPertefeu" style="
                        width: 25%;
                        border:2px solid #f9bc14;
                        border-radius:10px;
                        position:absolute;
                        left:15%;
                        top:27%;
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
                                        <input type="number" id="applyTemp" placeholder="Entrer une valeur" class="form-control">
                                    </td>

                                </tr>
                            </table>
                        </div>
                        <div class="col-md-12 mt-3 mb-2">
                            <div class="btn btn-primary" style="background-color: #f9bc14;" id="editTempPertefeu">Appliquer</div>
                            <div class="btn btn-danger" id="delTempPertefeu">Fermer</div>
                        </div>
                    </div>


                    <div class="row autoEditCreseut" style="
                        width: 25%;
                        border:2px solid #f9bc14;
                        border-radius:10px;
                        position:absolute;
                        left:30%;
                        top:27%;
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
                                        <input type="number" id="applyCreuset" placeholder="Entrer une valeur" class="form-control">
                                    </td>

                                </tr>
                            </table>
                        </div>
                        <div class="col-md-12 mt-3 mb-2">
                            <div class="btn btn-primary" style="background-color: #f9bc14;" id="editCreseut">Appliquer</div>
                            <div class="btn btn-danger" id="delCreseut">Fermer</div>
                        </div>
                    </div>


                    <div class="row autoEditMo" style="
                        width: 25%;
                        border:2px solid #f9bc14;
                        border-radius:10px;
                        position:absolute;
                        left:40%;
                        top:27%;
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
                                        <input type="number" name="" id="applyMo" placeholder="Entrer une valeur" class="form-control">
                                    </td>

                                </tr>
                            </table>
                        </div>
                        <div class="col-md-12 mt-3 mb-2">
                            <div class="btn btn-primary" style="background-color: #f9bc14;" id="editMo">Appliquer</div>
                            <div class="btn btn-danger" id="delMo">Fermer</div>
                        </div>
                    </div>


                    <div class="row autoEditM2h" style="
                        width: 25%;
                        border:2px solid #f9bc14;
                        border-radius:10px;
                        position:absolute;
                        left:60%;
                        top:27%;
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
                                        <input type="number" name="" id="applyM2h" placeholder="Entrer une valeur" class="form-control">
                                    </td>

                                </tr>
                            </table>
                        </div>
                        <div class="col-md-12 mt-3 mb-2">
                            <div class="btn btn-primary" style="background-color: #f9bc14;" id="editM2h">Appliquer</div>
                            <div class="btn btn-danger" id="delM2h">Fermer</div>
                        </div>
                    </div>
                </div>
    <form action="/Préparation/Chimique/RegistreAdd/pertefeu" method="post">
                @csrf

                    <table class="table" width="100%">
                        <thead>
                            <tr>
                            <th scope="col">Reference</th>
                            <th scope="col">Temperature(&#8451;)
                                <i class="bi bi-pencil-square autoTempPertefeu" style="cursor: pointer;" ></i>

                            </th>
                            <th scope="col">M.creuset
                                <i class="bi bi-pencil-square autoCreseutPertefeu" style="cursor: pointer;" ></i>

                            </th>
                            <th scope="col">M.initiale(g)
                                <i class="bi bi-pencil-square autoMoPertefeu" style="cursor: pointer;" ></i>
                            </th>
                            <th scope="col">M(2h)
                                <i class="bi bi-pencil-square autoM2hPertefeu" style="cursor: pointer;" ></i>

                            </th>
                            <th scope="col">Masse(g)</th>

                            <th scope="col" >
                                 PF(%)<input type="radio" name="resultat" value="pf"  >

                            </th>
                            <th scope="col">
                                MO(%)<input type="radio" name="resultat" value="mo" >
                            </th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nb=1;
                                foreach ($echantillons as $echantillon) {
                                    $references[$nb-1]=$echantillon->reference_labo;
                                    $MC="masse_c".($nb-1);
                                    $T="temperature".($nb-1);
                                    $Mo="masse_o".($nb-1);
                                    $M2h="masse_2h".($nb-1);
                                    $M="masse".($nb-1);
                                    $PF="pf".($nb-1);
                                    $ref='ref'.($nb-1);
                                    ?>
                                    <tr class="line" >
                                            <td>{{$echantillon->reference_labo}}
                                                <input id="prodId" name="{{$ref}}" type="hidden" value="{{$echantillon->reference_labo}}">
                                            </td>
                                            <td>
                                                <input type="number" step="0.00001" class="form-control input autoValueTempPertefeu" min="0" name="<?=$T?>" id="<?=$T?>" placeholder="Temperature(&#8451;)" >
                                            </td>
                                            <td>
                                                <input type="number" step="0.00001" class="form-control input autoValueCreseut" min="0" name="<?=$MC?>" id="<?=$MC?>" placeholder="masse de Creuset(g)" >
                                            </td>
                                            <td>
                                                <input type="number" step="0.00001" class="form-control input autoValueMo" min="0" name="<?=$Mo?>" id="<?=$Mo?>" placeholder="Masse M0(ml)" >
                                            </td>
                                            <td>
                                                <input type="number" step="0.00001" class="form-control input autoValueM2h" min="0" name="<?=$M2h?>" id="<?=$M2h?>" placeholder="Masse(2h)" >
                                            </td>

                                            <td id="{{$M}}" colspan="1">...</td>
                                            <td id="{{$PF}}" colspan="2">...</td>

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
                    <button type="button" class="btn valide " id="calculerPF">Calculer</button>
                    <button type="submit" class="btn valide  ">Enregistrer</button>
                </center>
            </form>


            <script>
                $('.autoTempPertefeu').on('click',()=>{
                    $('.autoEditTempPertefeu').show(100).css({
                        'visibility':'visible'
                    })

                })
                $('#delTempPertefeu').on('click',()=>{
                    $('.autoEditTempPertefeu').hide(100).css({
                            'visibility':'hidden'
                        })
                })
                $('#editTempPertefeu').on('click',()=>{
                    $('.autoValueTempPertefeu').val(+$('#applyTemp').val())
                })


                $('.autoCreseutPertefeu').on('click',()=>{
                    $('.autoEditCreseut').show(100).css({
                        'visibility':'visible'
                    })

                })
                $('#delCreseut').on('click',()=>{
                    $('.autoEditCreseut').hide(100).css({
                            'visibility':'hidden'
                        })
                })
                $('#editCreseut').on('click',()=>{
                    $('.autoValueCreseut').val(+$('#applyCreuset').val())
                })


                $('.autoMoPertefeu').on('click',()=>{
                    $('.autoEditMo').show(100).css({
                        'visibility':'visible'
                    })

                })
                $('#delMo').on('click',()=>{
                    $('.autoEditMo').hide(100).css({
                            'visibility':'hidden'
                        })
                })
                $('#editMo').on('click',()=>{
                    $('.autoValueMo').val(+$('#applyMo').val())
                })




                $('.autoM2hPertefeu').on('click',()=>{
                    $('.autoEditM2h').show(100).css({
                        'visibility':'visible'
                    })

                })
                $('#delM2h').on('click',()=>{
                    $('.autoEditM2h').hide(100).css({
                            'visibility':'hidden'
                        })
                })
                $('#editM2h').on('click',()=>{
                    $('.autoValueM2h').val(+$('#applyM2h').val())
                })
            </script>
    @endsection
