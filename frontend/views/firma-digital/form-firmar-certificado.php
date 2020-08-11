<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Presentacion */
/* @var $form yii\widgets\ActiveForm */

$this->title = "Firmar Certificado";

?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Firma Digital Certificado</title>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- /.container -->
<div class="container text-center my-5 pt-5">
    

    <div class="card">
            <div class="card-header pinkish_bg">
                <h2 class="text-center text-white">Firma de un Certificado</h2>
            </div>
            <div class="card-body">

            <div class='row'>
            
                <div class="col-sm-12">

    <!-- begin Formulario -->

                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

                    <?= $form->field($model, 'idFirma')->hiddenInput(['value' => '1'])->label(false); ?>
                    <?= $form->field($model, 'sig')->hiddenInput(['value' => '1'])->label(false); ?>

                    <?= '<div class="form-group">'?>
                    <?= $form->field($model, 'archivo')->fileInput(['class' => 'form-control']) ?>
                    <?= '</div>' ?>

                    <?= '<div class="form-group">'?>
                    <?= $form->field($model, 'clavePrivada')->fileInput(['class' => 'form-control']) ?>
                    <?= '</div>' ?>

                    <?= '<div class="form-group">'?>
                    <?= $form->field($model, 'passClavePrivada')->textInput(['class' => 'form-control', 'placeholder' => 'Ingrese la contraseña de la clave privada (si no tiene contraseña, deje vacío este campo).']) ?>
                    <?= '</div>' ?>

                    <?= Html::submitInput('Firmar Certificado', ['class' => 'btn btn-default my-5 py-3']) ?>

                    <?php ActiveForm::end() ?>
                    <!-- fin Formulario -->


                    <p class="text-center">
                        <?php 
                        if (isset($msg)) {
                        ?>

                        <?= Html::a(' <i class="material-icons" style="padding-top:7px; padding-right: 5px;">get_app</i>¡Descargue su certificado!', [$msg['sig']], ['class' => 'text-light btn']) ?>
                        
                        <?php
                        }
                        ?>   
                    </p>

                    <!-- -->
                </div>           

            </div>
            </div>
    </div>
</div>
</body>