<!DOCTYPE html>
<!-- Created By CodingNepal - www.codingnepalweb.com -->
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratoire Absorption</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

</head>
<body>
<form action="/addData" method="post" enctype="multipart/form-data" >
  @csrf
  {{ csrf_field() }}
  <div class="drag-area">
        <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
        <header>Glissez-déposez pour télécharger le fichier
        </header>
        <span>OU</span>

              <input type="file" name='AAFile'id="AAfile" hidden required>
              <div class="btn">Parcourir les fichiers</div>
      </div>
      <input type="submit"  value="Valider" id='submitBtn'>

</form>
<a href="/laboratoire/Absorption" style="text-decoration: none">
    <div class="btn btn-danger button"><i class="bi bi-arrow-left-short"></i>Retour</div>
</a>

  <script >
      //selecting all required elements
          const dropArea = document.querySelector(".drag-area"),
          dragText = dropArea.querySelector("header"),
          button = dropArea.querySelector(".btn"),
          input = dropArea.querySelector("input[type='file']");
          let file; //this is a global variable and we'll use it inside multiple functions
          button.onclick = ()=>{
            input.click(); //if user click on the button then the input also clicked
          }
      input.addEventListener("change", function(){
        //getting user select file and [0] this means if user select multiple files then we'll select only the first one
        file = this.files[0];
        dropArea.classList.add("active");
        showFile(); //calling function
      });
      //If user Drag File Over DropArea
      dropArea.addEventListener("dragover", (event)=>{
        event.preventDefault(); //preventing from default behaviour
        dropArea.classList.add("active");
        dragText.textContent = "Relachez pour enregistrer le fichier";
      });
      //If user leave dragged File from DropArea
      dropArea.addEventListener("dragleave", ()=>{
        dropArea.classList.remove("active");
        dragText.textContent = "Glissez-déposez pour télécharger le fichier";
      });
      //If user drop File on DropArea
      dropArea.addEventListener("drop", (event)=>{
        event.preventDefault(); //preventing from default behaviour
        //getting user select file and [0] this means if user select multiple files then we'll select only the first one
        file = event.dataTransfer.files[0];
        showFile(); //calling function
      });
      function showFile(){
        let fileName = file.name; //getting selected file type
          let fileReader = new FileReader(); //creating new FileReader object
          fileReader.onload = ()=>{
            let fileURL = fileReader.result; //passing user file source in fileURL variable
            dragText.textContent = "Nom du fichier :"+fileName;
          }
          fileReader.readAsDataURL(file);
      }

  </script>

</body>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
    *{
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }
    body{
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: rgb(3, 73, 119);
    }

    .drag-area{
      border: 2px dashed #fff;
      height: 500px;
      width: 700px;
      border-radius: 5px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
    }
    .drag-area.active{
      border: 2px solid #fff;
    }
    .drag-area .icon{
      font-size: 100px;
      color: #fff;
    }
    .drag-area header{
      font-size: 30px;
      font-weight: 500;
      color: #fff;
    }
    .drag-area span{
      font-size: 25px;
      font-weight: 500;
      color: #fff;
      margin: 10px 0 15px 0;
    }
    .drag-area .btn,#submitBtn,.button{
      padding: 10px 25px;
      font-size: 20px;
      font-weight: 500;
      border: none;
      outline: none;
      background: #f9bc14;
      color: rgb(3, 73, 119);
      border-radius: 5px;
      cursor: pointer;
     box-shadow:0px 3px 15px black;

    }
    .button{
        background: #e43408;
        position: absolute;
        width: auto;
        left: 0%;
        top: 90%
    }
    .drag-area .btn:hover,#submitBtn:hover,.button:hover{
     box-shadow:0px 0px 5px black;
     color:#fff;
     transition:all .5 ease;

    }
    #submitBtn{
     position: relative;
     z-index: 10;
     /* top:20vh; */
     left:45vh;
    }
</style>
</html>

