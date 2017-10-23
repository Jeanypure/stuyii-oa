<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OaSysRules;

/**
 * OaSysRulesSearch represents the model behind the search form about `backend\models\OaSysRules`.
 */
class OaSysRulesSearch extends OaSysRules
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nid'], 'integer'],
            [['ruleName', 'ruleKey', 'ruleValue', 'ruleType'], 'safe'],
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
        $query = OaSysRules::find();

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

        $query->andFilterWhere(['like', 'ruleName', $this->ruleName])
            ->andFilterWhere(['like', 'ruleKey', $this->ruleKey])
            ->andFilterWhere(['like', 'ruleValue', $this->ruleValue])
            ->andFilterWhere(['like', 'ruleType', $this->ruleType]);

        return $dataProvider;
    }
}
