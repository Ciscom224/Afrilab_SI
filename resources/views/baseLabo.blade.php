<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/bootstrap.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="{{url('css/baseLabo.css')}}">

    <script src="/fontawesome.js" crossorigin="anonymous"></script>
    <!------ Include the above in your HEAD tag ---------->
    <link rel="stylesheet" href="{{url('css/demande.css')}}">
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
              <a class="nav-link" href="{{route('home')}}">
                <img src="{{ url('Images/logoAfriLab.png') }}" width="45%">
              </a>
            </li>
          </ul>
          <ul class="navbar-nav ">
              <li  class="nav-item">
                  <h5 ><em style="text-transform: uppercase;">{{$employe->nom}} </em>{{$employe->prenom}}</h5>
              </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fa fa-bell" style="visibility:visible !important">
                  <span class="badge badge-info">{{$nbEchantillon}}</span>
                </i>
                Echantillon
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fa fa-globe" style="visibility:visible !important">
                  <span class="badge badge-success">{{$nbDemande}}</span>
                </i>
                Demande
              </a>
            </li>
          </ul>
          @yield('barreRecherche')

        </div>
      </nav>
      @yield('content')
</body>
    <script src="/jquery.js"></script>
    <script src="/bootstrap.js"></script>
    <script  src="{{url('/js/layoutJs/popupController.js')}}"></script>
    <script  src="{{url('js/reception.js')}}"></script>
</html>





