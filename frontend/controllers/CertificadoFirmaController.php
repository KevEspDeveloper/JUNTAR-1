<?php

namespace app\controllers;
//uso de librería de firma digital
use frontend\models\firma\Autenticacion;
use frontend\models\firma\Autochequeo;
use frontend\models\firma\CertificadoFirma;
use frontend\models\firma\Exceptions;
use frontend\models\firma\FirmaElectronica;
use frontend\models\firma\Libreria;
use frontend\models\firma\Logger;
use frontend\models\firma\Messages;
use frontend\models\firma\Singleton;

use app\models\CertificadoFirma;
use yii\web\UploadedFile;


class CertificadoFirmaController extends \yii\web\Controller
{

    /**
     * Método para el formulario de firmar un certificado
     * FORMULARIO
     * 
     * @return mixed
     */
    public function actionFormFirmarCertificado($mensaje = null, $files = null){
        return $this->render('form-firmar-certificado', [
            'name' => 'Certificado',
            'mensaje' => $mensaje,
            'files' => $files
        ]);
    }


    /**
     * Subida del formulario con el archivo
     * 
     * @return mixed
     */
    public function actionSubir()
    {
     
     $model = new CertificadoFirma;
     $msg = null;
     
     if ($model->load(Yii::$app->request->post()))
     {
      $model->file = UploadedFile::getInstances($model, 'file');
   
      if ($model->file && $model->validate()) {
       foreach ($model->file as $file) {
        $file->saveAs('certificados/' . $file->baseName . '.' . $file->extension);
        $msg = "<p><strong class='label label-info'>Subida realizada con éxito</strong></p>";
       }
      }
     }
     return $this->render("form-firmar-certificado", ["model" => $model, "msg" => $msg]);
    }

    /**
     * Método de procesamiento de la firma del certificado
     * REQUEST
     * 
     * @return mixed
     */
    public function actionFirmaCertificado(){

        $mensaje = "";
        if (isset($_FILES)){

            error_reporting(E_ALL & ~E_NOTICE);
            ini_set("display_errors", 1);

            $target_path = "certificados/";
            $target_path = $target_path . basename( $_FILES['uploadedfile']);
            $archivo_upload = basename( $_FILES['uploadedfile']);
            if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
                //echo "El archivo ". basename( $_FILES['uploadedfile']['name']). " ha sido subido"."<br>";
                $mensaje = "El archivo ". $archivo_upload. " ha sido firmado y subido!<br>";
            }else{
                //echo "Ha ocurrido un error, trate de nuevo!"."<br>";
                $mensaje = "Ha ocurrido un error al subir el archivo ".$_FILES['uploadedfile'].", trate de nuevo!"."<br>";
            }

                $target_path = "./";
                $target_path = $target_path . basename( $_FILES['uploadedprivkey']);
                $llave_privada = basename( $_FILES['uploadedprivkey']);
                if(move_uploaded_file($_FILES['uploadedprivkey'], $target_path)) {
                    echo "El archivo ". basename( $_FILES['uploadedprivkey']). " ha sido subido"."<br>";
                    $mensaje .= "<br> El archivo ". $llave_privada. " ha sido subido"."<br>";
                }else{
                    echo "Ha ocurrido un error, trate de nuevo!"."<br>";
                    $mensaje .= "<br> Ha ocurrido un error al subir la clave privada, trate de nuevo!"."<br>";
                }

                $pass_llave = $_POST['uploadedpassword'];

        }else{
            $mensaje = "NO se han enviado los datos correctamente.";
        }
                    
        
                //echo "el password es:".$pass_llave."<br>";
                    
                //************* empezamos la verificacion **************************
                /*$Libreria = new Libreria();
                    
                $fileIn1 = fopen($archivo_upload,"r");
                $fileIn = "";
                
		    while(!feof($fileIn1)) {
		        $fileIn.=fgets($fileIn1);
		    }
		    fclose($fileIn1);
		    //echo "archivo: ".$fileIn."<br>";
		
		    $privKey1 = fopen($llave_privada,"r");
		    $privKey = "";
		    while(!feof($privKey1)){
		        $privKey.=fgets($privKey1);
		    }
		    fclose($privKey1);
		    echo "archivo: ".$privKey."<br>";                  
                    
            $sig = $Libreria->firmarBinario($fileIn,$privKey);
                    
            //echo " ".$sig."<br>";
                    
            $firmadoSig = fopen("certificado.sig","a");
            fwrite($firmadoSig,$sig);
                    
            fclose($firmadoSig);
                    
            //shell_exec("openssl dgst -c -sign uploads/".$llave_privada." -out uploads/filefirmado.sig uploads/".$archivo_upload);
            echo "<h4 style='color: blue;'>Archivo Firmado</h4>"."<br>";
            echo $firmadoSig;

                    
            /*
            CLAVE PUBLICA
            echo "<br> <br>";
            $details = openssl_pkey_get_details($resourceNewKeyPair);
            $publicKeyPem = $details['key'];
            echo $publicKeyPem;
            
            //$salida = shell_exec('ls -lart');
            //echo "<pre>$salida</pre>";
            echo "<a href='./certificado.sig'> Archivo Con La Firma</a>";
            echo "<a href='./".$archivo_upload."'> Tu Archivo </a>";*/

            $this->redirect(["certificado/form-firmar-certificado", "mensaje" => $mensaje, 'files' => $_FILES]);
    }
}
