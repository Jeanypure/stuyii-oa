<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OaEbayPaypal;

/**
 * EbayPaypalSearch represents the model behind the search form about `backend\models\OaEbayPaypal`.
 */
class EbayPaypalSearch extends OaEbayPaypal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nid'], 'integer'],
            [['ebayName', 'palpayName', 'mapType'], 'safe'],
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
        $query = OaEbayPaypal::find();

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
            'nid' => $this->nid,
        ]);

        $query->andFilterWhere(['like', 'ebayName', $this->ebayName])
            ->andFilterWhere(['like', 'palpayName', $this->palpayName])
            ->andFilterWhere(['like', 'mapType', $this->mapType]);

        return $dataProvider;
    }
}
