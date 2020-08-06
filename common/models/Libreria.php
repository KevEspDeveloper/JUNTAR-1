<?php
namespace frontend\models;

namespace frontend\models\firma;
include_once '../models/firma/Autenticacion.php';
include_once '../models/firma/Autochequeo.php';
include_once '../models/firma/FirmaElectronica.php';
include_once '../models/firma/Exceptions.php';
include_once '../models/firma/CertificadoFirma.php';
include_once '../models/firma/Logger.php';


class Libreria{

    /**
     * Objeto que representa el componente de autenticacion del Framework
     * @access private
     * @var Autenticacion
     */
    private $autenticacion;
    /**
     * Objeto que representa el componente de autochequeo del Framework
     * @access private
     * @var Autochequeo
     */
    private $autochequeo;
    /**
     * Objeto que representa el componente de firmado del Framework
     * @access private
     * @var FirmaElectronica
     */
    private $firmaElectronica;
    /**
     * Objeto que representa el componente de autenticacion del Framework
     * @access private
     * @var CertificadoFirma
    */
    private $certificadoPublico;

    /**
     * Constructor del Framework. Lo inicializa y autochequea.
     */
    function __construct() {

        $this->autochequeo = new Autochequeo();
        $this->logger = Logger::getInstance();

        try {
            Autochequeo::comprobarSistema();
        } catch (AutochequeoException $ace) {
            $this->logger->log("Error al chequear el sistema", Logger::ERROR);
            die;
        }

        $this->autenticacion = new Autenticacion();
        $this->firmaElectronica = new FirmaElectronica();
    }

    /**
     * Comprueba que un reto ha sido firmado automaticamente.
     * @uses $Autenticacion
     * @param String $retoFirmado El reto firmado
     * @param String $reto  El reto antes de la firma
     * @param String $x509cert   El certificado publico del firmante
     * @return boolean Devuelve true si es una firmado valido
     *
     */
    function comprobarRetoFirmadoAutenticacion($retoFirmado, $reto, $x509cert) {
        return $this->autenticacion->comprobarRetoFirmado($retoFirmado, $reto, $x509cert);
    }

    /**
     * Verifica la firma de unos datos
     * @uses FirmaElectronica
     * @param String $datosFirmados El dato firmado
     * @param String $datos  El dato antes de la firma
     * @param String $x509cert   El certificado publico del firmante
     * @return boolean Devuelve true si es una firmado valido
     *
     */
    function verificarFirma($datosFirmados, $datos, $x509cert) {
        return $this->firmaElectronica->verificarFirma($datosFirmados, $datos, $x509cert);
    }
    
    public function verificarFirmaRaw($sig, $texto, $x509cert) { 
        return $this->firmaElectronica->verificarFirmaRaw($sig, $texto, $x509cert);
    }
    /**
     * Verfica la firma de un pdf
     * @uses FirmaElectronica
     * @param String $ficheroPDFFirmado Ruta del fichero a verificar
     * @return boolean Devuelve true si es una firmado valido
     *
     */
    function verificarFirmaPAdES($ficheroPDFFirmado) {
        return $this->firmaElectronica->verificarFirmaPAdES($ficheroPDFFirmado);
    }

    /**
     * Obtiene el certificado residente en el servidor. Requiere haber configurado
     * adecaudamente el Apache
     * @throws NoSSLClientException
     */
    function cargarCertificadoPublico1() {
        if (empty($_SERVER['SSL_CLIENT_CERT']))
            throw new NoSSLClientException;
        $this->certificadoPublico = new Certificado($_SERVER['SSL_CLIENT_CERT']);
    }
    
    /**
     * SOBRECARGA
     * para test unitarios, se peude pasar un certificado ya extraido o autogenerado
     * @throws NoSSLClientException
     */
    function cargarCertificadoPublico($x509cert) {
        if (empty($x509cert))
            throw new NoSSLClientException;
        $this->certificadoPublico = new Certificado($x509cert);
    }

    /**
     * Devuelve un Objecto Certificado que contiene el X509 y su información
     * asociada.
     * @return CertificadoFirma
     */
    function obtenerCertificadoPublico() {
        return $this->certificadoPublico;
    }

    /**
     * Obtiene el nombre del propietario del certificado
     * @return String Nombre
     */
    function obtenerNombre() {
        return $this->certificadoPublico->obtenerNombre();
    }

    /**
     * Obtiene el Apellido del propietario del certificado
     * @return String Apellido
     */
    function obtenerApellidos() {
        return $this->certificadoPublico->obtenerApellidos();
    }

    /**
     * Obtiene el NIF del propietario del certificado
     * @return String NIF
     */
    function obtenerNIF() {
        return $this->certificadoPublico->obtenerNIF();
    }

    /**
     * Obtiene el numero de serie del propietario del certificado
     * @return String NUmero de Serie
     */
    function obtenerSerialNumber() {
        return $this->certificadoPublico->obtenerSerialNumber();
    }

    /**
     * Obtiene el nombre el IssuerDN del certificado
     * @return String IssuerDN
     */
    function obtenerIssuerDN() {
        return $this->certificadoPublico->obtenerIssuerDN();
    }

    /**
     * Devuelve la fecha de vigencia del certificado
     * @return date('Y-m-d H:i:s')
     */
    function obtenerValidFrom() {
        return $this->certificadoPublico->obtenerValidFrom();
    }

    /**
     * Devuelve la fecha de caducidad del certificado
     * @return date('Y-m-d H:i:s')
     */
    function obtenerValidTo() {
        return $this->certificadoPublico->obtenerValidTo();
    }
    
     /**
     * Indica si el certificado es vigente en la actualidad
     * @return boolean Cierto si es vigente
     */
    function esVigente() {
        $hoy = strtotime(date('Y-m-d H:i:s'));
        $inicio = strtotime($this->obtenerValidFrom());
        $fin = strtotime($this->obtenerValidTo());
        return (($ini <= $hoy) && ($hoy <= $fin));
    }
    
    
    /**
     * firma un documento y genera un archivo en formato binario
     * @param <String> $fichero Ruta del fichero que se quiere verificar
     * @return <boolean> Exito de la operacion
     */
    function firmarBinario($fichero, $private_key) {
        
        $binary_signature = "";
        openssl_sign($fichero, $binary_signature, $private_key, OPENSSL_ALGO_SHA1);
        
        return ($binary_signature);
    }

    /**
     * Destructor del framework. Elimina y borra el sistema adecuadamente.
     * @return String Nombre
     */
    function __destruct() {
        
    }
}

?>