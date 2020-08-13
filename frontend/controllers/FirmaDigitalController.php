<?php

namespace frontend\controllers;
use Yii;
use frontend\models\FirmaDigital;
use yii\web\UploadedFile;
use frontend\models\firma\Libreria;

use frontend\models\Evento;
use frontend\models\Inscripcion;

class FirmaDigitalController extends \yii\web\Controller
{
    /**
     * Método para el formulario de firmar un certificado
     * FORMULARIO
     * 
     * @return mixed
     */
    public function actionFormFirmarCertificado($msg = null, $model = null){

        $model = new FirmaDigital();
        $rutas = null;

        if (Yii::$app->request->isPost) {
            $model->archivo = UploadedFile::getInstance($model, 'archivo');
            $model->clavePrivada = UploadedFile::getInstance($model, 'clavePrivada');

            $rutas = $model->upload();

            if ($rutas != false) {
                // el archivo se subió exitosamente
            
                $Libreria = new Libreria();
                        
                $fileIn1 = fopen($rutas['archivo'],"r");
                $fileIn = "";
                
                while(!feof($fileIn1)) {
                    $fileIn.=fgets($fileIn1);
                }
                fclose($fileIn1);
                //echo "archivo: ".$fileIn."<br>";
            
                $privKey1 = fopen($rutas['clavePrivada'],"r");
                $privKey = "";
                while(!feof($privKey1)){
                    $privKey.=fgets($privKey1);
                }
                fclose($privKey1);
                //echo "archivo: ".$privKey."<br>";                  
                        
                /* la gran firma */
                $sig = $Libreria->firmarBinario($fileIn,$privKey);
                        

                $fecha = date("Y-m-d-h-i-s");
                $carpetaPersonal = Yii::$app->user->identity->nombre . "-" . Yii::$app->user->identity->apellido . "-" . Yii::$app->user->identity->dni;
                        
                $firmadoSig = fopen("certificados/" . $carpetaPersonal . "/certificado-".$fecha.".sig" ,"a");
                fwrite($firmadoSig,$sig);
                        
                fclose($firmadoSig);

                //eliminación del archivo de  clave privada por SEGURIDAD
                unlink($rutas['clavePrivada']);

                $rutas['sig'] = "certificados/" . $carpetaPersonal . "/certificado-".$fecha.".sig";

                $msg = $rutas;
            }else{
                $msg = $model->errors;
            }
        }

        return $this->render('form-firmar-certificado', [
            'name' => 'Certificado',
            'msg' => $msg,
            'model' => $model
        ]);
    }


    /**
     * Método para el formulario de verificar un certificado
     * FORMULARIO
     * 
     * @return mixed
     */
    public function actionFormVerificarCertificado($msg = null, $model = null){

        $model = new FirmaDigital();
        $rutas = null;

        if (Yii::$app->request->isPost) {

            $model->archivo = UploadedFile::getInstance($model, 'archivo');
            $model->sig = UploadedFile::getInstance($model, 'sig');
            $model->clavePublica = UploadedFile::getInstance($model, 'clavePublica');

            $rutas = $model->beginVerify();

            if ($rutas != false) {
                //los archivos se subieron correctamente
			
			//************* empezamos la verificacion **************************//
    		    $Libreria = new Libreria();
			
                $binari1 = fopen($rutas['sig'], "r");
                $binari = "";
                while(!feof($binari1)) {
                    $binari.=fgets($binari1);
                }
                fclose($binari1);
                //echo "archivo: ".$binari."<br>";
                
                $fileIn1 = fopen($rutas['archivo'],"r");
                $fileIn = "";
                while(!feof($fileIn1)) {
                    $fileIn.=fgets($fileIn1);
                }
                fclose($fileIn1);
                //echo "archivo: ".$fileIn."<br>";
            
                $publicKey1 = fopen($rutas['clavePublica'],"r");
                $publicKey = "";
                while(!feof($publicKey1)){
                    $publicKey.=fgets($publicKey1);
                }
                fclose($publicKey1);
                //echo "archivo: ".$publicKey."<br>";        
            
                /*$starttime_ver = microtime();
                $startarray_ver = explode(" ", $starttime_ver);
                $starttime_ver = $startarray_ver[1] + $startarray_ver[0];*/

                if ($Libreria->verificarFirma($binari, $fileIn, $publicKey)) {
                    $msg = " <div class='alert alert-success py-5' role='alert'>
                    <strong>¡Legítimo!</strong> El certificado es auténtico.
                    </div>
                    ";
                } else {
                    $msg = " <div class='alert alert-danger py-5' role='alert'>
                    <strong>¡Vulnerado!</strong> El certificado fue modificado y no es auténtico.
                    </div>
                    ";
                }	

            }else{
                $msg = " <div class='alert alert-warning py-5' role='alert'>
                    <strong>Error!</strong> No se pudo hacer la verificación. Intente nuevamente.
                    <p>Si el error persiste, por favor <a href='../site/contact'>Contáctenos</a> </p>
                    </div>
                    ";
            }

        }

        return $this->render('form-verificar-certificado', [
            'name' => 'Certificado',
            'msg' => $msg,
            'model' => $model
        ]);
    }


    /**
     * Función que sirve para verificar si un usuario registrado ha creado al menos 1 evento en el sitio
     * @param boolean $flag
     * 
     * @return mixed
     */
    public function organizoAlgunEvento($idUsuario){

        $flag = false;

        // se buscará algún evento que haya organizado el usuario y que se encuentre finalizado.
        $flag = Evento::findOne(['idUsuario' => $idUsuario, 'idEstadoEvento' => 3]);

        return $flag;
    }

    /**
     * Función que sirve para verificar si un usuario registrado ha participado en al menos 1 evento en el
     * sitio y si ha finalizado
     */
    public function participoEnAlgunEvento($idUsuario){

        $flag = false;

        // se buscará algún evento en el que haya participado el usuario
        $flag = Inscripcion::findOne(['idUsuario' => $idUsuario, 'estado' => 1, 'acreditacion' => 1]);

        return $flag;

    }

   
}
