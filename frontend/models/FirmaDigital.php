<?php

namespace frontend\models;
use yii\base\Model;
use yii\web\UploadedFile;

use Yii;

/**
 * This is the model class for table "firma_digital".
 *
 * @property int $idFirma
 * @property string|null $urlArchivo
 * @property string|null $urlClavePrivada
 * @property string|null $sig
 * @property string|null $passClavePrivada
 */
class FirmaDigital extends \yii\db\ActiveRecord
{

    public $archivo; 
    public $clavePrivada;
    public $clavePublica;
    public $sig; 

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'firma_digital';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clavePrivada'], 'file'],
            [['clavePublica'], 'file'],
            [['sig'], 'file'],
            [['archivo'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf'],
            
            [['passClavePrivada'], 'string', 'max' => 100]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idFirma' => 'Id Firma',
            'archivo' => 'Archivo del Certificado (extensión .pdf)',
            'clavePrivada' => 'Clave Privada (extensión .pem)',
            'clavePublica' => 'Clave Publica otorgada por el FIRMANTE (extensión .pem)',
            'sig' => 'Certificado HASH (extensión .sig)',
            'passClavePrivada' => 'Pass Clave Privada',
        ];
    }

    /**
     * Metodo para subir los archivos
     */
    public function upload()
    {

        $rutas = [];
        $carpeta = "certificados/". Yii::$app->user->identity->nombre . "-" . Yii::$app->user->identity->apellido . "-" . Yii::$app->user->identity->dni;

        // si no existe la carpeta personal del organizador, se crea :v 
        if (!file_exists($carpeta)) {
            mkdir($carpeta);
        }

        if ($this->validate()) {
            
            $fecha = date("Y-m-d-h-i-s");

            $rutas['archivo'] = $carpeta . "/". $this->archivo->baseName . "-" . $fecha .'.' . $this->archivo->extension;
            $rutas['clavePrivada'] = $carpeta . "/". $this->clavePrivada->baseName . '.' . $this->clavePrivada->extension;

            $this->archivo->saveAs($rutas['archivo']);
            $this->clavePrivada->saveAs($rutas['clavePrivada']);
            
            return $rutas;
        } else {
            return false;
        }
    }

    /**
     * Método para verificar certificado
     */
    public function beginVerify(){
        $rutas = [];

        $carpeta = "certificados/". Yii::$app->user->identity->nombre . "-" . Yii::$app->user->identity->apellido . "-" . Yii::$app->user->identity->dni;

        // si no existe la carpeta personal de la persona, se crea :v 
        if (!file_exists($carpeta)) {
            mkdir($carpeta);
        }

        //carpeta temporal donde se van a alojar los archivos para su verificación
        $carpetaTemp = "certificados/". Yii::$app->user->identity->nombre . "-" . Yii::$app->user->identity->apellido . "-" . Yii::$app->user->identity->dni . "/verificacion";
    

        // si no existe la carpeta de verificacion temporal del organizador, se crea :v 
        if (!file_exists($carpetaTemp)) {
            mkdir($carpetaTemp);
        }
        
        if ($this->validate()) {
            
            $fecha = date("Y-m-d-h-i-s");

            $rutas['archivo'] = $carpetaTemp . "/". $this->archivo->baseName . "-" . $fecha .'.' . $this->archivo->extension;
            $rutas['clavePublica'] = $carpetaTemp . "/". $this->clavePublica->baseName . '.' . $this->clavePublica->extension;
            $rutas['sig'] = $carpetaTemp . "/". $this->sig->baseName . '.' . $this->sig->extension;

            // guardado de los archivos en el servidor
            $this->archivo->saveAs($rutas['archivo']);
            $this->clavePublica->saveAs($rutas['clavePublica']);
            $this->sig->saveAs($rutas['sig']);
            
            return $rutas;
        } else {
            return false;
        }
    
    }
}
