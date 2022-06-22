@extends('baseLabo')
    @section('titleHead')
        AfriLab|Laboratoire ICP
    @endsection
    @section('titlePage')

       <a class="navbar-brand" style='color:black !important;' href="#">Laboratoire ICP</a>
    @endsection
    @section('barreRecherche')

        <form class="form-inline my-2 my-lg-0" method="get"  action="/Laboratoire/ICP/demande">
            @csrf
            <input class="form-control mr-sm-2" type="number" placeholder="Search" name="demande_id" aria-label="Search" required>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Recherche</button>
        </form>
    @endsection
    @section('content')

            <div class=" margetop" >
		         <div>
                        @if (session('message'))
                            <div class="alert alert-success" >
                                {{ session('message') }}
                            </div>
                        @endif
                    </div>
		      	<form  method="post" action='/importFileXlsx' class="form" enctype="multipart/form-data">
                    @csrf
                    {{ csrf_field() }}

		      		<div class="form-group">
		      			<input type="hidden" name="MAX_FILE_SIZE" value="2097152" class="form-control">
		      		</div>
		      		<div class="form-group">
		      			<label for="upload">Chargement de fichier Xls</label>
		      			<input type="file" name="upload"  id="upload" class="form-control">
		      		</div>

		      		<div class="form-group">
		      			<button type="submit" class="btn btn-outline-success my-2 my-sm-0"><span class="glyphicon glyphicon-upload"></span> Envoyer</button>

		      		</div>
		      	</form>
		      </div>
       		</div>





    @endsection
