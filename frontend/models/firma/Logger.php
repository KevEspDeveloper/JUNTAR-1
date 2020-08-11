<?php

namespace frontend\models\firma;

/**
 * 
 * @filename Logger.php
 * Enviar logs al sistema. 
 */
use frontend\models\firma\Singleton;
use frontend\models\firma\Messages;

class Logger extends Singleton {
    const INFO = "2";
    const ERROR = "3";
    const DEBUG = "1";

    function log ($msg, $level)
    {
        date_default_timezone_set('UTC');
        $date = date('d.m.Y h:i:s');
        $log = $date." ".$msg."\n";


        switch ($level)
        {
            case Logger::INFO:
                $log = Messages::LOG_INFO.$log;
                break;
            case Logger::ERROR:
                 $log = Messages::LOG_ERROR.$log;
                break;
            case Logger::DEBUG:
                 $log = Messages::LOG_DEBUG.$log;
                break;
        }

        error_log($log);

    }
}
?>
