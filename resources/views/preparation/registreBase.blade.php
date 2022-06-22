<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/bootstrap.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="{{url('css/baseLabo.css')}}">
    <link rel="stylesheet" href="{{url('css/preparation/registre.css')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="/fontawesome.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-icon-top navbar-expand-lg">
        @yield('titlePage')
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">

          </ul>
          <ul class="navbar-nav ">
              @yield('affichage')
             
            <li class="nav-item">
                <h2>@yield('registreName')</h2>
            </li>
          </ul>

        </div>
      </nav>
      @yield('content')
</body>
    <script src="/jquery.js"></script>
    <script src="/bootstrap.js"></script>
    <script  src="{{url('/js/verificationEtCalcul.js')}}"></script>
</html>


<!------ Include the above in your HEAD tag ---------->





