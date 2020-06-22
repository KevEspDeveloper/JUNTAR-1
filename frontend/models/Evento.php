<?php

namespace frontend\models;
use frontend\models\Usuario;

use frontend\models\ModalidadEvento;
use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "evento".
 *
 * @property int $idEvento
 * @property int $idUsuario
 * @property int $idCategoriaEvento
 * @property int $idEstadoEvento
 * @property int $idModalidadEvento
 * @property string $nombreEvento
 * @property string $nombreCortoEvento
 * @property string $descripcionEvento
 * @property string $lugar
 * @property string $fechaInicioEvento
 * @property string $fechaFinEvento
 * @property string|null $imgFlyer
 * @property string|null $imgLogo
 * @property int $capacidad
 * @property int $preInscripcion
 * @property string $fechaLimiteInscripcion
 * @property string|null $codigoAcreditacion
 * @property string $fechaCreacionEvento
 *
 * @property CategoriaEvento $idCategoriaEvento0
 * @property EstadoEvento $idEstadoEvento0
 * @property ModalidadEvento $idModalidadEvento0
 * @property Usuario $idUsuario0
 * @property Inscripcion[] $inscripcions
 * @property Presentacion[] $presentacions
 */
class Evento extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
         [
             "class" => SluggableBehavior::className(),
             "attribute" => "nombreCortoEvento",
             "slugAttribute" => "nombreCortoEvento",
             "immutable" => true,
             "ensureUnique" => true,
         ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idUsuario', 'idCategoriaEvento', 'idEstadoEvento', 'idModalidadEvento', 'nombreEvento', 'nombreCortoEvento', 'descripcionEvento', 'lugar', 'fechaInicioEvento', 'fechaFinEvento', 'preInscripcion'], 'required'],
            [['idUsuario', 'idCategoriaEvento', 'idEstadoEvento', 'idModalidadEvento', 'capacidad', 'preInscripcion'], 'integer'],
            [['fechaInicioEvento', 'fechaFinEvento', 'fechaLimiteInscripcion', 'fechaCreacionEvento'], 'safe'],
            [['nombreEvento', 'lugar', 'imgFlyer', 'imgLogo'], 'string', 'max' => 200],
            ['fechaFinEvento','compare','compareAttribute'=>'fechaInicioEvento','operator'=>'>='],
            [['nombreCortoEvento', 'codigoAcreditacion'], 'string', 'max' => 100],
            ['nombreCortoEvento', 'match', 'pattern' => '/^[a-z0-9]+(?:-[a-z0-9]+)*$/', 'message' => 'El campo contiene caracteres inválidos'],
            ['nombreCortoEvento', 'unique', 'message' => 'El nombre corto ya fue registrado.'],
            [['descripcionEvento'], 'string', 'max' => 800],
            [['idUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['idUsuario' => 'idUsuario']],
            [['idCategoriaEvento'], 'exist', 'skipOnError' => true, 'targetClass' => CategoriaEvento::className(), 'targetAttribute' => ['idCategoriaEvento' => 'idCategoriaEvento']],
            [['idModalidadEvento'], 'exist', 'skipOnError' => true, 'targetClass' => ModalidadEvento::className(), 'targetAttribute' => ['idModalidadEvento' => 'idModalidadEvento']],
            [['idEstadoEvento'], 'exist', 'skipOnError' => true, 'targetClass' => EstadoEvento::className(), 'targetAttribute' => ['idEstadoEvento' => 'idEstadoEvento']],
            ['fechaFinEvento','compare','compareAttribute'=>'fechaInicioEvento','operator'=>'>='],
            ['fechaLimiteInscripcion','compare','compareAttribute'=>'fechaInicioEvento','operator'=>'<'],
            ['nombreCortoEvento','match','pattern'=> "/^[A-Z|a-z|0-9-_]+$/","message" => "No se permite espacios en blanco"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idEvento' => 'Id Evento',
            'idUsuario' => 'Id Usuario',
            'idCategoriaEvento' => 'Categoria',
            'idEstadoEvento' => 'Estado',
            'idModalidadEvento' => 'Modalidad',
            'nombreEvento' => 'Nombre Evento',
            'nombreCortoEvento' => 'Nombre Corto Evento',
            'descripcionEvento' => 'Descripción',
            'lugar' => 'Lugar',
            'fechaInicioEvento' => 'Fecha Inicio Evento',
            'fechaFinEvento' => 'Fecha Fin Evento',
            'imgFlyer' => 'Img Flyer',
            'imgLogo' => 'Img Logo',
            'capacidad' => 'Capacidad',
            'preInscripcion' => 'Preinscripción',
            'fechaLimiteInscripcion' => 'Fecha Limite Inscripción',
            'codigoAcreditacion' => 'Código Acreditación',
            'fechaCreacionEvento' => 'Fecha Creación Evento',
        ];
    }

    /**
     * Gets query for [[IdCategoriaEvento0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdCategoriaEvento0()
    {
        return $this->hasOne(CategoriaEvento::className(), ['idCategoriaEvento' => 'idCategoriaEvento']);
    }

    /**
     * Gets query for [[IdEstadoEvento0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdEstadoEvento0()
    {
        return $this->hasOne(EstadoEvento::className(), ['idEstadoEvento' => 'idEstadoEvento']);
    }

    /**
     * Gets query for [[IdModalidadEvento0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdModalidadEvento0()
    {
        return $this->hasOne(ModalidadEvento::className(), ['idModalidadEvento' => 'idModalidadEvento']);
    }

    /**
     * Gets query for [[IdUsuario0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario0()
    {
        return $this->hasOne(Usuario::className(), ['idUsuario' => 'idUsuario']);
    }

    /**
     * Gets query for [[Inscripcions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInscripcions()
    {
        return $this->hasMany(Inscripcion::className(), ['idEvento' => 'idEvento']);
    }

    /**
     * Gets query for [[Presentacions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPresentacions()
    {
        return $this->hasMany(Presentacion::className(), ['idEvento' => 'idEvento']);
    }
}
