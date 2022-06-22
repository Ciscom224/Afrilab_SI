<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="refresh" content="60">
    <title>@yield('titleHead')</title>
    <link href="/bootstrap.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="{{url('css/baseAdmin.css')}}">
    <link rel="stylesheet" href="{{url('css/demande.css')}}">
    <link rel="stylesheet" href="{{asset('css/adminRT.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-icon-top navbar-expand-lg">
        @yield('titlePage')
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
            <a class="nav-link" href="#">
                <img src="{{ url('Images/logoAfriLab.png') }}" width="45%">
            </a>
        </li>
        </ul>
        @yield('barreRecherche')
        <ul class="navbar-nav ">
        <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target=".bd-example-modal-sm">
                <i class="bi bi-person-fill" style="visibility:visible !important">
                <span class="badge badge-info">{{$nbrCon}}</span>
            </i>
                Connectés
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
            <i class="bi bi-envelope-fill" style="visibility:visible !important">
                <span class="badge badge-success">0</span>
            </i>
            Messages
            </a>
        </li>
        </ul>

    </div>
    </nav>

    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">

                <table class="table modal-content" >
                    <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Matricule</th>
                        <th scope="col">Service</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if (count($connectes)==0)
                            <th colspan="3">Aucun employé n'est connecté...</th>
                        @else
                            @foreach ($connectes as $connecte )
                                <tr>
                                    <td>{{$connecte->nom}}</td>
                                    <td>{{$connecte->prenom}}</td>
                                    <td>{{$connecte->matricule}}</td>
                                    <td>{{$connecte->service}}</td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>

        </div>
    </div>
    @yield('content')


</body>
</html>


<script src="/fontawesome.js" crossorigin="anonymous"></script>
<!------ Include the above in your HEAD tag ---------->





<script src="/jquery.js"></script>
<script src="/bootstrap.js"></script>

