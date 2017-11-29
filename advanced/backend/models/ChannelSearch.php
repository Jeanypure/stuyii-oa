<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ChannelSearch represents the model behind the search form about `backend\models\Channel`.
 */
class ChannelSearch extends Channel
{
    public $cate;
    public $subCate;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'IsLiquid', 'IsPowder', 'isMagnetism', 'IsCharged', 'goodsid', 'SupplierID', 'StoreID', 'bgoodsid'], 'integer'],
            [['cate','subCate','description', 'GoodsName', 'AliasCnName', 'AliasEnName', 'PackName', 'Season', 'DictionaryName', 'SupplierName', 'StoreName',
                'Purchaser', 'possessMan1', 'possessMan2', 'picUrl', 'GoodsCode', 'achieveStatus', 'devDatetime', 'developer', 'updateTime', 'picStatus', 'AttributeName','cate','subCat'], 'safe'],
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
//       $query->joinWith(['oa_goods']);

        // add conditions that should always apply here


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'devDatetime' => SORT_DESC,
                    //'title' => SORT_ASC,
                ]
            ],
        ]);


        $dataProvider->setSort([
            'attributes' => [
                /* 其它字段不要动 */
                'GoodsCode',
                'GoodsName',
                'SupplierName',
                'StoreName',
                'developer',
                'Purchaser',
                'possessMan1',
                'devDatetime',
                'achieveStatus',
                'DictionaryName',
                'completeStatus',
                /* 下面这段是加入的 */
                /*=============*/
                'cate' => [
                    'asc' => ['oa_goods.cate' => SORT_ASC],
                    'desc' => ['oa_goods.cate' => SORT_DESC],
                    'label' => '主分类'
                ],
                'subCate'=> [
                    'asc' => ['oa_goods.subCate' => SORT_ASC],
                    'desc' => ['oa_goods.subCate' => SORT_DESC],
                    'label' => '子分类'
                ],
                /*=============*/
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
            ->andFilterWhere(['like', 'picStatus', '已完善'])
            ->andFilterWhere(['like', 'AttributeName', $this->AttributeName])
            ->andFilterWhere(['like', 'cate', $this->cate])
            ->andFilterWhere(['like', 'subCate', $this->subCate])
;

        return $dataProvider;
    }
}
