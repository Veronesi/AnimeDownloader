<script type="text/javascript">
	IKA_SESION_NAME = localStorage.getItem('IKA_SESION_NAME');
	IKA_SESION_PDW = localStorage.getItem('IKA_SESION_PDW');
	IKA_SESION_SERVER = localStorage.getItem('IKA_SESION_SERVER');
	IKA_SESION_WORLD = localStorage.getItem('IKA_SESION_WORLD');
if(IKA_SESION_NAME && IKA_SESION_PDW && IKA_SESION_SERVER && IKA_SESION_WORLD){
	location.href = '/home.php';
}else{
	location.href = '/login.php';
}
</script>