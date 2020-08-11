<?php

namespace frontend\models;
use yii\base\Model;
use yii\web\UploadedFile;

use Yii;

/**
 * This is the model class for table "firma_digital".
 *
 * @property int $idFirma
 * @property int $idInscripcion
 * @property string|null $urlArchivo
 * @property string|null $urlClavePrivada
 * @property string|null $urlCertificado
 * @property string|null $passClavePrivada
 */
class FirmaDigital extends \yii\db\ActiveRecord
{

    public $archivo; 
    public $clavePrivada;
    public $certificado; 

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
            [['archivo'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf'],
            [['clavePrivada'], 'file', 'skipOnEmpty' => false],
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
            'archivo' => 'Archivo a firmar (extensión .pdf)',
            'clavePrivada' => 'Clave Privada (extensión .pem)',
            'certificado' => 'Certificado',
            'passClavePrivada' => 'Pass Clave Privada',
        ];
    }

    /**
     * Metodo para subir los archivos
     */
    public function upload()
    {

        $rutas = [];

        if ($this->validate()) {
            $this->archivo->saveAs("certificados/" . $this->archivo->baseName . '.' . $this->archivo->extension);
            $this->clavePrivada->saveAs("certificados/" . $this->clavePrivada->baseName . '.' . $this->clavePrivada->extension);
            
            $rutas['archivo'] = "certificados/" . $this->archivo->baseName . '.' . $this->archivo->extension;
            $rutas['clavePrivada'] = "certificados/" . $this->clavePrivada->baseName . '.' . $this->clavePrivada->extension;
            
            return $rutas;
        } else {
            return false;
        }
    }
}
