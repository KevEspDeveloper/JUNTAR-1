<?php
/**
 * 
 * @filename Autochequeo.php
 * @abstract 
 * La clase autocheque contiene las caracteristicas correspondientes al
 * autochequeo del sistema.
 */
include_once 'Exceptions.php';
include_once 'Logger.php';

/**
 * La clase autocheque contiene las caracteristicas correspondientes al
 * autochequeo del sistema.
 * @subpackage classes
 */
class Autochequeo {

    /**
     * Comprobar Sistema analizara el correcto funcionamiento del sistema.
     * Emitira las excepciones correspondientes.
     *
     * @throws AutochequeoException
     *
     */
    public static function comprobarSistema() {

        if (strnatcmp(phpversion(),'5.3') < 0)
        {
            Logger::getInstance()->log("Versión de PHP inferior a 5.3: ".phpversion(), Logger::ERROR);
            throw new AutochequeoException("Versión de PHP inferior a 5.3");
        }
        if (!function_exists('openssl_open')) {
            Logger::getInstance()->log("No se encuentra openssl, debe instalarse la libreria en PHP (comprueba extensiones en php.ini).", Logger::ERROR);
            throw new AutochequeoException("No se encuentra openssl, debe instalarse la libreria en PHP (comprueba extensiones en php.ini).");
        }
    }
}

?>
