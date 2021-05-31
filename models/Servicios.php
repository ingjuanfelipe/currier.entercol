<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "servicios".
 *
 * @property int $ID
 * @property string $NOMBRE
 * @property string|null $DESCRIPCION
 * @property string $IMG
 * @property string|null $LINK
 * @property bool|null $FRONTEND
 * @property bool|null $ACTIVO
 * @property float|null $VALOR
 * @property int|null $ORDEN
 *
 * @property Actividades[] $actividades
 * @property ProfesionalesServicios[] $profesionalesServicios
 */
class Servicios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servicios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NOMBRE', 'IMG'], 'required'],
            [['DESCRIPCION'], 'string'],
            [['FRONTEND', 'ACTIVO'], 'boolean'],
            [['VALOR'], 'number'],
            [['ORDEN'], 'integer'],
            [['NOMBRE', 'LINK'], 'string', 'max' => 100],
            [['IMG'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NOMBRE' => 'Nombre',
            'DESCRIPCION' => 'Descripcion',
            'IMG' => 'Img',
            'LINK' => 'Link',
            'FRONTEND' => 'Frontend',
            'ACTIVO' => 'Activo',
            'VALOR' => 'Valor',
            'ORDEN' => 'Orden',
        ];
    }

    /**
     * Gets query for [[Actividades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActividades()
    {
        return $this->hasMany(Actividades::className(), ['ID_SERVICIOS' => 'ID']);
    }

    /**
     * Gets query for [[ProfesionalesServicios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfesionalesServicios()
    {
        return $this->hasMany(ProfesionalesServicios::className(), ['ID_SERVICIO' => 'ID']);
    }
}
