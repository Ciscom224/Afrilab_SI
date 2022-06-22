<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<body>
    <div class="container">
        <form   action='/admin/employe/store' method="POST">
            @csrf
        <div class="col-md-12 mt-2" >
            <input type="text" class="form-control"  placeholder="Entrer la Nom" name="nom" required>
        </div>
        <div class="col-md-12">
            <input type="text" class="form-control"  placeholder="Entrer le prénom" name="prenom" required >
        </div>
        <div class="col-md-12">
            <input type="text" class="form-control"  placeholder="Matricule de l'employe" name="matricule" required >
        </div>
        <div class="col-md-12">
            <input type="password" class="form-control"  placeholder="Mot de passe " name="pass" required>
        </div>
        <div class="col-md-4">
            <select id="inputState" class="form-select" required name="service">
            <option selected>Ouvrez pour choisir un servie</option>
            <option value="reception">Réception</option>
            <option value="mecanique">Préparation Mecanique</option>
            <option value="chimique">Préparation Chimique</option>
            <option value="volumetrie">Volumetrie</option>
            <option value="absorption">Labo Absorption</option>
            <option value="icp">Labo ICP</option>
            <option value="admin">Administration</option>


            </select>
        </div>
        <div class="col-12">
            <button type="submit" class="btn subme" id="subme">Ajouter</button>
        </div>
        </form>
    </div>
</body>
    <style>
            .retour{
            width:50px;
            height:50px;
            border-radius:50px;
            box-shadow:0px 0px 5px black;
        }
        i{
        font-size:5vh;
        }

        form{
            width: 100%;
        }
        input::placeholder{
            font-size: 15px;
            font-weight: bold;
        }
        input{
            height: 5vh;
            width: 50%;
            font-size: 25px;
            margin: 2px;
        }
        .subme{
            background-color: #f9bc14 !important;
        }
    </style>
</html>


<!------ Include the above in your HEAD tag ---------->
