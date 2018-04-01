<?php
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