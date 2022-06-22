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

    <form action="/Labortoire/Volumetrie/demande/addEssai" method="post">
        @csrf
        <table class="table" border="1" width="100%" style="
            boder:2px solid red;
            ">
            <thead>
                <tr>
                    <th scope="col">Reference</th>
                    <th scope="col">Masse (g)</th>
                    <th scope="col">Volume EDTA</th>
                    <th scope="col">std1(%)</th>
                    <th scope="col">std2(%)</th>
                    <th scope="col">Concentration</th>
                    <th scope="col">Moyenne</th>
                </tr>
            </thead>

            <tbody>

                <?php
                    $path='/Preparation/Volumetrie/Registre?demande_id='.$demande_id;
                    $const1=((float)$sd1->masse/(float)$sd1->volume)*100;
                    $const2=((float)$sd2->masse/(float)$sd2->volume)*100;
                    $sd1=$const1*((float)$temoin->volume/(float)$temoin->masse);
                    $sd2=$const2*((float)$temoin->volume/(float)$temoin->masse);

                    $std_1=$const1*((float)$data->vol_edta/(float)$data->masse_pc);
                    $std_2=$const2*((float)$data->vol_edta/(float)$data->masse_pc);
                    $correction=((float)$temoin->valeur/(((float)$sd1+(float)$sd2)/2))*((float)$data->vol_edta/(float)$data->masse_pc);
                    $refLab=$data->reference_labo.'*';
                ?>
                <tr>
                    <td>{{$data->reference_labo}}
                    <input type="hidden" name="ref" value="{{$data->reference_labo}}">
                        <input type="hidden" name="demande_id" value="{{$demande_id}}">
                    </td>
                    <td>{{$data->masse_pc}}</td>
                    <td>
                        <input type="number" step="0.0001" name="volTemoin1" class="form-control input" min="0"  id="volTemoin" value="{{$data->vol_edta}}" required>
                    </td>
                    <td>{{round($std_1,3)}}</td>
                    <td>{{round($std_2,3)}}</td>
                    <td>{{round($correction,3)}}</td>
                    <td rowspan="2" id="moyenne">...</td>
                </tr>
                <tr>
                    <td>{{$refLab}}</td>
                    <td>{{$data->masse_pc}}</td>
                    <td>
                        <input type="number" step="0.0001" name="volTemoin2" class="form-control input" min="0"  id="volTemoin" placeholder="Entrer le Volume ETDA ici" required>
                    </td>
                    <td>..</td>
                    <td>..</td>
                </tr>
            </tbody>
        </table>
        <button type="submit" class="btn btn-outline-success float-md-right">Enregistrer</button>
    </form>

    <button class="btn btn-danger float-md-left">
        <i class="bi bi-arrow-left-circle-fill"></i>
        <a href="{{$path}}" style="text-decoration: none;color:white"> Retour</a>
    </button>
</body>

</html>
