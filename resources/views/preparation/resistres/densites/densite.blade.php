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

    <title>Registre Densité</title>
</head>


<body style="margin: 1%">
    <h2 style="text-align: center">Registre de Densité</h2>
    <table class="table" border="1" width="100%" 
            <tr>
                <th scope="col">Designation</th>
                <th scope="col">Reference</th>
                <th scope="col">Masse(g)</th>
                <th scope="col">Volume initial(ml)   </th>
                <th scope="col">Volume V1</th>
                <th scope="col">Volume</th>
                <th scope="col">Densité</th>
                <th scope="col">Date</th>
                </tr>
        </thead>
        <tbody>
            @forelse($echantillons as $echantillon)
            <tr>
                <td>{{$echantillon->designation}}</td>
                <td>{{$echantillon->reference_labo}}</td>
                <td>{{$echantillon->masse}}</td>
                <td>{{$echantillon->vol_initial}}</td>
                <td>{{$echantillon->vol_v1}}</td>
                <td>volume</td>
                <td>dnsite</td>
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
        <a href="/Préparation/Chimique/Registre/densite" style="text-decoration: none;color:white"> Retour</a>
    </button>
</body>
</html>
