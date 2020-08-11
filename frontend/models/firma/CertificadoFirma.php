<?php
namespace frontend\models\firma;
/**
 * 
 * @filename CertificadoFirma.php
 * La clase que obtiene los datos del certificado
 */

/**
 * @subpackage classes
 */
class CertificadoFirma {

    public function __construct(){

    }

    /**
     * Contenedor del String del certificado
     * @var String
     */
    private $x509cert;
    /**
     *  Nombre del propietario del certificado
     * @var String
     */
    private $nombre;
    /**
     *  Apellidos del propietario del certificado
     * @var String
     */
    private $apellidos;
    /**
     *  NIF del propietario del certificado
     * @var String
     */
    private $NIF;
    /**
     *  Serial NUmber del propietario del certificado
     * @var String
     */
    private $serialNumber;
    /**
     *  Issuer DN del propietario del certificado
     * @var String
     */
    private $issuerDN;
    /**
     *  Fecha desde la que es valido el certificado
     * @var date('Y-m-d H:i:s')
     */
    private $validFrom;
    /**
     *  Fecha hasta la que es valido el certificado
     * @var date('Y-m-d H:i:s')
     */
    private $validTo;

    /**
     * Constructor de la clase que representa un certificado X509
     * @param String $x509Cert String que representa el X509
     */
    function Certificado($x509Cert) {
        
        date_default_timezone_set('UTC');

        $this->x509cert = $x509Cert;
        $openssl_x509_parse = openssl_x509_parse($this->x509cert);
        $tArrayCertCN = explode(",", $openssl_x509_parse['subject']['CN']);
        $this->apellidos = $tArrayCertCN[0];
        $this->nombre = $openssl_x509_parse['subject']['GN'];
        $this->issuerDN = print_r($openssl_x509_parse['issuer'], true);
        $this->NIF = $openssl_x509_parse['subject']['serialNumber'];
        $this->serialNumber = $openssl_x509_parse['serialNumber'];
        $this->validFrom = date('Y-m-d H:i:s', $openssl_x509_parse['validFrom_time_t']);
        $this->validTo = date('Y-m-d H:i:s', $openssl_x509_parse['validTo_time_t']);
    }

    /**
     * Devuelve el certificado X509
     * @return String certificado X509 
     */
    function obtenerX509() {
        return $this->x509cert;
    }

    /**
     * Devuelve el Nombre del propietario del certificado
     * @return String
     */
    function obtenerNombre() {
        return $this->nombre;
    }

    /**
     * Devuelve los Apellidos del propietario del certificado
     * @return String
     */
    function obtenerApellidos() {
        return $this->apellidos;
    }

    /**
     * Devuelve el NIF del propietario del certificado
     * @return String
     */
    function obtenerNIF() {
        return $this->NIF;
    }

    /**
     * Devuelve el Serial Number del propietario del certificado
     * @return String
     */
    function obtenerSerialNumber() {
        return $this->serialNumber;
    }

    /**
     * Devuelve el IssuerDN del propietario del certificado
     * @return String
     */
    function obtenerIssuerDN() {
        return $this->issuerDN;
    }

    /**
     * Devuelve la fecha de vigencia del certificado
     * @return date('Y-m-d H:i:s')
     */
    function obtenerValidFrom() {
        return $this->validFrom;
    }
    
    /**
     * Devuelve la fecha de caducidad del certificado
     * @return date('Y-m-d H:i:s')
     */
    function obtenerValidTo() {
        return $this->validTo;
    }
}

?>
