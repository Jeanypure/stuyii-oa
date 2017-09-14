<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OaGoodsinfo;

/**
 * OaGoodsinfoSearch represents the model behind the search form about `backend\models\OaGoodsinfo`.
 */
class OaGoodsinfoSearch extends OaGoodsinfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'IsLiquid', 'IsPowder', 'isMagnetism', 'IsCharged', 'SupplierID', 'SampleFlag', 'SampleCount', 'GroupFlag', 'SellCount', 'SellDays', 'PackageCount', 'StockDays', 'StoreID'], 'integer'],
            [['description', 'Notes', 'SampleMemo', 'CreateDate', 'SalerName', 'PackName', 'GoodsStatus', 'DevDate', 'SalerName2', 'ChangeStatusTime', 'Purchaser', 'LinkUrl', 'LinkUrl2', 'LinkUrl3'], 'safe'],
            [['PackFee', 'BatchPrice', 'MaxSalePrice', 'RetailPrice', 'MarketPrice'], 'number'],
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
        $query = OaGoodsinfo::find();

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
            'pid' => $this->pid,
            'IsLiquid' => $this->IsLiquid,
            'IsPowder' => $this->IsPowder,
            'isMagnetism' => $this->isMagnetism,
            'IsCharged' => $this->IsCharged,
            'SupplierID' => $this->SupplierID,
            'SampleFlag' => $this->SampleFlag,
            'SampleCount' => $this->SampleCount,
            'CreateDate' => $this->CreateDate,
            'GroupFlag' => $this->GroupFlag,
            'SellCount' => $this->SellCount,
            'SellDays' => $this->SellDays,
            'PackFee' => $this->PackFee,
            'DevDate' => $this->DevDate,
            'BatchPrice' => $this->BatchPrice,
            'MaxSalePrice' => $this->MaxSalePrice,
            'RetailPrice' => $this->RetailPrice,
            'MarketPrice' => $this->MarketPrice,
            'PackageCount' => $this->PackageCount,
            'ChangeStatusTime' => $this->ChangeStatusTime,
            'StockDays' => $this->StockDays,
            'StoreID' => $this->StoreID,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'Notes', $this->Notes])
            ->andFilterWhere(['like', 'SampleMemo', $this->SampleMemo])
            ->andFilterWhere(['like', 'SalerName', $this->SalerName])
            ->andFilterWhere(['like', 'PackName', $this->PackName])
            ->andFilterWhere(['like', 'GoodsStatus', $this->GoodsStatus])
            ->andFilterWhere(['like', 'SalerName2', $this->SalerName2])
            ->andFilterWhere(['like', 'Purchaser', $this->Purchaser])
            ->andFilterWhere(['like', 'LinkUrl', $this->LinkUrl])
            ->andFilterWhere(['like', 'LinkUrl2', $this->LinkUrl2])
            ->andFilterWhere(['like', 'LinkUrl3', $this->LinkUrl3]);

        return $dataProvider;
    }
}
