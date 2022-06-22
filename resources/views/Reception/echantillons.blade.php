<link rel="stylesheet" href="{{asset('css/echantillon.css')}}">
<script src="/jquery.js"></script>

@extends('baseLabo')
    @section('titleHead')
        Réception|Demande|Echantillon(s)
    @endsection
    @section('titlePage')
        <a class="navbar-brand" href=" {{route('reception')}}">Réception</a>
    @endsection

    @section('content')

    <?php   $demande_path="/Reception/echantillons/demande/".$demande_id?>
    <center>
    <form action="<?= $demande_path?>" id="echantillonForm" method="POST">
         @csrf
         <h1 style="text-align:center"> Les echantillons Pour la demande :{{$demande_id}}</h1>
            <div class="row autoEditDesignation" style="
                                    width: 25%;
                                    border:2px solid #f9bc14;
                                    border-radius:10px;
                                    position:absolute;
                                    left:20%;
                                    z-index:10;
                                    background:#034a78;
                                    box-shadow:0px 0px 10px black;
                                    visibility: hidden
                                    "
                                    >

                <div class="col-md-12 mt-2">
                    <table>
                        <tr>
                            <td>
                                <input type="text" name="" id="apply" placeholder="Ecrivez le mot commun" class="form-control">
                            </td>
                            <td>
                                <select id="debut" class="form-select" required name="service">
                                <option selected>Debut</option>

                                    @for ($i = 0; $i < 10; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-12 mt-3 mb-2">
                    <div class="btn btn-primary" style="background-color: #f9bc14;" id="editDesign">Appliquer</div>
                    <div class="btn btn-danger" id="delDesign">Quitter</div>
                </div>
            </div>
            <div class="row autoEditElement" style="
                width: 25%;
                border:2px solid #f9bc14;
                border-radius:10px;
                position:absolute;
                left:60%;
                z-index:10;
                background:#034a78;
                box-shadow:0px 0px 10px black;
                visibility: hidden

                "
                >

                <div class="col-md-12 mt-2">
                    <table>
                        <tr>
                            <td style="width: 70%">
                                <input type="text" name="" id="applyEl" placeholder="Les elements" class="form-control">
                            </td>
                            <td>
                                <select id="autoElement" class="form-select" required style="
                                width:100%
                                        ">
                                    <option selected>elements</option>

                                    @foreach ($elements as $element )
                                        <option value="<?="(".$element->id.")".$element->nom_simple?>"><em><?php echo $element->nom_analyse ?></em></option>
                                    @endforeach

                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-12 mt-3 mb-2">
                    <div class="btn btn-primary" style="background-color: #f9bc14;" id="editElem">Appliquer</div>
                    <div class="btn btn-danger" id="delElem">Quitter</div>
                </div>
            </div>
            <table class="table" border="2">
                <tr id="entete">
                    <th >Designation
                        <i class="bi bi-pencil-square autoEdit" style="cursor: pointer;" ></i>

                    </th>
                    <th >Reference Labo</th>
                    <th colspan="2">Elements démandés
                        <i class="bi bi-pencil-square autoElem" style="cursor: pointer;" ></i>

                    </th>
                </tr>
                <input type="hidden" name="" value="{{$NombreEch}}" id="nbr_Ech">
                <?php
                 $dat=explode('0',date('Y')) ;
                for ($i=0; $i <$NombreEch  ; $i++) {
                    $design="designation".($i+1);
                    $idD='id'.($i+1);
                    $elem="elementAna".($i+1);
                    $ref="reference".($i+1);
                    $classDiv="form-control id".($i+1);
                    $divElement=$classDiv." editAll ";

                    if($i<9){
                        $refer="R/".$demande_id."-".$dat[1]."-0".($i+1);

                    }
                    else
                        $refer="R/".$demande_id."-".$dat[1]."-".($i+1);

                   ?>
                <tr>
                    <td  class='elementscar'>
                        <input class="<?= $classDiv?>" type='text' placeholder='Designation' name="<?= $design?>" id="<?= $idD?>" required >
                    </td>
                    <td id='ref1'> <em name="<?=$ref ?>">{{$refer}}</em> </td>
                    <td colspan="2">
                        <div class="row">

                                <div class="col-md-3">
                                    <?php $allClass= "col-md-6  ech".($i+1)?>
                                    <select  id="<?=($i+1)?>" class="col-md-6 selectfield optionElement">
                                    <option value="">Choix</option>
                                        <?php
                                            foreach ($elements as $element) {

                                                ?>
                                                    <option value="<?="(".$element->id.")".$element->nom_simple?>"><em><?php echo $element->nom_analyse ?></em></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-10">
                                             <input style="width:100%" type="text" id="<?= $elem?>" name="<?= $elem?>" readonly  value="" class="<?=$divElement?>" placeholder="Les éléments demandés" required >

                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class='supprime' id="<?= $elem?>"><i class="bi bi-arrow-repeat"></i></button>

                                        </div>
                                    </div>
                            </div>

                        </div>

                    </td>
                </tr>

                <?php
                }
            ?>

            </table>


        <div class="btns" id="btnForm">
        <div  class="btn btn-lg valide registerBTN">Enregistrer</div>
        <button type="reset" class="btn btn-lg danger annuler" id="reinitialiser">Réinitialiser </button>
    </div>

    @include('layouts.popupValidation')
    </form>
    </center>

    @include('layouts.popupValidation')
@endsection
<script>
    $(function() {

            let nbr=+$('#nbr_Ech').val()
        $('.autoEdit').on('click',()=>{
                $('.autoEditDesignation').show(100).css({
                    'visibility':'visible'
                })

        })
        $('#delDesign').on('click',()=>{
            $('.autoEditDesignation').hide(100).css({
                    'visibility':'hidden'
                })
        })
        $('#editDesign').on('click',()=>{
            let deb=+$('#debut').val()
            let j=1
            for (let i = deb; i <= nbr+deb; i++) {
                let id='#id'+j

                $(id).val($('#apply').val()+i)
                j++


            }
        })



        $('.autoElem').on('click',()=>{
                $('.autoEditElement').show(100).css({
                    'visibility':'visible'
                })

        })
        $('#delElem').on('click',()=>{
            $('.autoEditElement').hide(100).css({
                    'visibility':'hidden'
                })
        })
        $('#editElem').on('click',()=>{
            $('.editAll').val($('#applyEl').val())
        })
        let element = document.getElementById('autoElement');
        element.addEventListener('change', () => {
            let input = document.getElementById('applyEl');
            input.value += element.value + ';'
        })



    })


</script>
