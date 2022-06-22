<?php
$nb=1;
    foreach ($infos as $info) {
        $demandePath="/administration/detatils/demande/".$info->demande_id;
        $demandeEnvoi="demande/envoie/".$info->demande_id;
        $date=explode(" ",$info->created_at);
        ?>
        <tr class="line" href="1">
                <th>{{$info->demande_id}}</th>
                <td>{{$info->nombre_echantillons}}</td>
                <td >{{$date[0]}}</td>
                <td>{{$date[1]}}</td>
                <td ><a href="{{url($demandePath)}}" class="link detaille">Voir plus</a></td>
                <td ><a href="{{url($demandeEnvoi)}}" class="link detaille"><button class="btn btn-outline-success">Envoyer</button></a></td>
        </tr>

    <?php
    $nb++;
    }

    ?>
