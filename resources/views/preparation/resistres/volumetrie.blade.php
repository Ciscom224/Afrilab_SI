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

    <title>Registre Volumetrie</title>
</head>


<body style="margin: 1%">
    <h2 style="text-align: center">Registre Volumetrie</h2>
    <table class="table" border="1" width="100%" style="
            boder:2px solid red;
            ">
        <thead>
            <tr>
                <th scope="col">Designation</th>
                <th scope="col">Reference</th>
                <th scope="col">Volume EDTA</th>
                <th scope="col">std1(%)</th>
                <th scope="col">std2(%)</th>
                <th scope="col">Concentration</th>
                <th scope="col">Date</th>
                <th scope="col"></th>
                </tr>
        </thead>
        <tbody>
            <?php
            $const1=((float)$sd1->masse/(float)$sd1->volume)*100;
            $const2=((float)$sd2->masse/(float)$sd2->volume)*100;
            $sd1=$const1*((float)$temoin->volume/(float)$temoin->masse);
            $sd2=$const2*((float)$temoin->volume/(float)$temoin->masse);

            ?>
            @forelse($echantillons as $echantillon)
            <?php
                $std_1=$const1*((float)$echantillon->vol_edta/(float)$echantillon->masse_pc);
                $std_2=$const2*((float)$echantillon->vol_edta/(float)$echantillon->masse_pc);
                $correction=((float)$temoin->valeur/(((float)$sd1+(float)$sd2)/2))*((float)$echantillon->vol_edta/(float)$echantillon->masse_pc)
            ?>
            <tr>
                <td>{{$echantillon->designation}}</td>
                <td>{{$echantillon->reference_labo}}</td>
                <td>{{$echantillon->vol_edta}}</td>
                <td>{{round($std_1,3)}}</td>
                <td>{{round($std_2,3)}}</td>
                <td>{{round($correction,3)}}</td>
                <?php
                    $pathRef='/Labortoire/Volumetrie/demande/autreEssaie?reference='.$echantillon->reference_labo.'&demande_id='.$echantillon->demande_id;
                    $dat=explode(" ", $echantillon->created_at);
                    $datd=explode('-',$dat[0])
                ?>
                <td>{{$datd[2]}}/{{$datd[1]}}/{{$datd[0]}}</td>
                <td>
                    <a href="{{url($pathRef)}}" style="text-decoration: none">
                        <button class="btn btn-outline-success">Essaie</button>
                    </a>
                </td>
            </tr>

            @empty
            <tr>
                <td colspan="7">
                    <h2>Aucun echantillon dans le registre Volumetrie</h2>
                </td>

            </tr>


            @endforelse



        </tbody>
    </table>
    <span >{{$echantillons->links()}}</span>

    <button class="btn btn-danger">
        <i class="bi bi-arrow-left-circle-fill"></i>
        <a href="/laboratoire/Volumetrie" style="text-decoration: none;color:white"> Retour</a>
    </button>
</body>
</html>
