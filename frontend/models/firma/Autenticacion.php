<?php

/**
 * 
 * @filename Autenticacion.php
 * Clase que contiene las funcionalidades de autenticacion
 * En principio la version php se base en el uso de servidor web
 * y el certificado del dnie como mecanimos de autenticacion.
 * Estas funciones estan presentes de cara a interoperatividad con
 * el resto de entornos.
 */

include_once 'Exceptions.php';

/**
 * Clase que contiene las funcionalidades de autenticacion
 * En principio la version php se base en el uso de servidor web
 * y el certificado del dnie como mecanimos de autenticacion.
 * Estas funciones estan presentes de cara a interoperatividad con
 * el resto de entornos.
 * @subpackage classes
 */
class Autenticacion {

    /**
     *
     * @param <String> $retoFirmado La firma del reto a verificar
     * @param <String> $reto El reto original
     * @param <X509Cert> $x509cert El certificado X509
     * @return <boolean> success El exito de la operacion
     */
    public function comprobarRetoFirmado($retoFirmado, $reto, $x509cert) {
        
        $ok=-1;
        // state whether signature is okay or not
        try {
            $ok = openssl_verify($reto, $retoFirmado, $x509cert, OPENSSL_ALGO_SHA1);
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

        
        if ($ok == 1) {
            return true;

        } elseif ($ok == 0) {
            return false;
        } else {
            throw new ExceptionOpensslVerify("Problema desconocido verificando firma");
        }

    }

}
?>
