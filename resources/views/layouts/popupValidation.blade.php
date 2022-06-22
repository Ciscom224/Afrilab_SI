



<div class="container popup popupHide" id="popup">
        <div class="row">
            <div class="col-md-3 col-xs-3 col-sm-3"></div>
            <div class="col-md-6 col-xs-6 col-sm-6">
                <img src="{{ asset('Images/logoAfriLab.png') }}" width="50%">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12" style="text-align:start">Demande Numéro: <span id="NoDemandePop">{{$demande_id}} </span></div>
            <div class="col-md-12 col-xs-12 col-sm-12" style="text-align:start">Société :<span id="societePop">{{$societe}}</span> </div>
            <div class="col-md-12 col-xs-12 col-sm-12" style="text-align:start">Démandeur: <span id="NomDemandeurPop">{{$demandeur}}</span> </div>
            <div class="col-md-12 col-xs-12 col-sm-3" style="text-align:start"> Nombre d'echantillons :<span id="numEch"> {{$NombreEch}}</span> </div>
            <div class="col-md-12 col-xs-12 col-sm-3" style="text-align:start"> Recepteur :<span id="recepteur"> {{$employe->nom}}</span> </div>

        </div>
        <div class="row btnsPop">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?php $demande_idCurrent="demande/deleteDemande/".$demande_id?>
                <button class="retour btn-danger"type="button"><i class="bi bi-arrow-left-circle-fill"></i></button>
                <button type="submit" class="btn  valide valider">Valider</button>
                <button type="button" class="btn  danger nonValider"><a style="text-decoration:none" href=" {{url($demande_idCurrent)}}">Annuler</a> </button>
            </div>

        </div>
</div>
<style>
    .supprime:hover{
        transform:rotate(180deg);
        background:rgb(3, 73, 119) ;
        color:black;
    }
    .retour{
        width:50px;
        height:50px;
        border-radius:50px;
        box-shadow:0px 0px 5px black;
    }
    .btnsPop{
    transform: translateX(18vh);
    }
    .btnsPop .btn {
        width: 25%;
        margin: 3%;
        border-radius: 10px;
        border: 2px solid rgb(3, 73, 119);
        box-shadow: 0px 0px 2px black;
        outline: none;
        cursor: pointer;
        font-size: auto;
        font-family: Georgia, 'Times New Roman', Times, serif;
        color: #f9bc14;
        font-weight: bold;
    }
    .popup .row{
        margin: 10px;
        font-family: Georgia, 'Times New Roman', Times, serif;
        color: black;
        font-weight: bold;
        font-size: 20px;

    }
    .popup span{
        color: #f9bc14;
    }
    .popup i{
            cursor: pointer;
            opacity: 0.8;
    }
    .popup i:hover{
        opacity: 1;
    }

    .valide:hover{
        background-color:rgb(3, 73, 119);
        box-shadow: 0px 0px 0px black;
        color: white !important;
        transition: .5 all ease;
    }
    .danger:hover{
        background-color:#df4759;
        box-shadow: 0px 0px 0px black;
        color: white !important;
        border: 2px solid #df4759 !important;
        transition: .5 all ease;
    }
    .popup{
        border: 2px solid rgb(3, 73, 119);
        position: relative;
        /* z-index: 20; */
        width: 50% ;
        border-radius: 10px;
        box-shadow: 0px 3px 10px black;
        transform: translateY(-50vh);
        background-color: white;
    }
    .popupActive{
        visibility: visible;
    }
    .popupHide{
        visibility:hidden;
    }
</style>
