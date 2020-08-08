<?php

use yii\bootstrap4\ActiveForm;
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
    
    <title>Firma Digital - ADSIB</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/firmas.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- /.container -->
<div class="container text-center">
    

    <div class="card">
            <div class="card-header pinkish_bg">
                <h2 class="text-center text-white">Firma de un Certificado</h2>
            </div>
            <div class="card-body">

            <div class='row'>
            
            <div class="col-sm-12">
                <p>Firma un archivo en cualquier formato, usando una llave publica y un archivo con la firma.</p>

                <hr>

                <!-- -->

                <?php /*Html::beginForm(
                    Url::toRoute("certificado/firma-certificado"), //action
                    "post", //method
                    ['class' => 'form'] //options
                );*/
                ?>

                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'enableClientValidation' => true,
                    'options' => ['enctype' => 'multipart/form-data'],
                ]);

                ?>

                <?= $form->field($model, 'file[]')->fileInput(['multiple' => false]) ?>

                <div class="form-group">
                    <?= Html::label('Archivo', 'inputFile') ?>
                    <?= Html::fileInput('uploadedfile', null, ['class' => 'form-control', 'required' => true]) ?>
                </div>

                <div class="form-group">
                    <?= Html::label('Clave Privada', 'uploadedprivkey') ?>
                    <?= Html::fileInput('uploadedprivkey', null, ['class' => 'form-control', 'required' => true]) ?>
                </div>

                <div class="form-group">
                    <?= Html::label('Contraseña de la clave privada', 'inputPassword') ?>
                    <?= Html::passwordInput('uploadedpassword', null, ['class' => 'form-control', 'id' => 'inputPassword', 'placeholder' => 'Ingrese la contraseña de la clave privada (si no tiene contraseña, deje vacío este campo).']) ?>
                </div>

                <?= Html::submitInput('Firmar Certificado', ['class' => 'btn btn-default my-5 py-3']) ?>

                <?= Html::endForm() ?>


                <p class="text-center">
                    <?= $mensaje ?>

                    <?php
                    /*for ($i=0; $i < count($datos); $i++) { 
                        echo "<br>".$datos[$i];
                    }*/
                    print_r($_FILES);
                    ?>
                </p>

                <!-- -->
            </div>           


            </div>
    </div>
</div>

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>
