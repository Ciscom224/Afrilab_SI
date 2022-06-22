<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/bootstrap.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{asset('css/preparation/baseTable.css')}}">
    <link rel="stylesheet" href="{{url('css/baseLabo.css')}}">

    <title>Registre Humidité</title>
</head>


<body style="margin: 1%">
    <h2 style="text-align: center">Registre Humidité</h2>
    <table class="table" border="1" width="100%" style="
            border:2px solid red;
            ">
        <thead>
            <tr>
                <th scope="col">Designation</th>
                <th scope="col">Reference</th>
                <th scope="col">P.Tare(g)  </th>
                <th scope="col">P.Humide(g)</th>
                <th scope="col">P.sèche(g)</th>
                <th scope="col">Poids(g)</th>
                <th scope="col">H<SUB>2</SUB>O(%)</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($echantillons as $echantillon)
            <tr>
                <td>{{$echantillon->designation}}</td>
                <td>{{$echantillon->reference_labo}}</td>
                <td>{{$echantillon->poids_tar}}</td>
                <td>{{$echantillon->poids_humid}}</td>
                <td>{{$echantillon->poids_seche}}</td>
                <td>6</td>
                <td>7</td>
                    <?php

                        $dat=explode(" ", $echantillon->created_at);
                        $datd=explode('-',$dat[0])
                    ?>
                <td>{{ $datd[2]}}/{{$datd[1]}}/{{$datd[0]}}</td>
            </tr>

            @empty
            <tr>
                <td colspan="7">
                    <h2>Aucun echantillon dans le registre Humidite</h2>
                </td>
            </tr>


            @endforelse



        </tbody>
    </table>
    <span >{{$echantillons->links()}}</span>

    <button class="btn btn-danger">
        <i class="bi bi-arrow-left-circle-fill"></i>
        <a href="/Préparation/Chimique/Registre/humidite" style="text-decoration: none"> Retour</a>
    </button>
</body>
</html>
