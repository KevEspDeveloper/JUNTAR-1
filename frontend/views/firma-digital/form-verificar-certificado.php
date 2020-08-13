<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Presentacion */
/* @var $form yii\widgets\ActiveForm */

$this->title = "Verificar Certificado";

?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Verificación Firma Digital Certificado</title>


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
                <h2 class="text-center text-white">Verificación de un Certificado</h2>
            </div>
            <div class="card-body">

            <div class='row'>
            
                <div class="col-sm-12">

    <!-- begin Formulario -->

                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

                    <?= '<div class="form-group">'?>
                    <?= $form->field($model, 'archivo')->fileInput(['class' => 'form-control', 'required' => true]) ?>
                    <?= '</div>' ?>

                    <?= '<div class="form-group">'?>
                    <?= $form->field($model, 'sig')->fileInput(['class' => 'form-control', 'required' => true]) ?>
                    <?= '</div>' ?>

                    <?= '<div class="form-group">'?>
                    <?= $form->field($model, 'clavePublica')->fileInput(['class' => 'form-control', 'required' => true]) ?>
                    <?= '</div>' ?>

                    <?= Html::submitInput('Verificar Certificado', ['class' => 'btn btn-default my-2 py-3']) ?>

                    <?php ActiveForm::end() ?>
                    <!-- fin Formulario -->


                    <p class="text-center">
                        <?php 
                        echo $msg;
                        ?>   
                    </p>

                    <!-- -->
                </div>           

            </div>
            </div>
    </div>

    <div class="container text-center my-3">
        <?= Html::a(' <i class="material-icons" style="padding-top:7px; padding-right: 5px;">picture_as_pdf</i>Instructuvo para el Usuario', '../certificados/Firma-Digital-en-Juntar.pdf', ['class' => 'text-light btn my-2']) ?>
    </div>
</div>
</body>