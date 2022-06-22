@extends('baseLabo')
    @section('titleHead')
        AfriLab|Salle de Préparation Mecanique
    @endsection
    @section('titlePage')

       <a class="navbar-brand" href="#">Préparation Mecanique</a>
    @endsection
    @section('autre')
       rien
    @endsection
    @section('content')

    <div class="container">
        <table class="table">
            <thead>
              <tr>
                <th scope="col">Demande</th>
                <th scope="col">Client</th>
                <th scope="col" >Date reception</th>
                <th scope="col" >Nombre d'echantillons</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                @forelse ($demandes as $demande)
                    <tr>
                        <td>{{$demande->demande_id}}</td>
                        <td>{{$demande->demandeur}}</td>
                        <td>{{$demande->created_at}}</td>
                        <td>{{$demande->nombre_echantillons}}</td>
                        <td>
                            <?php
                                $path="/validationMecanique"."/".$demande->demande_id
                                ?>
                            <a href="{{$path}}">
                                <button class="btn btn-outline-success">Valider<i class="bi bi-check2-circle"></i></button>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5"><h1>Aucune demande pour instant ...</h1> </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <span>{{$demandes->links()}}</span>
</div>
    @endsection

