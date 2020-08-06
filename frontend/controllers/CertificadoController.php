<?php
namespace frontend\controllers;

use frontend\models\CategoriaEvento;
use frontend\models\Certificado;
use frontend\models\Evento;
use frontend\models\Inscripcion;
use frontend\models\ModalidadEvento;
use frontend\models\Presentacion;
use frontend\models\Usuario;
use kartik\mpdf\Pdf;
use Yii;
use yii\base\DynamicModel;
use yii\bootstrap4\ActiveForm;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\response;

//uso de librería de firma digital
use frontend\models\firma\Autenticacion;
use frontend\models\firma\Autochequeo;
use frontend\models\firma\CertificadoFirma;
use frontend\models\firma\Exceptions;
use frontend\models\firma\FirmaElectronica;
use frontend\models\firma\Libreria;
use frontend\models\firma\Logger;
use frontend\models\firma\Messages;
use frontend\models\firma\Singleton;

/**
 * CertificadoController.
 */
class CertificadoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
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
     * Se muestran los botones para general la vista previa del documento PDF.
     *
     * @return mixed
     */
    public function actionIndex($id)
    {

        $certificate = $this->loadCertificateData($id, Yii::$app->user->identity->id);

        //Modelo y respuesta en el caso de que haya sido expositor de varias presentaciones
        $model = new DynamicModel([
            'idPresentacion',
        ]);
        $model->addRule(['idPresentacion'], 'required')
            ->addRule(['idPresentacion'], 'integer');


        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if (Yii::$app->request->post()) {
            if ($model->validate()) {
                $filePDF = $this->commonData($id, 'expositor', $certificate, $model['idPresentacion']);
                return $filePDF->render();
            }
        }

        $isAccredited = $certificate->verifyAccreditation();
        if ($certificate->verifyExhibitor(Yii::$app->user->identity->id) != null) {
            $presentations = ArrayHelper::map($certificate->verifyExhibitor(Yii::$app->user->identity->id), 'idPresentacion', 'tituloPresentacion');
            $isExhibitor = true;
        } else {
            $presentations = null;
            $isExhibitor = false;
        }
        $isOrganizer = $certificate->verifyOrganizer(Yii::$app->user->identity->id);

        return $this->render('index', [
            'idEvent' => $id,
            'model' => $model,
            'attendanceCertificate' => $isAccredited,
            'exhibitorCertificate' => $isExhibitor,
            'organizerCertificate' => $isOrganizer,
            'presentations' => $presentations,
        ]);
    }

    private function loadCertificateData($event, $user)
    {

        $inscription = Inscripcion::find()
            ->where(['idEvento' => $event])
            ->andWhere(['idUsuario' => $user])
            ->all();

        $presentation = Presentacion::find()
            ->where(['idEvento' => $event])
            ->all();

        $event = Evento::find()
            ->where(['idEvento' => $event])
            ->all();

        $certificate = new Certificado();
        $certificate->setEvent($event);
        $certificate->setPresentations($presentation);
        $certificate->setInscription($inscription);

        return $certificate;
    }

    /**
     * Método que devuelve un objeto mpdf con los datos y estilo del certificado
     * para ser visualizado en el navegador
     *
     * @return object
     */
    private function commonData($id, $type, $certificate, $idPresentation = null)
    {
        $organizer = Usuario::findOne($certificate->event[0]->idUsuario);
        $userData = Usuario::findOne(Yii::$app->user->identity->id);
        $eventData = $certificate->event;

        if ($eventData[0]->solicitudAval['avalado'] == 1) {
            $footer = 'Facultad de Informática - UNComa';
            $isOficial = true;
        } else {
            $footer = null;
            $isOficial = false;
        }

        if ($idPresentation != null) {
            $presentation = Presentacion::findOne($idPresentation);
        } else {
            $presentation = null;
        }
        $presentationData = $certificate->presentations;
        $category = CategoriaEvento::findOne($certificate->event[0]->idCategoriaEvento);
        $modality = ModalidadEvento::findOne($certificate->event[0]->idModalidadEvento);
        //Regenera el modelo del pdf con los datos y el estilo deseado.
        $content = $this->renderPartial('model', [
            'event' => $eventData,
            'user' => $userData,
            'modality' => $modality,
            'category' => $category,
            'certificateType' => $type,
            'isOficial' => $isOficial,
            'presentations' => [
                'collections' => $presentationData,
                'presentation' => $presentation,
            ],
        ]);

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => 'css/certificate.css',
            'cssInline' => '.kv-heading-1{font-size:18px}',
            'options' => ['title' => 'Certificado'],
            'methods' => [
                'SetHeader' => ['Certificado Digital <img src=images/juntar-logo/png/juntar-logo-k.png style=width:65px;>'],
                'SetFooter' => [$footer],
                'SetTitle' => ['Certificado Juntar'],
                'SetAuthor' => ['Facultad de Informática - UNComa'],
            ]
        ]);

        return $pdf;

    }

    /**
     * Método para visualizar un certificado de Asistencia
     *
     * @return mixed
     */
    public function actionPreviewAttendance($id)
    {
        $dataPdf = $this->loadCertificateData($id, Yii::$app->user->identity->id);
        if ($dataPdf->verifyAccreditation()) {
            $filePDF = $this->commonData($id, 'asistencia', $dataPdf);
            return $filePDF->render();
        } else {
            return $this->render('/site/error', [
                'name' => 'Certificado',
                'message' => 'Se ha provocado un error en la solicitud del certificado.'
            ]);
        }

    }

    /**
     * Método para visualizar un certificado de Organizador
     *
     * @return mixed
     */
    public function actionPreviewOrganizer($id)
    {
        $dataPdf = $this->loadCertificateData($id, Yii::$app->user->identity->id);
        if ($dataPdf->verifyOrganizer(Yii::$app->user->identity->id)) {
            $filePDF = $this->commonData($id, 'organizador', $dataPdf);
            return $filePDF->render();
        } else {
            return $this->render('/site/error', [
                'name' => 'Certificado',
                'message' => 'Se ha provocado un error en la solicitud del certificado.'
            ]);
        }
    }

    /**
     * Método para el formulario de firmar un certificado
     * FORMULARIO
     * 
     * @return mixed
     */
    public function actionFormFirmarCertificado($mensaje = null){
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        return $this->render('form-firmar-certificado', [
            'name' => 'Certificado',
            'mensaje' => $mensaje
        ]);
    }

    /**
     * Método de procesamiento de la firma del certificado
     * REQUEST
     * 
     * @return mixed
     */
    public function actionFirmaCertificado(){

        $mensaje = "";

        if (isset($_REQUEST['uploadedfile']) && isset($_REQUEST['uploadedprivkey']) && isset($_REQUEST['uploadedpassword'])){

            error_reporting(E_ALL & ~E_NOTICE);
            ini_set("display_errors", 1);

            $target_path = "web/certificados/";
            $target_path = $target_path . basename( $_FILES['uploadedfile']['name']);
            $archivo_upload = basename( $_FILES['uploadedfile']['name']);
            if(move_uploaded_file($_REQUEST['uploadedfile'], $target_path)) {
                //echo "El archivo ". basename( $_FILES['uploadedfile']['name']). " ha sido subido"."<br>";
                $mensaje = "El archivo ". $archivo_upload. " ha sido firmado y subido!<br>";
            }else{
                //echo "Ha ocurrido un error, trate de nuevo!"."<br>";
                $mensaje = "Ha ocurrido un error al subir el archivo ".$_REQUEST['uploadedfile'].", trate de nuevo!"."<br>";
            }

                $target_path = "./";
                $target_path = $target_path . basename( $_FILES['uploadedprivkey']['name']);
                $llave_privada = basename( $_FILES['uploadedprivkey']['name']);
                if(move_uploaded_file($_FILES['uploadedprivkey']['tmp_name'], $target_path)) {
                    echo "El archivo ". basename( $_FILES['uploadedprivkey']['name']). " ha sido subido"."<br>";
                    $mensaje .= "<br> El archivo ". $llave_privada. " ha sido subido"."<br>";
                }else{
                    echo "Ha ocurrido un error, trate de nuevo!"."<br>";
                    $mensaje .= "<br> Ha ocurrido un error al subir la clave privada, trate de nuevo!"."<br>";
                }

                $pass_llave = $_POST['uploadedpassword'];

        }else{
            $mensaje = "NO se han enviado los datos correctamente";
        }
                    
        
                //echo "el password es:".$pass_llave."<br>";
                    
                //************* empezamos la verificacion **************************
                /*$Libreria = new Libreria();
                    
                $fileIn1 = fopen($archivo_upload,"r");
                $fileIn = "";
                
		    while(!feof($fileIn1)) {
		        $fileIn.=fgets($fileIn1);
		    }
		    fclose($fileIn1);
		    //echo "archivo: ".$fileIn."<br>";
		
		    $privKey1 = fopen($llave_privada,"r");
		    $privKey = "";
		    while(!feof($privKey1)){
		        $privKey.=fgets($privKey1);
		    }
		    fclose($privKey1);
		    echo "archivo: ".$privKey."<br>";                  
                    
            $sig = $Libreria->firmarBinario($fileIn,$privKey);
                    
            //echo " ".$sig."<br>";
                    
            $firmadoSig = fopen("certificado.sig","a");
            fwrite($firmadoSig,$sig);
                    
            fclose($firmadoSig);
                    
            //shell_exec("openssl dgst -c -sign uploads/".$llave_privada." -out uploads/filefirmado.sig uploads/".$archivo_upload);
            echo "<h4 style='color: blue;'>Archivo Firmado</h4>"."<br>";
            echo $firmadoSig;

                    
            /*
            CLAVE PUBLICA
            echo "<br> <br>";
            $details = openssl_pkey_get_details($resourceNewKeyPair);
            $publicKeyPem = $details['key'];
            echo $publicKeyPem;
            
            //$salida = shell_exec('ls -lart');
            //echo "<pre>$salida</pre>";
            echo "<a href='./certificado.sig'> Archivo Con La Firma</a>";
            echo "<a href='./".$archivo_upload."'> Tu Archivo </a>";*/

            $this->redirect(["certificado/form-firmar-certificado", "mensaje" => $mensaje]);
    }

    
}

?>
