<?php
namespace frontend\models\firma;
/**
 * 
 * @filename Exceptions.php
 *  Excepciones que permiten identificar los posibles errores del Framework
 */
use frontend\models\firma\Messages;

class UnknownException extends Exception {};
class RevokedException extends Exception {};
class ExceptionOpensslVerify extends Exception {};

class AutochequeoException extends Exception {};
class NoSSLClientException extends Exception {
    protected $message = Messages::EX_NOSSLCLIENTE;
};
?>
