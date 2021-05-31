<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "credenciales".
 *
 * @property int $id
 * @property string $shop_url
 * @property string|null $access_token
 * @property string $install_date
 */
class Credenciales extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'credenciales';
    }
    function view($shopify){        
       return Credenciales::find()
                ->where(['shop_url'=>$shopify])
                ->limit(1)
                ->all();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shop_url', 'install_date'], 'required'],
            [['install_date'], 'safe'],
            [['shop_url'], 'string', 'max' => 150],
            [['access_token'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shop_url' => 'Shop Url',
            'access_token' => 'Access Token',
            'install_date' => 'Install Date',
        ];
    }
}
