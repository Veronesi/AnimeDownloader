<?php
/**
 * PHP version 7
 * @author      @Fanaes.
 * @copyright   2017-2018 Free SoftWare.
 * @version     1.0.1
 * @link        https://github.com/Veronesi/AnimeDownloader
 * @since       12/01/2017
 */
$servername = "localhost";
$username = "root";
$password = "123456789";
$conn = new mysqli($servername, $username, $password);

class Anime{
	PUBLIC $Nombre;
	PUBLIC $Capitulo = array();
	PUBLIC $Codigo;

	function __construct($Nombre = '')
	{
		$this->Nombre = $Nombre;
		if(!file_exists($this->url . $Nombre))
			mkdir($this->url . $Nombre, 0777, true);
		$this->Codigo = self::CrearCodigo();
		self::EscanearCapitulos();
	}

	PUBLIC function LimpiarCapitulo()
	{
		$this->Capitulo = array();
	}

	PUBLIC function EscanearCapitulos()
	{
			
	}

	PUBLIC function CrearCodigo()
	{
		$scan = scandir($this->url . $Nombre);
		if(count($scan) == 2){
			# No se descargo ningun capitulo.
			
		}
	}
}