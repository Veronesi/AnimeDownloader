<?php
class Anime{
	PUBLIC $Nombre;
	PUBLIC $Capitulo = array();
	PUBLIC $Codigo;

	function __construct($Nombre = '')
	{
		$this->Nombre = $Nombre;
		if(!file_exists($this->url . $Nombre))
			mkdir($this->url . $Nombre, 0777, true);
		
	}

	PUBLIC function LimpiarCapitulo()
	{
		
	}
}