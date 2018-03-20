<?php
    class regular
    {
        public static function EstadoSesion()
        {
            /*
                 Verdadero si encontro algo.
            */
            return "/(Wrong\suser\sname\sor\swrong\spassword)|(Your\ssession\shas\sexpired,\splease\slog\sin\sthrough\sthe\sstart\spage)|(por\sfavor\slogueate\sde\snuevo\sen)/i";
        }
        public static function Usuario()
        {
            /*
                1) Nombre de usuario.
            */
            return "/\"ownerName\":\"(.*)\",\"islandId\":/i";
        }
        public static function Isla()
        {
            /*
                1) Id de la isla.
            */
            return "/\"islandId\":\"(\d+)\"/i";
        }
        public static function Almacenamiento()
        {
            /*
                1) Capacidad de almacenamiento de una ciudad.
            */
            return "/js_GlobalMenu_max_wine\"\sclass=\"rightText\">\s+((?:\d+|,)*)\s+/i";
        }
        public static function Ciudad()
        {
            /*
                1) ID de la ciudad.
                2) Nombre de la ciudad.
                3) Coordenadas X de la ciudad.
                4) Coordenadas y de la ciudad.
                5) Bien de lujo de la ciudad.
            */
            return "/[{].\"id.\":(\d+).{2}\"name.\":.\"((?:\d|\w|\s)*).\".{2}\"coords.\":.\"\[(\d+):(\d+)\]\s.\"..\"tradegood.\":.\"(\d).\"/i";
        }
        public static function CiudadActual()
        {
            /*
                1) ID de la ciudad actual.
            */
            return "/currentCityId:\s(\d+),/i";
        }
        public static function Recursos()
        {
            /*
                1) Nombre de recurso.
                    0) wood.
                    1) wine.
                    2) marble.
                    3) ctystal.
                    4) sulfur.
                2) Cantidad en deposito.
            */
            return "/<td\sid=\"js_GlobalMenu_(\w+)_Total\"\sclass=\"rightText\">\s{25}((?:\d+|,)*)/i";
        }
        public static function ConsumoVino()
        {
            /*
                1)Cantidad de vino que se consume.
            */
            return "/js_GlobalMenu_WineConsumption\"\sclass=\"\w+\">\s+(\d+)\s+<.td>/";
        }
        public static function Felicidad()
        {
            /*
                1) Maxima poblacion posible de la ciudad.
                2) Felicidad gracias al consumo de vino.
                3) Poblacion de la ciudad.
                4) Feliciad de la ciudad.
            */
            return "/js_TownHallMaxInhabitants\":[{]\"text\"[:](\d+)[}].*js_TownHallSatisfactionOverviewWineBoniServeBonusValue\":[{]\"text\":\"[+](\d+)\".*js_TownHallSatisfactionOverviewOverpopulationMalusValue\":[{]\"text\":(\d+),.*js_TownHallHappinessLargeValue\":[{]\"text\":(-?\d+)[}]/i";
        }
        public static function Deposito()
        {
            /*
                Cantidad maxima de almacenamiento en una ciudad.
            */
            return "/js_GlobalMenu_max_wine\"\sclass=\"rightText\">\s+((?:\d+|,)*)\s+/i";
        }
        public static function Edificio()
        {
            /*
                1) Nombre del edificio.
                2) Posicion del edificio.
                3) Nivel del edificio.
            */
            return "/CityPosition\d+ScrollName\"\s(?:class=\".*\"\s)?\s(?:class=\".*\")?>\n\s{28}(.*)\s{28}[(]<span\sid=\"js_CityPosition(\d+)Level\">(\d+)?<\/span>[)]\s{25}/i";
        }
        public static function Barcos()
        {
            /*
                1) Cantidad de barcos Disponibles.
                2) Cantidad de barcos totales.
            */
            return "/js_GlobalMenu_freeTransporters\">(\d+)<.span>\s[(]<span\s{21}id=\"js_GlobalMenu_maxTransporters\">(\d+)<.span>[)]/i";
        }
    }
?>