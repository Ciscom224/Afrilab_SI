<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/css/app.css" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/bootstrap.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="{{ url('css/Accueil.css')}}">
    <script src="/fontawesome.js" crossorigin="anonymous"></script>

    <title>{{config('app.name')}}</title>
</head>
<body>
    <nav>
        <div class="row container">
            <div class="col-md-3 logo"><img src="{{ asset('Images/logoAfriLab.png') }}" width="80%"></div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-3 item btn reception">
                    <a href="{{route('reception')}}" style="text-decoration: none">Réception</a>
                    </div>
                    <div class="col-md-3 item btn" id="preparation">
                        Preparation
                        <ul>
                            <li class="item s_item"><a href="{{route('preparation',['name' => 'PM'])}}" style="text-decoration: none">Mecanique</a> </li>
                            <li class="item s_item"><a href="{{route('preparation',['name' => 'PC'])}}" style="text-decoration: none">Chimique</a> </li>
                        </ul>
                    </div>
                    <div class="col-md-3 item" id="labo">Laboratoire
                        <ul>
                        <li class="item s_item"><a href="{{route('preparation',['name' => 'V'])}}" style="text-decoration: none">Volumetrie</a> </li>
                            <li class="item s_item"><a href="{{route('preparation',['name' => 'ICP'])}}" style="text-decoration: none">ICP</a> </li>
                            <li class="item s_item"><a href="{{route('preparation',['name' => 'AA'])}}" style="text-decoration: none">Absorption</a> </li>
                        </ul>
                    </div>
                      <div class="col-md-3 item"><a href="{{route('preparation',['name' => 'admin'])}}" style="text-decoration: none">Admin</a></div>
                </div>

            </div>
        </div>
    </nav>
    <!-- <img src="{{ asset('Images/AfriLabLogo.png') }}"> -->
    <footer>
        <div class="foot_title"> Laboratoire Africain des mines et l'environnement</div>
        <div class="foot_subTitle">No 344, zone industrielle Sidi Ghanem- Marrakech</div>
       <p> &copy: coryrigth{{date('Y')}} </p>
    </footer>
    <script src="/jquery.js"></script>
        <script src="/bootstrap.js"></script>
</body>
