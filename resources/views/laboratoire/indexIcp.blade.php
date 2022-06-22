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

    <title>Laboratoire ICP </title>
</head>


<body style="margin: 1%">
    <h2 style="text-align: center">Résultat pour la demande : {{$demande_id}}</h2>
    <div>
        <table class="table" border="1" width="100%" style="
                boder:2px solid red;
                ">
            <thead>
                <tr>
                    <th scope="col"  align="center" style="text-align: center">Element</th>
                    <th scope="col"  align="center" style="text-align: center">Reference </th>
                    <th scope="col"  align="center" style="text-align: center">Resultat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($echantillons as $e)
                    <tr>
                        <td>{{$e->element}}</td>
                        <td>{{$e->reference_labo}}</td>
                        <td>{{$e->result}}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <span>{{$echantillons->links()}}</span>
    </div>



    <button class="btn btn-danger">
        <i class="bi bi-arrow-left-circle-fill"></i>
        <a href="/laboratoire/ICP" style="text-decoration: none;color:white"> Retour</a>
    </button>
</body>
<style>
    td{
        text-align: center;
    }
</style>
</html>
