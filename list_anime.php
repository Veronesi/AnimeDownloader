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
								<a class="nav-link" href="/home.php">Inicio <span class="sr-only">(current)</span></a>
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
	<div id="container-capitulos" class="container">
		<div id="container-capitulos2"></div>
		<table class="table" style="text-align: center;">
			<tbody id="tbody-capitulos">
				
			</tbody>
		</table>		
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
				<button type="button" class="btn btn-primary"	id="btn-change-option" data-dismiss="modal">Guardar Cambios</button>
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
	Nombre="";
	code="";
	Ultimo=0;
	$( '#btn-change-option' ).click(function(){
		url = $( '#form-change-url' ).val();
		if(url[url.length-1] == "\\"){
			url = url.slice(0, url.length-1);
		}
		localStorage.url = url;
	});
	code = <?php print $_GET['code']; ?> ;
	$.post( "/php/main.php", { code:	code, funcion: 'listCap', url: localStorage.url}).done(function( data ) {
		// Dividimos el string
		parametros = data.split('|');
		if(parametros.length == 1){
			// No hay ningun capitulo mal descargado.
			parametros = data.split(';');
			Nombre = parametros[3];
			Ultimo = parametros[1];
			$( '#container-capitulos2' ).append('<div class="alert alert-primary" role="alert" style="text-align:center">'+parametros[3]+'</div>');
			if(parametros[2] == "0"){
				$( '#container-capitulos2' ).append('<div class="alert alert-danger" role="alert" style="text-align:center">Serie Finalizada</div>');
			}else{
				$( '#container-capitulos2' ).append('<div class="alert alert-success" role="alert" style="text-align:center">Proximo Episodio: '+parametros[2]+'</div>');
			}
			while(parametros[1] > parametros[0] -1){
				$( '#tbody-capitulos' ).append('<tr class="cap-celeste"><td>'+parametros[1]+'</td><td><button type="button" class="btn btn-success">Descargar</button></td><td><button id="btn-vw'+parametros[1]+'" onclick="Change_Btn('+parametros[1]+')"	type="button" class="btn btn-secondary">No visto</button></td></tr>');
				parametros[1]--;
			}
			for(i=parametros[0] - 1;i>0;i--){
				$( '#tbody-capitulos' ).append('<tr><td>'+i+'</td><td><button type="button" class="btn btn-primary" onclick="Ver_Capitulo('+i+')">Ver</button></td><td><button id="btn-vw'+i+'" onclick="Change_Btn('+i+')"	type="button" class="btn btn-secondary">No visto</button></td></tr>');
			}
		}else{
			er = parametros[parametros.length-1];
			er = er.split(';');
			Nombre = er[3];
			Ultimo = er[1];
			$( '#container-capitulos2' ).append('<div class="alert alert-primary" role="alert" style="text-align:center">'+er[3]+'</div>');
			if(er[2] == "0"){
				$( '#container-capitulos2' ).append('<div class="alert alert-danger" role="alert" style="text-align:center">Serie Finalizada</div>');
			}else{
				$( '#container-capitulos2' ).append('<div class="alert alert-success" role="alert" style="text-align:center">Proximo Episodio: '+er[2]+'</div>');
			}
			for(i=er[1]-1;i>=er[0];i--){
				$( '#tbody-capitulos' ).append('<tr class="cap-celeste"><td>'+i+'</td><td><button type="button" class="btn btn-success">Descargar</button></td><td><button id="btn-vw'+i+'" onclick="Change_Btn('+i+')"	type="button" class="btn btn-secondary">No visto</button></td></tr>');
			}
			for(i=er[0]-1;i>0;i--){
				if((parametros.slice(0, parametros.length -1)).indexOf(i.toString()) == "-1"){
					$( '#tbody-capitulos' ).append('<tr><td>'+i+'</td><td><button type="button" class="btn btn-primary"	onclick="Ver_Capitulo('+i+')">Ver</button></td><td><button type="button" id="btn-vw'+i+'" onclick="Change_Btn('+i+')"	 class="btn btn-secondary">No visto</button></td></tr>');
				}else{
					$( '#tbody-capitulos' ).append('<tr class="cap-celeste"><td>'+i+'</td><td><button type="button" class="btn btn-success">Descargar</button></td><td><button id="btn-vw'+i+'" onclick="Change_Btn('+i+')" type="button" class="btn btn-secondary">No visto</button></td></tr>')
				}
			}
		}
		for(i=1;i<=Ultimo;i++){
			if(localStorage[code+'_'+i] == 'true'){
				$('#btn-vw'+i).removeClass("btn-secondary");
				$('#btn-vw'+i).addClass("btn-primary");
				$('#btn-vw'+i).text('Visto');
			}
		}
	});
	function Ver_Capitulo(num){
		localStorage[code+'_'+num] = 'true';
		link = (localStorage.url).replace('\\','/')+'/'+Nombre+'/'+code+'_'+num+'.mp4';		 
		location.href = "view.php?link="+link+"&code="+code;
	}
	function Change_Btn(num){
		$( '#btn-vw'+num ).each(function (){
			if($(this).attr('class') == "btn btn-secondary"){
				$(this).removeClass("btn-secondary");
				$(this).addClass("btn-primary");
				$(this).text('Visto');
				localStorage[code+'_'+num] = 'true';
			}else{
				$(this).removeClass("btn-primary");
				$(this).addClass("btn-secondary");
				$(this).text('No visto');
				localStorage[code+'_'+num] = 'false';
			}
		});
	}
</script>
</html>