<?php
/**
 * PHP version 7
 * @author	  @Fanaes.
 * @copyright   2017-2018 Free SoftWare.
 * @version	 1.0.0
 * @link		https://github.com/Veronesi/AnimeDownloader
 * @since	   12/01/2017
 */
include 'class/Regular.php';
include 'class/Main.php';
include 'class/Anime.php';

$url = $_POST['url'];
$Anime = new Main();
$Anime->Set_Direccion($url);
$Anime->ActualizarLista();
switch ($_POST['funcion']) {
	case 'ani_update_folders':
		$Anime->ListarAnimes();
		break;
	case 'listCap':
		$code = $_POST['code'];
		$Anime->ListarCapitulos($code);
		$Anime->UltimoCapitulo($code);
		break;
	case 'download':
		$capitulo = $_POST['capitulo'];
		$code = $_POST['code']; 
		$tmp = $_POST['tmp'];
		($Anime->BuscarAnime($code))->testDownload($Capitulo,$tmp);
		break;
	default:
		# code...
		break;
}