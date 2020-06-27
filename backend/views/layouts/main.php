<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->name,
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar navbar-expand-md navbar-dark bg-dark',
                ],
            ]);
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
            } else {
                $menuItems[] = ['label' => 'Home', 'url' => ['/site/index']];
                //MenuItems for ABM
                //MenuItems ABM Permisos
//        $menuItems[] = [
//                       'label' => 'Gestor de Permisos OLD',
//                       'items' => [
//                            ['label' => 'Asignar Permisos', 'url' => ['/permission-manager/index']],
//                            ['label' => 'Asignar Permisos3', 'url' => ['/permission-manager/index3']],
//                            ['label' => 'Asignar Permisos5', 'url' => ['/permission-manager/index5']],
//                            ['label' => 'Asignar Permisos7', 'url' => ['/permission-manager/index7']],
//                            ],
//                        ];
                //MenuItems ABM Permisos
                $menuItems[] = [
                    'label' => 'Gestionar Permisos',
                    'items' => [
                        ['label' => 'Crear Permiso', 'url' => ['/permission/create-permiso']],
                        ['label' => 'Asignar Permisos', 'url' => ['/permission/asignar-permisos']],
                        ['label' => 'Listado Permisos', 'url' => ['/permission/index']],
                        ['label' => 'Eliminar Permiso', 'url' => ['/permission/remove-permiso']],
                    ],
                ];
                $menuItems[] = [
                    'label' => 'Gestionar Roles',
                    'items' => [
                        ['label' => 'Crear Rol', 'url' => ['/rol/create-rol']],
                        ['label' => 'Listado Roles', 'url' => ['/rol/index']],
                    ],
                ];
                //ABM Usuario
                $menuItems[] = ['label' => 'Gestionar Usuarios', 'url' => ['/usuario/index']];
                //ABM Eventos
                $menuItems[] = ['label' => 'Gestionar Eventos', 'url' => ['/evento/index']];
                //Logout
                $menuItems[] = [
                    "label" => "Salir (" . Yii::$app->user->identity->nombre . ")",
                    "url" => ["/site/logout"],
                    "linkOptions" => [
                        "data-method" => "post",
                    ]
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-collapse justify-content-end'],
                'items' => $menuItems,
            ]);
            NavBar::end();
            ?>


            <div class="container">
                <?=
                Breadcrumbs::widget([
                    'itemTemplate' => "\n\t<li class=\"breadcrumb-item\"><i>{link}</i></li>\n", // template for all links
                    'activeItemTemplate' => "\t<li class=\"breadcrumb-item active\">{link}</li>\n", // template for the active link
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>

        <footer class="footer fixed-bottom">
            <!--<footer class="footer">-->
            <div class="container">
                <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
