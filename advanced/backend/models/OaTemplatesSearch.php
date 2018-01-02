<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OaTemplates;

/**
 * OaTemplatesSearch represents the model behind the search form about `backend\models\OaTemplates`.
 */
class OaTemplatesSearch extends OaTemplates
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nid', 'goodsid', 'prepareDay', 'quantity'], 'integer'],
            [['location', 'country', 'postCode', 'site', 'listedCate', 'listedSubcate', 'title', 'subTitle', 'description', 'UPC', 'EAN', 'Brand', 'MPN', 'Color', 'Type', 'Material', 'IntendedUse', 'unit', 'bundleListing', 'shape', 'features', 'regionManufacture', 'reserveField', 'InshippingMethod1', 'InshippingMethod2', 'OutshippingMethod1', 'OutShiptoCountry1', 'OutshippingMethod2', 'OutShiptoCountry2'], 'safe'],
            [['nowPrice', 'InFirstCost1', 'InSuccessorCost1', 'InFirstCost2', 'InSuccessorCost2', 'OutFirstCost1', 'OutSuccessorCost1', 'OutFirstCost2', 'OutSuccessorCost2'], 'number'],
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
        $query = OaTemplates::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => isset($params['pageSize']) && $params['pageSize'] ? $params['pageSize'] : 20,
            ],
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
            'goodsid' => $this->goodsid,
            'prepareDay' => $this->prepareDay,
            'quantity' => $this->quantity,
            'nowPrice' => $this->nowPrice,
            'InFirstCost1' => $this->InFirstCost1,
            'InSuccessorCost1' => $this->InSuccessorCost1,
            'InFirstCost2' => $this->InFirstCost2,
            'InSuccessorCost2' => $this->InSuccessorCost2,
            'OutFirstCost1' => $this->OutFirstCost1,
            'OutSuccessorCost1' => $this->OutSuccessorCost1,
            'OutFirstCost2' => $this->OutFirstCost2,
            'OutSuccessorCost2' => $this->OutSuccessorCost2,
        ]);

        $query->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'postCode', $this->postCode])
            ->andFilterWhere(['like', 'site', $this->site])
            ->andFilterWhere(['like', 'listedCate', $this->listedCate])
            ->andFilterWhere(['like', 'listedSubcate', $this->listedSubcate])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'subTitle', $this->subTitle])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'UPC', $this->UPC])
            ->andFilterWhere(['like', 'EAN', $this->EAN])
            ->andFilterWhere(['like', 'Brand', $this->Brand])
            ->andFilterWhere(['like', 'MPN', $this->MPN])
            ->andFilterWhere(['like', 'Color', $this->Color])
            ->andFilterWhere(['like', 'Type', $this->Type])
            ->andFilterWhere(['like', 'Material', $this->Material])
            ->andFilterWhere(['like', 'IntendedUse', $this->IntendedUse])
            ->andFilterWhere(['like', 'unit', $this->unit])
            ->andFilterWhere(['like', 'bundleListing', $this->bundleListing])
            ->andFilterWhere(['like', 'shape', $this->shape])
            ->andFilterWhere(['like', 'features', $this->features])
            ->andFilterWhere(['like', 'regionManufacture', $this->regionManufacture])
            ->andFilterWhere(['like', 'reserveField', $this->reserveField])
            ->andFilterWhere(['like', 'InshippingMethod1', $this->InshippingMethod1])
            ->andFilterWhere(['like', 'InshippingMethod2', $this->InshippingMethod2])
            ->andFilterWhere(['like', 'OutshippingMethod1', $this->OutshippingMethod1])
            ->andFilterWhere(['like', 'OutShiptoCountry1', $this->OutShiptoCountry1])
            ->andFilterWhere(['like', 'OutshippingMethod2', $this->OutshippingMethod2])
            ->andFilterWhere(['like', 'OutShiptoCountry2', $this->OutShiptoCountry2]);

        return $dataProvider;
    }
}
