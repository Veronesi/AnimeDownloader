<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="/css/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="/css/main.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a id="navbar-main" class="navbar-brand" href="#"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
               <a id="btn-close-sesion" class="nav-link" href="#"><i class="fas fa-cloud-download-alt"></i> Descargar</a>
            </li>
            <li class="nav-item">
               <a id="btn-close-sesion" class="nav-link" href="#"> <i class="fas fa-upload"></i> Actualizar</a>
            </li>
            <li class="nav-item">
                <a id="btn-close-sesion" class="nav-link" href="#" data-toggle="modal" data-target="#anime-options"><i class="fas fa-cog"></i> Opciones</a>
            </li>
        </ul>
    <form class="form-inline my-2 my-lg-0">
    	<a id="btn-close-sesion" class="nav-link" href="#" onclick="location.reload();"><i class="fas fa-sync"></i> Refrescar</a>
      <input class="form-control mr-sm-2" type="search" placeholder="Titulo" aria-label="Search">
      <button id="btn-primary" class="btn btn-outline-success my-2 my-sm-0" type="submit">Agegar</button>
    </form>
    </div>
</nav>
	<div class="container" id="ani-containter">
	  <div id="row-anime-list" class="row">
	    		    
	  </div>
	</div>
<!-- Modal Opciones -->
<div class="modal fade" id="anime-options" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Opciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<form>
		  <div class="form-group row">
		    <label for="staticEmail" class="col-sm-2 col-form-label">Version</label>
		    <div class="col-sm-10">
		      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="1.0.0 Build 20180319.1">
		    </div>
		  </div>
		  <div class="form-group row">
		    <label for="inputPassword" class="col-sm-2 col-form-label">Ruta: </label>
		    <div class="col-sm-10">
		      <input type="text" class="form-control" id="form-change-url" placeholder="Ruta" value="">
		    </div>
		  </div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary"  id="btn-change-option" data-dismiss="modal">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Loading Files -->
<div class="modal fade" id="anime-loading" tabindex="-1" role="dialog" aria-hidden="true" style="height: 100%">
  <div class="modal-dialog modal-dialog-centered" role="document" style="height: 100%">
    <div class="modal-content" style="background-color: rgba(0,0,0,0); border-color: rgba(0,0,0,0);height: 100%">
      <div class="modal-body" style="text-align: center;font-size: 100px;color: white;;height: 100%;padding-top: 150px;">
      	<i class="fas fa-cog fa-spin"></i>
      </div>
    </div>
  </div>
</div>
</body>
		<script src="/vendors/font-awesome/js/fontawesome.js"></script>
		<script src="/vendors/font-awesome/js/solid.js"></script>
        <script src="/js/jquery/jquery-3.3.1.js"></script>
        <script src="/js/jquery-ui/jquery-ui.js"></script>
        <script src="/js/bootstrap/bootstrap.min.js" type="text/javascript"></script>
        <script type="text/javascript">
        	if(localStorage.length == 0){
        		localStorage.url = "C:\\Downloads\\Anime";
        	}
        		ani_update_folders();
        	$( '#form-change-url' ).val(localStorage.url);
       		if(localStorage.length > 1){
	       		for (var i = 1; i <= localStorage.length; i++) {
	       		}
       		}else{
       			$( '#row-anime-list' ).append('<div id="text-no-anime" style="text-align:center;" class="col"><a style="font-size:150px;padding-top:100px;color: #4B5961"><i class="fas fa-folder"></a></i><p style="font-size: 50px; color: #4B5961">Upss! No tienes ningun anime descargado </p><hr><p>clic <a id="btn-scan" href="#">aquí</a> para escanear la carpeta <a style="color: #7D94A0">"'+localStorage.url+' "</a>(<a href="#" data-toggle="modal" data-target="#anime-options">Cambiar Carpeta</a>)</p></div>');
       		}
       		$( '#btn-scan' ).click(function(){
       			ani_update_folders();
       		});
       		$( '#btn-close-sesion' ).click(function(){
       			ani_update_folders();
       		});
       		function ani_update_folders(){
				$.post( "/php/main.php", { url: localStorage.url , funcion: 'ani_update_folders'}).done(function( data ) {
					data = data.slice(0,data.length-1);	
					data = data.split('|');
					if(data[0].length != 0){
						$( '#text-no-anime' ).remove();
						for(i = 0; i < data.length;i++){
							er = data[i].split(';');
							$( '#row-anime-list' ).append('<div class="col"><div id="Anime'+er[1]+'" class="ani-img" onclick="view_anime('+er[1]+');"><p class="ika-p">'+er[0]+'</p></div></div>');
							$('#Anime'+er[1]).css("background-image", "url(https://animeflv.net/uploads/animes/covers/"+er[1]+".jpg)"); 
							$('#Anime'+er[1]).css("background-size", "260px 370px"); 
						}
					}
				});
			}
			$( '#btn-change-option' ).click(function(){
				url = $( '#form-change-url' ).val();
				if(url[url.length-1] == "\\"){
					url = url.slice(0, url.length-1);
				}
				localStorage.url = url;
			});
			function view_anime(code){
			location.href = '/list_anime.php?code='+code;
			}
       	</script>
</html>