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
      <li class="nav-item active">
        <a class="nav-link" href="{{route('home')}}">
          <img src="{{ asset('Images/logoAfriLab.png') }}" width="45%">
        </a>
      </li>
      <li>
      <h1>Information : Demande <em id="idDemande" class="colorPrimaire">{{$demande_id}}</em> </h1>
          <input type="hidden" id='dem_id' value="{{$demande_id}}">
      </li>
    </ul>
  </div>
</nav>

    <form action="/Reception/demandeUpdate/{{$demande_id}}" method="post">
      @csrf
      <button type="submit" class="btn valide btn-outline-success m-2 ">Enregistrer</button>
        <div class="container">
                <div class="row">
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Demandeur : </span>
                        <input type="text" class="form-control" name="demandeur" aria-label="Sizing example input"  aria-describedby="inputGroup-sizing-sm" value="{{$demandes->demandeur}}">
                    </div>

                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Société : </span>
                        <input type="text" class="form-control" name="society" aria-label="Sizing example input"  aria-describedby="inputGroup-sizing-sm" value="{{$demandes->society}}">
                    </div>

                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Identification :</span>
                        <input type="text" class="form-control" name="identif" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="{{$demandes->identification_echantillon}}">
                    </div>

                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Emplacement :</span>
                        <input type="text" class="form-control" name="emplacement" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="{{$demandes->Emplacement}}">
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <label class="ombre" for="emplacement">Nombre echantillon</label>
                        <input id='emplacement'  type="text" name="nbrEch" class="nbrEch"  readonly placeholder="exemple YO28 " value="{{$demandes->nombre_echantillons}}">
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <label class="ombre" for="emplacement">Etat </label>
                        <input id='emplacement'  type="text" class="input"  name="etat" placeholder="Etat de l'cechantillon " value="{{$demandes->etat}}">
                    </div>
                </div>
      </div>
    </form>
    <div class="container">
        <h1>Les Echantillons </h1>
        <table class="table">
            <thead>
                <tr>
                    <?php
                        $che='/Reception/ajouterEchantillon/'.$demande_id
                        ?>
                  <th scope="col" style="cursor:pointer"><a href="{{$che}}"><i class="bi bi-plus-circle"></i></a></th>
                  <th scope="col">Réfrerence</th>
                  <th > Designation</th>
                  <th > Les element demandés</th>
                  <th></th>
                  <th scope="col" class="delEchantillon"></th>
                  <th scope="col" class="delEchantillon"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $nb=1;
                $i=0;
                    foreach ($echantillons as $echantillon) {
                          $ech='ech'.$nb;
                          $ref='ref'.$nb;
                          $elem='elementAna'.$nb;
                          $design='design'.$nb;
                            if($i<9){
                                $refer='R/'.$demande_id.'_'. date('Y').'_0'. ($i+1);
                            }
                            else
                                $refer='R/'.$demande_id.''. date('Y').''. ($i+1)
                        ?>
                        <tr class="line" >
                                <th scope="row">{{$nb}}</th>
                                <td>{{$echantillon->reference_labo}} <input type="hidden" name="{{$ref}}" class="form-control" value="{{$echantillon->reference_labo}}"></td>
                                <td>{{$echantillon->designation}}</td>
                                <td>
                                    {{$echantillon->elements_d_analyse}}
                              </td>
                                    <?php
                                        $refCurrent=substr($echantillon->reference_labo,2,strlen($echantillon->reference_labo));
                                        ?>
                                <td><a href="/Reception/upadtePage/{{$refCurrent}}"><i class="bi bi-pencil-square"></i></a></td>
                                <td><a href="/Reception/delete/{{$refCurrent}}"><i class="bi bi-trash " style="color:red;"></i></a></td>
                        </tr>

                    <?php
                    $i++;
                    $nb++;
                    }

                    ?>

            </tbody>
        </table>
        <center class="btns">
                <a href="{{url('/reception')}}" class="link"><button type="button" class="btn btn-danger " id="calculerDensite">Retour</button></a>
      </center>
    </div>

<script src="/jquery.js"></script>
<script src="/bootstrap.js"></script>
<script >
    function getElementName() {
        let selectfield = document.getElementsByClassName('selectfield');
        for (let i = 0; i < selectfield.length; i++) {
            let element = selectfield[i]
            element.addEventListener('change', () => {
                console.log(element.value)
                let input = document.getElementById('elementAna' + element.getAttribute('id'));
                console.log(input.value)
                input.value += ';'+element.value
            })
        }
    }
    getElementName()

    $(function() {

        let nbEch=+$('.nbrEch').val()
        let oldNbr=+$('.nbrEch').val()
        let annee = (new Date()).getFullYear();
        $('.addEchantillon').on('click',function() {
            nbEch++
            let ref="R/"+$('#dem_id').val()+"_2022_"+nbEch
            let elem='elementAna'+nbEch
            let design='design'+nbEch
            $('.nbrEch').val(nbEch)
            $('table').append("<tr class='line'><th scope='row'>"+nbEch+"</th><td>"+ref+"<input type='hidden' name=ref"+nbEch+" class='form-control' value="+ref+"></td><td><input type='text' name="+design+"   placeholder='...' class='form-control' required></td>  <td><input style='width:100%' type='text' id='"+elem+"' name='"+elem+"' class='form-control' required ></td> </tr>")

        })


        $('.delEchantillon').on('click',function() {
            if (nbEch>oldNbr) {
                nbEch--
                $('.nbrEch').val(nbEch)
                $('tr:last').remove();

            }
            else {

            alert("Impossible de supprimer ces echantillons sont uniquement a modifier")
            }
        })

    })

</script>
