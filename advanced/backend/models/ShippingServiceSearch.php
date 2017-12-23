<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OaShippingService;

/**
 * ShippingServiceSearch represents the model behind the search form about `backend\models\OaShippingService`.
 */
class ShippingServiceSearch extends OaShippingService
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nid', 'siteId'], 'integer'],
            [['servicesName', 'type', 'ibayShipping'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = OaShippingService::find();

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
            'nid' => $this->nid,
            'siteId' => $this->siteId,
        ]);

        $query->andFilterWhere(['like', 'servicesName', $this->servicesName])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'ibayShipping', $this->ibayShipping]);

        return $dataProvider;
    }
}
