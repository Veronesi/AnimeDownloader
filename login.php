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
		<a class="navbar-brand" href="#">Data Ikariam</a>
	</nav>
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Iniciar Sesion</h5>
			</div>
			<div class="modal-body">
				<!-- Content -->
				<div class="container">
					<div class="row">
						<div class="input-group col-sm">
							<div class="input-group-prepend">
								<div class="input-group-text">@</div>
							</div>
							<input type="text" class="form-control" id="form-user" placeholder="Usuario" required>
			        <div class="invalid-feedback">
			          Por favor ingese un usuario.
			        </div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm">
							<input type="password" class="form-control" id="form-pwd" placeholder="Contraseña" required>
			        <div class="invalid-feedback">
			          Por favor ingese una contraseña.
			        </div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm">
							<select id="form-country" class="form-control" required>
								<option value="ar">Argentina</option>
								<option value="es">España</option>
								<option value="en">Inglaterra</option>
							</select>
						</div>
						<div class="col-sm">
							<select id="form-world" class="form-control" required>
								<option value="s1">Alpha</option>
								<option value="s2">Beta</option>
								<option value="s3">Gamma</option>
							</select>
						</div>
					</div>
				</div>
				<!-- /Content -->
			</div>
			<div class="modal-footer container row">
				<div class="col align-self-start" style="margin-top: 5px;margin-left: 25px;">
				 	<div class="form-check">
						<input type="checkbox" class="form-check-input" id="form-check-sesion-active">
						<label class="form-check-label" for="exampleCheck1">Mantener Sesion Activa</label>
					</div>
				</div>
				<div class="col align-self-end" style="text-align: right;">
				 	<button id="form-btn-send" type="button" class="btn btn-primary">Iniciar</button>
				</div>	
			</div>
		</div>
	</div>
</body>
	<script src="/js/jquery/jquery-3.3.1.js"></script>
	<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script src="js/bootstrap/bootstrap.min.js" type="text/javascript"></script>
	<script type="text/javascript">

		$("#form-btn-send").click(function() {
			if($("#form-user").val() == "" || $("#form-pwd").val() == ""){
				alert('faltan completar campos');
			}else{
				$.post( "/php/main.php", { IKA_SESION_NAME: $( "#form-user" ).val(), IKA_SESION_PDW: $( "#form-pwd" ).val(), IKA_SESION_SERVER: $( "#form-country" ).val(), IKA_SESION_WORLD: $( "#form-world" ).val(), value: 'IKA_SESION_NEW'}).done(function( data ) {
						if(data == 'IKA_SESION_TRUE'){
							localStorage.setItem('IKA_SESION_NAME', $( "#form-user" ).val());
							localStorage.setItem('IKA_SESION_PDW', $( "#form-pwd" ).val());
							localStorage.setItem('IKA_SESION_SERVER', $( "#form-country" ).val());
							localStorage.setItem('IKA_SESION_WORLD', $( "#form-world" ).val());
							location.href = '/home.php';
						}
						if(data == 'IKA_SESION_FALSE'){
							alert('Usuario desconocido o contraseña incorrecta.');
						}
				});
			}
		});
	</script>
</html>