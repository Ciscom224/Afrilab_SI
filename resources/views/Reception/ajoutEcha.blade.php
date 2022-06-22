<link href="/bootstrap.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="{{url('css/baseLabo.css')}}">
<link rel="stylesheet" href="{{url('css/modification.css')}}">
<script src="https://kit.fontawesome.com/887c56acc8.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<script src="/jquery.js"></script>

<!------ Include the above in your HEAD tag ---------->

<nav class="navbar navbar-icon-top navbar-expand-lg">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li>
      <h1>Ajout d'echantillon dans la demande : <em id="idDemande" class="colorPrimaire">{{$demande_id}}</em> </h1>
      </li>
    </ul>
  </div>
</nav>
<form action="/Reception/store" method="post">
    @csrf
    <div class="container" style="width: 50%;border:2px solid black">
        <input type="text" placeholder="Designation" class="form-control" name="degn" required>
        <?php
            $dat=explode('0',date('Y')) ;
            $refer='R/'.$demande_id.'-'.$dat[1].'-';
        ?>
        <input type="text" class="form-control" value="{{$refer}}" name="ref" required>
        <input type="hidden" id='dem_id' value="{{$demande_id}}" name="demande_id" >

        <div class="row">
            <div class="col-md-6">
                <input type="text" readonly placeholder="element" class="form-control" id="applyEl" name="elements">
            </div>
            <div class="col-md-6">
                <select  class="col-md-6 selectfield optionElement" id="autoElement">
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
        </div>
        <center class="mt-5">
            <button class="btn btn-outline-success">Ajouter</button>
            <div class="btn btn-danger"><a href="/reception" style="text-decoration: none">Retour</a> </div>
        </center>
    </div>

</form>
<script>
     let element = document.getElementById('autoElement');
        element.addEventListener('change', () => {
            let input = document.getElementById('applyEl');
            input.value += element.value + ';'
        })
</script>

