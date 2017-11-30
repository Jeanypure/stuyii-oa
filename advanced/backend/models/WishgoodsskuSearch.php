<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Wishgoodssku;

/**
 * WishgoodsskuSearch represents the model behind the search form about `backend\models\Wishgoodssku`.
 */
class WishgoodsskuSearch extends Wishgoodssku
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['itemid', 'pid', 'sid', 'inventory', 'goodsskuid'], 'integer'],
            [['sku', 'pSKU', 'color', 'size', 'shipping_time', 'linkurl'], 'safe'],
            [['price', 'shipping', 'msrp'], 'number'],
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
        $query = Wishgoodssku::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
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
            'itemid' => $this->itemid,
            'pid' => $this->pid,
            'sid' => $this->sid,
            'inventory' => $this->inventory,
            'price' => $this->price,
            'shipping' => $this->shipping,
            'msrp' => $this->msrp,
            'goodsskuid' => $this->goodsskuid,
        ]);

        $query->andFilterWhere(['like', 'sku', $this->sku])
            ->andFilterWhere(['like', 'pSKU', $this->pSKU])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'shipping_time', $this->shipping_time])
            ->andFilterWhere(['like', 'linkurl', $this->linkurl]);

        return $dataProvider;
    }
}
