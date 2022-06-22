<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="/css/app.css" rel="stylesheet">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>@yield('titleHead')</title>
        <link href="/bootstrap.css" rel="stylesheet" id="bootstrap-css">
        <script src="/fontawesome.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="{{url('css/templateHead.css')}}">
    </head>
<body>
    <section class="toHide">
        <div class="headBar row">
            <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2"> <img src="{{ asset('Images/logoAfriLab.png') }}" width="50%"></div>
            <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 title"><a class="nav-link" href="{{route('ReceptionON')}}">@yield('titlePage')</a></div>
            <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3 "> listes de demandes </div>
            <div class="col-md-3 col-sm-3 col-xs-3 col-lg-3 EchantillonModification"> Modification </div>
            <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2 logout"> Déconnexion </div>
        </div>
        @yield('containPage')
    </section>
         <script src="/jquery.js"></script>
        <script src="/bootstrap.js"></script>
        <script defer type='module' src="{{url('/js/loginReception.js')}}"></script>
    </body>
</html>
