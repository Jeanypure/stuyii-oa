<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\GoodsCats;

/**
 * GoodsCatsSearch represents the model behind the search form about `backend\models\GoodsCats`.
 */
class GoodsCatsSearch extends GoodsCats
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NID', 'CategoryLevel', 'CategoryParentID', 'CategoryOrder', 'GoodsCount'], 'integer'],
            [['CategoryName', 'CategoryParentName', 'CategoryCode'], 'safe'],
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
        $query = GoodsCats::find();

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
            'NID' => $this->NID,
            'CategoryLevel' => $this->CategoryLevel,
            'CategoryParentID' => $this->CategoryParentID,
            'CategoryOrder' => $this->CategoryOrder,
            'GoodsCount' => $this->GoodsCount,
        ]);

        $query->andFilterWhere(['like', 'CategoryName', $this->CategoryName])
            ->andFilterWhere(['like', 'CategoryParentName', $this->CategoryParentName])
            ->andFilterWhere(['like', 'CategoryCode', $this->CategoryCode]);

        return $dataProvider;
    }
}
