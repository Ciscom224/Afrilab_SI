<link href="/bootstrap.css" rel="stylesheet" id="bootstrap-css">
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>

<head>
    <?php

        if ($NamePrepa=="PM") {
            $namePage='AfriLab|Preparation Mecanique';
            $page='/connexion/PreparationMecanique';
        }
        elseif ($NamePrepa=="PC") {
            $namePage='AfriLab|Preparation Chimique';
            $page='/connexion/PreparationChimique';
        }
		elseif ($NamePrepa=="reception_") {
			$namePage='AfriLab|Reception';
			$page='/connexion/Reception';
		}
		elseif ($NamePrepa=="V") {
			$namePage='AfriLab|Laboratoiore Volumetrie';
			$page='/connexion/volumetrie';
		}
		elseif ($NamePrepa=='AA') {
			$namePage='AfriLab|Laboratoiore Absorption';
			$page='/connexion/absorption';
		}
        elseif ($NamePrepa=='ICP') {
			$namePage='AfriLab|Laboratoiore ICP';
			$page='/connexion/ICP';
		}
		elseif ($NamePrepa=='admin') {
			$namePage='AfriLab|Responsable Technique';
			$page='/connexion/admin';
		}
		else echo "chemin non reconnu";
    ?>
	<title><?php echo $namePage?></title>
	<script src="/jquery.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link rel="stylesheet" href="{{url('css/loginForm.css')}}">

</head>
<!--Coded with love by Mutiullah Samim-->
<body>
	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<img src="{{ asset('Images/AfriLabLogo.png') }}" class="brand_logo" alt="Logo">
					</div>
				</div>
				<div class="d-flex justify-content-center form_container">
					<form method="POST" action="<?=$page?>">
    					@csrf
						<div class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
							<input type="text" name="matricule" class="form-control input_user" value="" placeholder="Matricule" required>
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" name="password" class="form-control input_pass" value="" placeholder="Mot de passe" required>
						</div>
						<div class="form-group">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="customControlInline">
								<label class="custom-control-label" for="customControlInline">Se rappeller de moi</label>
							</div>
						</div>
						<div class="d-flex justify-content-center mt-3 login_container">

				 	        <button type="submit" name="button" class="btn login_btn">Connexion</a> </button>
				        </div>
					</form>
				</div>

				<div class="mt-4">
					<div class="d-flex justify-content-center links">
						<a href="#">Mot de passe oublié</a>
					</div>
				</div>
			</div>
		</div>
		<a href="{{route('home')}}">
			<button class="retour btn-danger"type="button"><i class="bi bi-arrow-left-circle-fill"></i></button>
			</a>
	</div>
</body>
<script src="/jquery.js"></script>
<script src="/bootstrap.js"></script>
</html>
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
</style>
