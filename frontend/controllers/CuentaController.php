<?php

namespace frontend\controllers;

use frontend\models\Usuario;
use frontend\models\SignupForm;
use frontend\models\UploadProfileImage;
use yii\web\UploadedFile;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class CuentaController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        $behaviors['access'] = [
            //utilizamos el filtro AccessControl
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
//                        $module = Yii::$app->controller->module->id;
                        $action = Yii::$app->controller->action->id;        //guardamos la accion (vista) que se intenta acceder
                        $controller = Yii::$app->controller->id;            //guardamos el controlador del cual se consulta
//                        $route = "$module/$controller/$action";
                        $route = "$controller/$action";                     //generamos la ruta que se busca acceder
//                        $post = Yii::$app->request->post();
                        //preguntamos si el usuario tiene los permisos para visitar el sitio
//                        if (Yii::$app->user->can($route, ['post' => $post])) {
                        if (Yii::$app->user->can($route)) {
//                            return $this->goHome();
                            return true;
                        }
                    }
                ],
            ],
        ];

        return $behaviors;
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
//            'captcha' => [
//                'class' => 'yii\captcha\CaptchaAction',
//                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
//            ],
        ];
    }

    public function actionProfile() {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $profileImageRoute = "icons/person-bounding-box.svg";
        $rutaImagenPerfil = Yii::getAlias("@web") . "profile/images/" . (Yii::$app->user->identity->idUsuario . '-' . Yii::$app->user->identity->nombre . '.jpg');

        if (file_exists($rutaImagenPerfil)) {
            $profileImageRoute = $rutaImagenPerfil;
        }
//        $model = new Usuario();
        $queryUser = (new \yii\db\Query())
                //campos buscados
                ->select(['nombre, apellido, dni, pais, provincia, localidad, email, (usuario_rol.item_name) as rol'])
                //distintos en
                //->distinct('jugador.posicion')
                //tabla
                ->from('usuario')
                //relacion entre tablas
                ->innerJoin('usuario_rol', 'usuario_rol.user_id = usuario.idUsuario')
                //condicion
                ->where(['idUsuario' => Yii::$app->user->identity->id]);
        //Agrupamiento
        //->groupBy(['jugador.posicion']);
        //obtenemos el array asociativo a partir de la query
        $userData = $queryUser->all();

        return $this->render('profile', [
                    'data' => $userData,
                    'profileImage' => $profileImageRoute,
                    'route' => $rutaImagenPerfil
//                    'data' => $queryUser,
        ]);
    }

    /**
     * Permite actualizar la información del perfil
     *
     * @return mixed
     */
    public function actionEditprofile() {

        //Siempre que quieras editar data, asegurate que el modelo defina reglas de validación para todos los campos afectados
        $model = $this->findModel(Yii::$app->user->identity->id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $viejoNombreUsuario = Yii::$app->user->identity->nombre;
                $cambioImagen = false;
                if ($model->nombre != $viejoNombreUsuario) {
                    $rutaImagenPerfil = "profile/images/" . (Yii::$app->user->identity->idUsuario . '-' . $viejoNombreUsuario . '.jpg');
                    if (file_exists($rutaImagenPerfil)) {
                        $nuevaRutaImagen = "profile/images/" . (Yii::$app->user->identity->idUsuario . '-' . $model->nombre . '.jpg');
                        if (rename($rutaImagenPerfil, $nuevaRutaImagen)) {
                            $cambioImagen = true;
                        }
                    }
                }
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', '<h2> Datos Actualizados </h2>'
                            . '<p> ¡Tu perfil ha sido actualizado correctamente! </p>');
                } else {
                    Yii::$app->session->setFlash('error', '<h2> Ha ocurrido un error ): </h2>'
                            . '<p> Tu perfil no pudo ser actualizado </p>');
                }
            } else {
                Yii::$app->session->setFlash('error', '<h2> Ha ocurrido un error ): </h2>'
                        . '<p> Ingreso de datos no permitido </p>');
            }
            return $this->redirect(['profile']);
        }
//        if (Yii::$app->request->post('search') != null) {
//            //define el tipo de respuesta del metodo
//            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//        }

        return $this->render('editprofile', [
                    'model' => $model,
        ]);
    }

    /**
     * Permite actualizar la información del perfil
     *
     * @return mixed
     */
    public function actionUploadProfileImage() {
        //Siempre que quieras editar data, asegurate que el modelo defina reglas de validación para todos los campos afectados
        $model = new UploadProfileImage();

        if ($model->load(Yii::$app->request->post())) {
            $model->profileImage = UploadedFile::getInstance($model, 'profileImage');

            if ($model->profileImage != null) {
                if ($model->upload()) {
                    $model->profileImage = (Yii::getAlias("@web/profile/images/")) . $model->profileImage->baseName . '.' . $model->profileImage->extension;
                }
            }
            Yii::$app->session->setFlash('success', '<h2> Datos Actualizados </h2>'
                    . '<p> ¡Tu perfil ha sido actualizado correctamente! </p>');
            return $this->redirect(['profile']);
        }

        return $this->render('uploadProfileImage', [
                    'model' => $model,
        ]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    private function actionSignup() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', '<h2> ¡Sólo queda confirmar tu correo! </h2>'
                    . '<p> Muchas gracias por registrarte en la plataforma Juntar. Por favor, revisa tu dirección de correo para confirmar tu cuenta. </p>');
            return $this->goHome();
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    protected function findModel($id) {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Habilitar ser gestor de eventos.
     * @param int $id identificador del usuario.
     * @return mixed
     */
    public function actionChangeRol($id) {
        $organizateRol = yii::$app->authManager->getRole('Organizador');
        if (yii::$app->authManager->getAssignment('Organizador', $id) == null) {
            yii::$app->authManager->assign($organizateRol, $id);
            Yii::$app->session->setFlash('success', '<small>Ahora es un gestor de evento</small>');
        }
        return $this->redirect(['profile']);
    }

}
