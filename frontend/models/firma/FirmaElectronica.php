<?php
/**
 * 
 * @filename FirmaElectronica.php
 * @abstract 
 * Contiene las funcionalidades relativas al firmado. Al estar orientado
 * a la funcionalidad del servidor, solo tiene sentido las funcionalidades
 * de firma asociadas por interoperatividad. 
 */
include_once "Exceptions.php";
/**
 * Contiene las funcionalidades relativas al firmado. Al estar orientado
 * a la funcionalidad del servidor, solo tiene sentido las funcionalidades
 * de firma asociadas por interoperatividad.
 *
 * @subpackage classes
 */
class FirmaElectronica {

    /**
     *
     * @param <String> $textoFirmado Firma del texto
     * @param <String> $texto Texto original que se ha firmado
     * @param <X509Cert> $x509cert Certificado X509 para la verificacion
     * @return <boolean> Exito de la verificacion
     */
    public function verificarFirma($textoFirmado, $texto, $x509cert) {      
        $ok=-1;
        // state whether signature is okay or not
        try {
            $ok = openssl_verify($texto, $textoFirmado, $x509cert, OPENSSL_ALGO_SHA1);
            
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
    
    public function verificarFirmaRaw($sig, $texto, $x509cert) {      
        $output = shell_exec("java -jar FrameworkCommander.jar --verifyraw \"" . $sig."\" --txt \"" . $texto."\" --cert \"" . $x509cert."\"");
        
        if (strlen(strstr($output,"SUCCESS"))>0)
            return true;
        else
            return false;
    }
    /**
     * Verifica un documento pdf firmado con PAdES
     * @param <String> $ficheroPDFFirmado Ruta del fichero que se quiere verificar
     * @return <boolean> Exito de la operacion
     */
    public function verificarFirmaPAdES($ficheroPDFFirmado) {

        $output = shell_exec("java -jar FrameworkCommander.jar --verify \"" . $ficheroPDFFirmado."\"");
        
        if (strlen(strstr($output,"SUCCESS"))>0)
            return true;
        else
            return false;
    }
}

?>
