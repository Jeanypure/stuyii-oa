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
    public function rules()
    {
        return [
            [['pid','IsLiquid', 'IsPowder', 'isMagnetism', 'IsCharged'], 'integer'],
            [['developer','devDatetime','updateTime','achieveStatus','GoodsCode','GoodsName','SupplierName', 'AliasCnName','AliasEnName','PackName','description','Season','StoreName','DictionaryName','possessMan2'],'safe'],

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

        $query = OaGoodsinfo::find()->orderBy(['pid' => SORT_DESC])->where($condition);

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
            'IsPowder' => $this->IsPowder,
            'isMagnetism' => $this->isMagnetism,
            'IsCharged' => $this->IsCharged,
            'DictionaryName'=>$this->DictionaryName,
            'developer'=> $this->developer,
            'devDatetime'=>$this->devDatetime,
            'updateTime'=>$this->updateTime,



        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);
        $query->andFilterWhere(['like', 'AliasCnName', $this->AliasCnName]);

        return $dataProvider;
    }
}
