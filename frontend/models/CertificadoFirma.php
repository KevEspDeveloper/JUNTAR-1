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
        ];
    }
}
