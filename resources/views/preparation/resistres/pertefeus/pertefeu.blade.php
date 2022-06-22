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
    <h2 style="text-align: center">Registre Perte feu</h2>
    <table class="table" border="1" width="100%" >
        <thead>
            <tr>
                <th scope="col">Designation</th>
                <th scope="col">Reference</th>
                <th scope="col">Temperature(&#8451;) </th>
                <th scope="col">Masse creuset(g)</th>
                <th scope="col">Masse initiale(g)</th>
                <th scope="col">M(2h) </th>
                <th scope="col">Masse(g)</th>
                <th scope="col" > PF(%)/ MO(%) </th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($echantillons as $echantillon)
            <tr>
                <td>{{$echantillon->designation}}</td>
                <td>{{$echantillon->reference_labo}}</td>
                <td>{{$echantillon->temperature}}</td>
                <td>{{$echantillon->masse_creuse}}</td>
                <td>{{$echantillon->masse_initiale}}</td>
                <td>{{$echantillon->masse_2h}}</td>
                <td>masse</td>
                <td>pf</td>
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
        <a href="/Préparation/Chimique/Registre/pertefeu" style="text-decoration: none;color:white"> Retour</a>
    </button>
</body>
</html>
