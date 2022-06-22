<link rel="stylesheet" href="{{url('css/formulaireEchantillon.css')}}">
    @extends('baseLabo')
    @section('titleHead')
        AfriLab|Réception
    @endsection
    @section('titlePage')
    <a class="navbar-brand" href=" {{route('reception')}}">Réception</a>
    @endsection
    @section('barreRecherche')
        <form class="form-inline my-2 my-lg-0" method="get"  action="/demande/modification/">
        @csrf
        <input class="form-control mr-sm-2" type="text" placeholder="Search" name="demande_id" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Recherche</button>
        </form>
    @endsection

    @section('content')
 <center>
    <form method="POST" action="/Reception/Ajoutdemande" id="demadeForm">
            @csrf
            <div class="row tab1 ">
                <div class="col-md-12 line">
                    <input id="demandeur" name="demandeur" type="text" class="input" placeholder="Nom du Demandeur" required>
                </div>

                <div class="col-md-12 line ">
                    <input id="societe"  name="societe" type="text" class="input" placeholder="Nom de la Sociéte"  required>
                </div>

                <div class="col-md-12 line col-sm-12">
                    <input id='identificateur'  name="identificateur" type="text" class="input" placeholder="Identification des echantillons ">
                </div>

                <div class="col-md-12 line col-sm-12">
                    <input id='numDemande'  name="numDemande" type="number" class="input" min="0" placeholder="Numero de la demande">
                </div>

                <div class="col-md-12 line col-sm-12">
                    <input id='emplacement'  name="emplacement" type="text" class="input"  placeholder="Emplacement">
                </div>

                <div class="col-md-12 line col-sm-12">
                    <div class="row">
                        <div class="col-md-6">
                            <select name="etat" id="etat">
                                <option value="" selected>Etat de l'echantillon </option>
                                <option value="solide" id="solideChoose">Solide</option>
                                <option value="liquide" >Liquide</option>
                                <option value="pulpe">Pulpe</option>
                            </select >
                        </div>

                        <div id="solideOptions" class="col-md-6">
                            <div >
                                <input type="radio" id="roche" name="solide" value="roche" class="option-input radio">
                                <label  for="roche">Roche</label>
                            </div>

                            <div>
                                <input type="radio" id="minerai" name="solide" value="minerai" class="option-input radio">
                                <label  for="minerai">Minerai</label>
                            </div>
                            <div>
                                <input type="radio" id="carotte" name="solide" value="carotte" class="option-input radio">
                                <label  for="carotte">Carotte</label>
                            </div>
                            <div>
                                <input type="radio" id="sol" name="solide" value="sol" class="option-input radio">
                                <label  for="sol">Sol</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 line">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="depotAfrilab" id="depotAfrilab">
                                <option value="">Echantillonnage</option>
                                <option value="AfriLAb" >AFRILAB</option>
                                <option value="Client" >Client</option>
                            </select >
                        </div>
                        <div id="depotoire" class="col-md-9">
                            <div >
                                <input type="radio" id="ULS" name="depot" value="ULS" class="option-input radio">
                                <label  for="ULS">ULS</label>
                            </div>

                            <div>
                                <input type="radio" id="AZILOG" name="depot" value="AZILOG"  class="option-input radio">
                                <label  for="AZILOG">AZILOG</label>
                            </div>
                            <div>
                                <input type="radio" id="SSL" name="depot" value="SSL"  class="option-input radio">
                                <label  for="SSL">LSS</label>
                            </div>
                            <div>
                                <input type="radio" id="BELARCO" name="depot" value="BELARCO"  class="option-input radio">
                                <label  for="BELARCO">BELARCO</label>
                            </div>
                            <div>
                                <input type="radio" id="Site_client"  class="option-input radio" name="depot" value="Site client">
                                <label  for="Site_client">Site client</label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-floating col-md-12 line col-sm-12">
                    <textarea class="form-control" placeholder="Observaton sur la demande"  name="observation" style="height: 50px"></textarea>
                    <label for="floatingTextarea2">Observation</label>
                </div>
                <div class="col-md-12 line col-sm-12">
                    <input id='emplacement'  name="livraison" type="text" class="input"  placeholder="Livraison" >
                </div>
                <div class="col-md-12 line col-sm-12">
                Nombre d'echantillons
                    <select name="nombre" id="nombre">
                            <option value="0" selected>Nombre d'echantillons</option>
                            <option value="1" >1</option>
                            <?php for ($i=2; $i < 27; $i++) {
                                ?>
                                <option value="<?=$i?>"><?php echo $i?></option>
                                <?php
                            }
                            ?>
                    </select >
                </div>
            </div>

            <input class="btn d-grid gap-3 col-3 mx-auto " style="background:rgb(3, 73, 119);color:#f9bc14" id="ehantillon" type="submit" value="Ehantillons" name="echantillon">

    </form>
    </center>
    @endsection
