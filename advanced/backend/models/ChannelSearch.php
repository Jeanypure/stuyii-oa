<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Channel;

/**
 * ChannelSearch represents the model behind the search form about `backend\models\Channel`.
 */
class ChannelSearch extends Channel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'IsLiquid', 'IsPowder', 'isMagnetism', 'IsCharged', 'goodsid', 'SupplierID', 'StoreID', 'bgoodsid'], 'integer'],
            [['description', 'GoodsName', 'AliasCnName', 'AliasEnName', 'PackName', 'Season', 'DictionaryName', 'SupplierName', 'StoreName', 'Purchaser', 'possessMan1', 'possessMan2', 'picUrl', 'GoodsCode', 'achieveStatus', 'devDatetime', 'developer', 'updateTime', 'picStatus', 'AttributeName'], 'safe'],
            [['DeclaredValue'], 'number'],
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
        $query = Channel::find();
//        $query =  Yii::$app->db->createCommand('SELECT picUrl,GoodsCode,GoodsName,StoreName,o.developer,Purchaser,devDatetime,DictionaryName,cate,subCate
//                      FROM oa_goodsinfo o
//                        LEFT JOIN oa_goods s ON s.nid=o.goodsid');


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
            'DeclaredValue' => $this->DeclaredValue,
            'goodsid' => $this->goodsid,
            'devDatetime' => $this->devDatetime,
            'updateTime' => $this->updateTime,
            'SupplierID' => $this->SupplierID,
            'StoreID' => $this->StoreID,
            'bgoodsid' => $this->bgoodsid,
        ]);

        $query
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'GoodsName', $this->GoodsName])
            ->andFilterWhere(['like', 'AliasCnName', $this->AliasCnName])
            ->andFilterWhere(['like', 'AliasEnName', $this->AliasEnName])
            ->andFilterWhere(['like', 'PackName', $this->PackName])
            ->andFilterWhere(['like', 'Season', $this->Season])
            ->andFilterWhere(['like', 'DictionaryName', $this->DictionaryName])
            ->andFilterWhere(['like', 'SupplierName', $this->SupplierName])
            ->andFilterWhere(['like', 'StoreName', $this->StoreName])
            ->andFilterWhere(['like', 'Purchaser', $this->Purchaser])
            ->andFilterWhere(['like', 'possessMan1', $this->possessMan1])
            ->andFilterWhere(['like', 'possessMan2', $this->possessMan2])
            ->andFilterWhere(['like', 'picUrl', $this->picUrl])
            ->andFilterWhere(['like', 'GoodsCode', $this->GoodsCode])
            ->andFilterWhere(['like', 'achieveStatus', $this->achieveStatus])
            ->andFilterWhere(['like', 'developer', $this->developer])
            ->andFilterWhere(['like', 'picStatus', $this->picStatus])
            ->andFilterWhere(['like', 'AttributeName', $this->AttributeName])
;

        return $dataProvider;
    }
}
