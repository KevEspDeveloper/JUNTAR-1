<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Evento */

$this->title = $model->nombreEvento;
$this->params['breadcrumbs'][] = ['label' => 'Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="evento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->idEvento], ['class' => 'btn btn-primary']) ?>
        <?php
        if ($model->idEstadoEvento0->descripcionEstado == "Activo") {
            echo Html::a('Deshabilitar', ['deshabilitar', 'id' => $model->idEvento], [
                'class' => 'btn btn-danger',
                'data' => ['confirm' => '¿Está seguro de querer deshabilitar este evento?'],]);
        } else {
            if ($model->idEstadoEvento0->descripcionEstado == "Inhabilitado") {
                echo Html::a('Habilitar', ['habilitar', 'id' => $model->idEvento], [
                    'class' => 'btn btn-success',
                    'data' => ['confirm' => '¿Está seguro de querer habilitar este evento?'],]);
            }
        }
        ?>
        <?php
        if ($model->avalado != 1) {
            echo Html::a('Conceder aval FAI', ['conceder-aval', 'id' => $model->idEvento], [
                'class' => 'btn btn-warning',
                'data' => ['confirm' => '¿Está seguro de querer conceder el aval de la FAI para este evento?'],
            ]);
        } else {
            echo Html::a('Quitar aval FAI', ['quitar-aval', 'id' => $model->idEvento], [
                'class' => 'btn btn-danger',
                'data' => ['confirm' => '¿Está seguro de querer conceder el aval de la FAI para este evento?'],
            ]);
        }
        ?>

    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'idEvento',
            [
                'attribute' => 'avalado',
                'label' => 'Avalado FAI',
                'value' => function ($dataProvider) {
                    return ($dataProvider->avalado == 1 ? "Avalado" : "No");
                },
            ],
            [
                'attribute' => 'idUsuario',
                'label' => 'Organizador',
                'value' => $model->idUsuario0->nombre . " " . $model->idUsuario0->apellido, //valor referenciado
            ],
            [
                'attribute' => 'idCategoriaEvento',
                'label' => 'Categoria',
                'value' => $model->idCategoriaEvento0->descripcionCategoria, //valor referenciado por ActiveQuery
            ],
            [
                'attribute' => 'idEstadoEvento',
                'label' => 'Estado',
                'value' => $model->idEstadoEvento0->descripcionEstado, //valor referenciado por ActiveQuery
            ],
            [
                'attribute' => 'idModalidadEvento',
                'label' => 'Modalidad',
                'value' => $model->idModalidadEvento0->descripcionModalidad, //valor referenciado por ActiveQuery
            ],
            'nombreEvento',
            'nombreCortoEvento',
            'descripcionEvento',
            'lugar',
            'fechaInicioEvento',
            'fechaFinEvento',
            'imgFlyer',
            'imgLogo',
            'capacidad',
            [
                'attribute' => 'preInscripcion',
                'label' => 'Pre-Inscripcion',
                'value' => function ($dataProvider) {
                    return ($dataProvider->preInscripcion == 0 ? 'No' : 'Si');
                },
            ],
//            'preInscripcion',
            'fechaLimiteInscripcion',
            'codigoAcreditacion',
            'fechaCreacionEvento',
            'avalRequest',
        ],
    ])
    ?>

</div>
