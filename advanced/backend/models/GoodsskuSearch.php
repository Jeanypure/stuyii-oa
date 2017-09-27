<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Goodssku;

/**
 * GoodsskuSearch represents the model behind the search form about `backend\models\Goodssku`.
 */
class GoodsskuSearch extends Goodssku
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sid', 'pid'], 'integer'],
            [['sku', 'property1', 'property2', 'property3', 'memo1', 'memo2', 'memo3', 'memo4'], 'safe'],
            [['CostPrice', 'Weight', 'RetailPrice'], 'number'],
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
        $query = Goodssku::find();

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
            'sid' => $this->sid,
            'pid' => $this->pid,
            'CostPrice' => $this->CostPrice,
            'Weight' => $this->Weight,
            'RetailPrice' => $this->RetailPrice,
        ]);

        $query->andFilterWhere(['like', 'sku', $this->sku])
            ->andFilterWhere(['like', 'property1', $this->property1])
            ->andFilterWhere(['like', 'property2', $this->property2])
            ->andFilterWhere(['like', 'property3', $this->property3])
            ->andFilterWhere(['like', 'memo1', $this->memo1])
            ->andFilterWhere(['like', 'memo2', $this->memo2])
            ->andFilterWhere(['like', 'memo3', $this->memo3])
            ->andFilterWhere(['like', 'memo4', $this->memo4]);

        return $dataProvider;
    }
}
