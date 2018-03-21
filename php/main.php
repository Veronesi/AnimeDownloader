<?php
/**
 * PHP version 7
 * @author      @Fanaes.
 * @copyright   2017-2018 Free SoftWare.
 * @version     1.0.0
 * @link        https://github.com/Veronesi/AnimeDownloader
 * @since       12/01/2017
 */
class Regular{
        PUBLIC STATIC function ProximoCapitulo()
        {
            return "/Date\sfa\-calendar\">(\w+\-\w+\-\w+)<\/span>/";
        }
        PUBLIC STATIC function UltimoCapitulo()
        {
            return "/<a\shref=\"\/ver\/\w+\/(?:\w+|\-)*\-(\d+)\">/";
        }
        PUBLIC STATIC function NumeroCapitulo()
        {
            /*
                Devuelve el numero de capitulo.
            */
            return "/\d+[_](\d+)/i";
        }
        PUBLIC STATIC function LinkZippyshare()
        {
            /*
                Devuelve el url de descarga de un capitulo.
            */
            return "/(www(\d+)[.]zippyshare[.]com[%]2Fv[%]2F(\w+)[%]2Ffile[.]html)/i";
        }       
        PUBLIC STATIC function LinkDescargaZippyshare()
        {
            /*
                Devuelve el link de descarga del archivo que genera Zippyshare.
            */
            return "/(\w+).(\w+).\"[+]a[+]\".(\w+.mp4)/i";
        }
        PUBLIC STATIC function DividendoZippyshare()
        {
            /*
                Devuelve el link de descarga del archivo que genera Zippyshare.
            */
            return "/var\sa\s=\s(\d+)[%](\d+)/i";
        }
        PUBLIC STATIC function FormulaZippy()
        {
            return "/.(\w+).(\w+).\"\s[+]\s[(]((?:\d+)\s.\s(?:\d+)(?:\s.\s(?:\d+))*)[)]\s[+]\s\".((?:\d+)[_](?:\d+).mp4)/i";
        }   
        /*************** Para la forma Math.pow(a, 3)+b ***************/
        PUBLIC STATIC function Zippy_valA()
        {
            /*
                Devuelve el valor de a.
            */
            return "/var\sa\s=\s(\d+);/i";
        }
        PUBLIC STATIC function Zippy_valB()
        {
            /*
                Devuelve el valor de b sin procesar M[2] - M[1] .
            */
            return "/document\.getElementById\(\'dlbutton\'\)\.omg\s=\s\"asdasd\"\.substr\((\d+),\s(\d+)\);/i";
        }
        PUBLIC STATIC function FormulaZippy2()
        {
            return "/document\.getElementById\(\'dlbutton\'\)\.href\s=\s\"\/(\w)\/(\w+)\/\"\+\((Math\.pow\(\w,\s\w\)\+\w)\)\+\"\/(\d+\_\d+\.mp4)/i";
        }   

}
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
                $dom = file_get_contents('http://animeflv.net/anime/159/'.strtr($key->Nombre, array(" " => "-")));
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
}
class Anime{
    PRIVATE $Main;
    PUBLIC $Nombre;
    # Contador utlizado para saber desde que capitulo debemos analizar.
    PUBLIC $Ultimo=1;
    # Capitulos que tubieron problemas.
    PUBLIC $Problemas = array();
    PUBLIC $Capitulos = array();
    PUBLIC $Direccion;
    # Constructor.
    function __construct($Nombre, $Main){
        $this->Main = $Main;
        $this->Nombre = $Nombre;
        $this->Direccion= $Main->Direccion . $Nombre . "\\";
        self::ActualizarAnime();
    }
    PUBLIC function ActualizarAnime(){
        # Escaneamos los archivos que se encuentran en el directorio del anime.
        $ListaCapitulos = scandir($this->Direccion);
        # Organizamos los capitulo para que por ej este  el 2 antes que el 100.
        sort($ListaCapitulos, SORT_NATURAL | SORT_FLAG_CASE);
        # Por defecto ponemos como q solo existe el capitulo 0.
        $Ultimo= "123_0.mp4";
        $Contador=1;
        foreach($ListaCapitulos as $Capitulo){
            # Verificamos si el archivo obtenido es un mp4 [Por razones de compativilidad].
            if(strpos($Capitulo, ".mp4")){
                $Numero = explode("_", $Capitulo);
                while($Contador < $Numero[1]){
                    array_push($this->Problemas, $Contador);
                    $Contador++;
                }
                array_push($this->Capitulos, $Capitulo);
                # Si pesa mas de 1MB sabemos que el el episodio se descargo bien, lo almacenamos asumiendo que es el ultimo capitulo que se descargo correctamente.
                if(filesize($this->Direccion . $Capitulo) > 122880){
                    $Ultimo = $Capitulo;
                }else{
                    # obviamente ubo un error al descargar este capitulo.
                    if(preg_match(Regular::NumeroCapitulo(), $Capitulo, $M)){
                        array_push($this->Problemas, $M[1]);
                    }                   
                }
                $Contador++;
            }
        }
        # Utilizamos un if en el caso de que haya un archivo extraño
        if(preg_match(Regular::NumeroCapitulo(), $Ultimo, $M)){
            # Sumamos uno ya que ese captiulo ya lo tenemos.
            $this->Ultimo = $M[1] +1;
        }
    }
    PUBLIC function Descargar($Capitulo){
        # Nos fijamos si existe ese capitulo.
        # Usamos 159 ya que es indistinto el numero de carpeta.
        # Usamos @ ya que cuando lleguemos al capitulo que no existe nos va a tirar un E_WARNING.
        if(preg_match(Regular::LinkZippyshare(), @file_get_contents("http://animeflv.net/ver/159/" . strtr($this->Nombre, array(" " => "-")) . "-" . $Capitulo), $M)){
            # Nos fijamos si el link esta roto.
            $DOM_zippyshare = @file_get_contents("http://" . strtr($M[1], array("%2F" => "/")));
            /*
            # Obsoleto

            $rta_LinkDescargaZippyshare = preg_match(Regular::LinkDescargaZippyshare(), $DOM_zippyshare, $LinkDescarga);
            $rta_DividendoZippyshare = preg_match(Regular::DividendoZippyshare(), $DOM_zippyshare, $Dividendo);
            $rta_FormulaZippy = preg_match(Regular::FormulaZippy(), $DOM_zippyshare, $Formula);

            if($rta_FormulaZippy){
                eval("\$Resultado = $Formula[3];");
                print str_pad("\rCapitulo " . $Capitulo . " : Descargando",79," ");
                $f = fopen($this->Direccion . $Formula[4], 'w');
                fwrite($f , "");
                fclose($f);
                $f = fopen($this->Direccion . $Formula[4], 'a');
                $file = fopen("http://www" . $M[2] . ".zippyshare.com/" . $Formula[1] . "/" . $Formula[2] . "/" . $Resultado . "/" . $Formula[4], "r");
                $count = 1;
                $size = @array_change_key_case(get_headers("http://www" . $M[2] . ".zippyshare.com/" . $Formula[1] . "/" . $Formula[2] . "/" . $Resultado . "/" . $Formula[4], 1),CASE_LOWER)['content-length'];
                
                while (($buffer = fgets($file)) !== false){     
                    fwrite($f, $buffer);
                    if($count%300==0){
                        clearstatcache();
                        $Porcentaje = @round(50 * filesize($this->Direccion . $Formula[4]) / $size);
                        $Porcentaje = @str_pad("", $Porcentaje, "#");
                        print  "\rDescargando [" . @str_pad($Porcentaje,  50, ".") . "]";
                    }
                    $count++;
                }
                fclose($file);
                fclose($f);

            }
            */
            preg_match(Regular::Zippy_valA(), $DOM_zippyshare, $val_a);
            preg_match(Regular::Zippy_valB(), $DOM_zippyshare, $val_b);
            $rta_FormulaZippy = preg_match(Regular::FormulaZippy2(), $DOM_zippyshare, $Formula);
            if($rta_FormulaZippy){
                $a = $val_a[1];
                $b = $val_b[2] - $val_b[1];
                $function = str_replace('Math.pow', 'pow',$Formula[3]);
                $function = str_replace('a', '$a',$function);
                $function = str_replace('b', '$b',$function);
                eval('$function = '.$function.';');
                $f = fopen($this->Direccion . $Formula[4], 'w');
                fwrite($f , "");
                fclose($f);
                $f = fopen($this->Direccion . $Formula[4], 'a');
                $file = fopen("http://www". $M[2] .".zippyshare.com/". $Formula[1] ."/". $Formula[2] ."/". $function ."/". $Formula[4], "r");
                $count = 1;
                $size = @array_change_key_case(get_headers("http://www". $M[2] .".zippyshare.com/". $Formula[1] ."/". $Formula[2] ."/". $function ."/". $Formula[4], 1),CASE_LOWER)['content-length'];
                while (($buffer = fgets($file)) !== false){     
                    fwrite($f, $buffer);
                    if($count%300==0){
                        clearstatcache();
                        $Porcentaje = @round(50 * filesize($this->Direccion . $Formula[4]) / $size);
                        $Porcentaje = @str_pad("", $Porcentaje, "#");
                       # print  "\rDescargando [" . @str_pad($Porcentaje,  50, ".") . "]";
                    }
                    $count++;
                }
                fclose($file);
                fclose($f);
            }
        }else{
            # Ya se descargo el ultimo capitulo.
            return false;
        }
        return true;
    }
}
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
    default:
        # code...
        break;
}
