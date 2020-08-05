<?php
/**
 * 
 * @filename Exceptions.php
 *  Excepciones que permiten identificar los posibles errores del Framework
 */
include_once 'Messages.php';

class UnknownException extends Exception {};
class RevokedException extends Exception {};
class ExceptionOpensslVerify extends Exception {};

class AutochequeoException extends Exception {};
class NoSSLClientException extends Exception {
    protected $message = Messages::EX_NOSSLCLIENTE;
};
?>
