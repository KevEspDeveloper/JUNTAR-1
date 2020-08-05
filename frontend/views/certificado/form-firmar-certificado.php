<?php

use yii\bootstrap4\ActiveForm;
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
    <!-- Contenido de la pagina -->
    <div class="container">
        <div class="row">
            
        </div>
        <!-- /.row -->
    </div>
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

                <form name="formulario" enctype="multipart/form-data" action="firmar.php" method="POST">
                    <label for="inputFile">Archivo</label>
                    <div class="custom-file mb-5">
                        <input required name="uploadedfile" type="file" class="custom-file-input" id="inputFile">
                        <label class="custom-file-label" for="customFile">Suba el certificado que desea firmar.</label>
                    </div>

                    <label for="uploadedprivkey">Clave privada</label>
                    <div class="custom-file mb-5">
                        <input required name="uploadedprivkey" type="file" class="custom-file-input" id="inputFile">
                        <label class="custom-file-label" for="customFile">Archivo de Clave Privada para firmar el certificado.</label>
                    </div>

                    <div >
                        <label for="inputPassword">Contraseña</label>
                        <input name="uploadedpassword" type="password" class="form-control" id="inputPassword" placeholder="Ingrese aquí la contraseña de la clave privada (si posee una).">
                        <p class="help-block">Contraseña de la Llave Privada (opcional).</p>
                    </div>           

                    <input class="btn btn-default btn-lg" name="enviar" type="submit" value="Firmar Certificado"/>
                </form>

                <!-- Standard button -->
            </div>           


            </div>
    </div>
</div>

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>
