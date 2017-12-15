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
     *
     */


    public $GoodsName; //<=====就是加在这里
    public $vendor1;
    public $vendor2;
    public $vendor3;

    public $origin1;
    public $origin2;
    public $origin3;

    public function rules()
    {
        return [
            [['pid','IsLiquid', 'IsPowder', 'isMagnetism', 'IsCharged'], 'integer'],

            [['picStatus','isVar','vendor1','vendor2','vendor3','developer','devDatetime','updateTime','achieveStatus','GoodsCode','GoodsName','SupplierName', 'AliasCnName','AliasEnName','PackName','description','Season','StoreName','DictionaryName','possessMan2','possessMan1'],'safe'],


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
     * @param array $condition
     *
     * @return ActiveDataProvider
     */
    public function search($params,$condition = [])
    {


        $query = OaGoodsinfo::find()->joinWith('oa_goods')->orderBy(['pid' => SORT_DESC])->where($condition);

 

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6,
            ],
        ]);

        // 增加关联字段的排序

//        $dataProvider->setSort([
//            'attributes' => [
//                /* 其它字段不要动 */
//                /* 下面这段是加入的 */
//                /*=============*/
//                'vendor1' => [
//                    'asc' => ['oa_goods.vendor1' => SORT_ASC],
//                    'desc' => ['oa_goods.vendor1' => SORT_DESC],
//                    'label' => '供应商连接1'
//                ],
//                /*=============*/
//            ]
//        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'pid' => $this->pid,
            'achieveStatus' => $this->achieveStatus,
            'GoodsCode' => $this->GoodsCode,
            'GoodsName'=>$this->GoodsName,
            'SupplierName' => $this->SupplierName,
            'AliasCnName'=>$this->AliasCnName,
            'AliasEnName'=>$this->AliasEnName,
            'PackName'=>$this->PackName,
            'description'=>$this->description,
            'StoreName'=>$this->StoreName,
            'Season'=>$this->Season,
            'IsLiquid' => $this->IsLiquid,
            'isMagnetism' => $this->isMagnetism,
            'IsCharged' => $this->IsCharged,
            'DictionaryName'=>$this->DictionaryName,
            'IsPowder' => $this->IsPowder,
            'devDatetime'=>$this->devDatetime,
            'updateTime'=>$this->updateTime,
            'vendor1' => $this->vendor1,
            'possessMan1' => $this->possessMan1,
            'picStatus' => $this->picStatus,
            'isVar' => $this->isVar,



        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);
        $query->andFilterWhere(['like', 'AliasCnName', $this->AliasCnName]);
        $query->andFilterWhere(['like', 'vendor1', $this->vendor1]);
        $query->andFilterWhere(['like', 'oa_goodsinfo.developer', $this->developer]);

        return $dataProvider;
    }
}
