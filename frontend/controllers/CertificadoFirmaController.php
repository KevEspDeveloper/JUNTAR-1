<?php

namespace app\controllers;

class CertificadoFirmaController extends \yii\web\Controller
{
    public function actionFormFirmaCertificado()
    {
        return $this->render('form-firma-certificado');
    }

}
