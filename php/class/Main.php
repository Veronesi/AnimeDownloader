<?php
class Main{
	# Contiene la direcion actual del programa.
	PUBLIC $Direccion;
	# Contiene las clases de Anime.
	PUBLIC $Lista = array();
	# Recolecta los Animes que se encuentran descargados y que faltan descargar.
	PUBLIC function ActualizarLista(){
		# Almacen en crudo todas las carpetas.
		$ListaCarpetas =array();
		# Escaneamos los archivos y directorios que se encuentran en la directorio actual.
		foreach(scandir($this->Direccion) as $Carpeta){
			# Eliminamos los archivos excluyendo con los elementos que contiene un "." en su nombre.
			if(!strpos($Carpeta, ".")){
				# Al ser una carpeta lo agregamos en {ListaCarpetas}
				array_push($ListaCarpetas, $Carpeta);
			}
		}
		# Eliminamos los dos primeros elementos que son el "." y ".." .
		$ListaCarpetas = array_slice($ListaCarpetas, 2);
		# Recorremos los nombres de las carpetas para crear los animes.
		foreach ($ListaCarpetas as $Anime) {
			# Llamamos a la funcion para agregar un anime a la lista {Lista}
			self::AgregarAnime($Anime);
		}
	}
	PUBLIC function Set_Direccion($url){
		$this->Direccion = $url . "\\";
	}
	PUBLIC function AgregarAnime($Nombre){
		$Anime = new Anime($Nombre, $this);
		array_push($this->Lista, $Anime);
	}
	PUBLIC function array_search2($Nombre, $lista){
		$count = 0;
		foreach ($lista as $key) {
			if($Nombre == $key->Nombre){
				return $count;
			}
			$count++;
		}
	}
	PUBLIC function Descargar(){
		foreach ($this->Lista as $Anime) {
			$Porcentaje = round(15 * self::array_search2($Anime->Nombre, $this->Lista) / count($this->Lista));
			$Porcentaje = @str_pad("", $Porcentaje, "#");
		  #  print  "\r" . str_pad("[" . @str_pad($Porcentaje,  15, ".") . "] " . $Anime->Nombre, 79, " ");
			#print "\r\r" . str_pad($Anime->Nombre,79 ," ");
			# Descargamos primero los que fallaron en la descargar.
			if(count($Anime->Problemas)>0){
				foreach ($Anime->Problemas as $Capitulo) {
					$Anime->Descargar($Capitulo);
				}
			}
			# Para saber si debemos seguir buscando un capitulo o no.
			$SeguirBuscando = true;
			while($SeguirBuscando){
				$SeguirBuscando = $Anime->Descargar($Anime->Ultimo);
				$Anime->Ultimo++;
			}
		}
	   # print "\r" . str_pad("", 80, " ");
	}
	PUBLIC function ListarAnimes(){
		foreach ($this->Lista as $key) {
			preg_match("/(\d+)_\d+\.\w+/", $key->Capitulos[0],$M);
			print $key->Nombre .";". $M[1] . "|";
		}
	}
	PUBLIC function ListarCapitulos($code){
		foreach ($this->Lista as $key) {
		   preg_match("/(\d+)_\d+\.\w+/", $key->Capitulos[0],$M); 
		   if($M[1] == $code){
				foreach ($key->Problemas as $key2) {
					print $key2."|";
				}
				print $key->Ultimo;
		   }
		}
	}
	PUBLIC function UltimoCapitulo($code){
		foreach ($this->Lista as $key) {
			preg_match("/(\d+)_\d+\.\w+/", $key->Capitulos[0],$M); 
			if($M[1] == $code){
				$dom = file_get_contents('http://animeflv.net/anime/159/'.$key->Nombre);
				#$dom = file_get_contents('http://animeflv.net/anime/159/'.strtr($key->Nombre, array(" " => "-")));
				preg_match(Regular::UltimoCapitulo(), $dom,$M);
				print ";".$M[1];
				if(preg_match(Regular::ProximoCapitulo(), $dom,$N)){
					print ";".$N[1];
				}else{
					print ";0";
				}
				print ";".$key->Nombre;
			}
		}
		/*
		$dom = file_get_contents('http://animeflv.net/anime/123/'.$code);
		preg_match(Regular::UltimoCapitulo(), $dom,$M);
		print ";".$M;
		if(preg_match(Regular::ProximoCapitulo(), $dom,$N)){
			print ";".$N;
		}else{
			print ";0";
		}
		*/
	}
	PUBLIC function BuscarAnime($code){
		foreach ($this->Lista as $key) {
			if($key->getCode() == $code){
				return $key;
			}
		}
	}
}
?>