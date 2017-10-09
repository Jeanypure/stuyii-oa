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
            [['NID', 'CategoryID', 'Used'], 'integer'],
            [['DictionaryName', 'FitCode', 'Memo'], 'safe'],
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
            'NID' => $this->NID,
            'CategoryID' => $this->CategoryID,
            'Used' => $this->Used,
        ]);

        $query->andFilterWhere(['like', 'DictionaryName', $this->DictionaryName])
            ->andFilterWhere(['like', 'FitCode', $this->FitCode])
            ->andFilterWhere(['like', 'Memo', $this->Memo]);

        return $dataProvider;
    }
}
