<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "certificado_firma".
 *
 * @property int $idFirma
 * @property int $idInscripcion
 * @property string|null $urlArchivo
 * @property string|null $urlClavePrivada
 * @property string|null $urlCertificado
 */
class CertificadoFirma extends \yii\db\ActiveRecord
{


    public $archivo;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'certificado_firma';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idFirma', 'idInscripcion'], 'required'],
            [['idFirma', 'idInscripcion'], 'integer'],
            [['urlArchivo', 'urlClavePrivada', 'urlCertificado'], 'string', 'max' => 200],
            ['archivo', 'archivo', 
            'skipOnEmpty' => false,
            'uploadRequired' => 'No has seleccionado ningún archivo', //Error
            'maxSize' => 1024*1024*1, //1 MB
            'tooBig' => 'El tamaño máximo permitido es 1MB', //Error
            'minSize' => 10, //10 Bytes
            'tooSmall' => 'El tamaño mínimo permitido son 10 BYTES', //Error
            'extensions' => 'pdf',
            'wrongExtension' => 'El archivo {archivo} no contiene una extensión permitida {extensions}', //Error
            'maxFiles' => 4,
            'tooMany' => 'El máximo de archivos permitidos son {limit}', //Error
            ];
    ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idFirma' => 'Id Firma',
            'idInscripcion' => 'Id Inscripcion',
            'urlArchivo' => 'Url Archivo',
            'urlClavePrivada' => 'Url Clave Privada',
            'urlCertificado' => 'Url Certificado',
            'archivo' => 'Seleccionar archivos:',
            
        ];
    }
}