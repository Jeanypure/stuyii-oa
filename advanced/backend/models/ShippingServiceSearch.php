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
            [['servicesName', 'ibayShipping', 'Name'], 'safe'],
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
        $query = OaShippingService::find()->joinWith('country');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'defaultOrder' => [
                //'capital' => SORT_DESC,
                'nid' => SORT_DESC,
            ],
            'attributes' => [
                'nid' => [
                    'asc' => ['oa_shippingService.nid' => SORT_ASC],
                    'desc' => ['oa_shippingService.nid' => SORT_DESC],
                ],
                'servicesName' => [
                    'asc' => ['servicesName' => SORT_ASC],
                    'desc' => ['servicesName' => SORT_DESC],
                ],
                'type' => [
                    'asc' => ['type' => SORT_ASC],
                    'desc' => ['type' => SORT_DESC],
                ],
                'ibayShipping' => [
                    'asc' => ['ibayShipping' => SORT_ASC],
                    'desc' => ['ibayShipping' => SORT_DESC],
                ],
                'Name' => [
                    'asc' => ['Name' => SORT_ASC],
                    'desc' => ['Name' => SORT_DESC],
                ],
            ]
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
            //->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'oa_ebay_country.Name', $this->Name])
            ->andFilterWhere(['like', 'ibayShipping', $this->ibayShipping]);

        return $dataProvider;
    }
}
