<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actividades".
 *
 * @property int $ID
 * @property int $ID_SERVICIOS
 * @property string $NOMBRE
 * @property string|null $DESCRIPCION
 * @property bool $ACTIVO
 *
 * @property Servicios $sERVICIOS
 */
class Actividades extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'actividades';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID_SERVICIOS', 'NOMBRE'], 'required'],
            [['ID_SERVICIOS'], 'integer'],
            [['DESCRIPCION'], 'string'],
            [['ACTIVO'], 'boolean'],
            [['NOMBRE'], 'string', 'max' => 250],
            [['ID_SERVICIOS'], 'exist', 'skipOnError' => true, 'targetClass' => Servicios::className(), 'targetAttribute' => ['ID_SERVICIOS' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ID_SERVICIOS' => 'Id Servicios',
            'NOMBRE' => 'Nombre',
            'DESCRIPCION' => 'Descripcion',
            'ACTIVO' => 'Activo',
        ];
    }

    /**
     * Gets query for [[SERVICIOS]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSERVICIOS()
    {
        return $this->hasOne(Servicios::className(), ['ID' => 'ID_SERVICIOS']);
    }
}
