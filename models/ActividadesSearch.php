<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Actividades;

/**
 * ActividadesSearch represents the model behind the search form of `app\models\Actividades`.
 */
class ActividadesSearch extends Actividades
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'ID_SERVICIOS'], 'integer'],
            [['NOMBRE', 'DESCRIPCION'], 'safe'],
            [['ACTIVO'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Actividades::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'ID_SERVICIOS' => $this->ID_SERVICIOS,
            'ACTIVO' => $this->ACTIVO,
        ]);

        $query->andFilterWhere(['like', 'NOMBRE', $this->NOMBRE])
            ->andFilterWhere(['like', 'DESCRIPCION', $this->DESCRIPCION]);

        return $dataProvider;
    }
}
