<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\WishSuffixDictionary;

/**
 * WishSuffixDictionarySearch represents the model behind the search form about `backend\models\WishSuffixDictionary`.
 */
class WishSuffixDictionarySearch extends WishSuffixDictionary
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NID'], 'integer'],
            [['Rate'], 'number'],
            [['IbaySuffix', 'ShortName', 'MainImg', 'Suffix'], 'safe'],
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
        $query = WishSuffixDictionary::find()->orderBy('NID DESC');

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
        ]);

        $query->andFilterWhere(['like', 'IbaySuffix', $this->IbaySuffix]);
        $query->andFilterWhere(['like', 'ShortName', $this->ShortName]);
        $query->andFilterWhere(['like', 'Suffix', $this->Suffix]);
        $query->andFilterWhere(['like', 'Rate', $this->Rate]);
        $query->andFilterWhere(['like', 'MainImg', $this->MainImg]);


        return $dataProvider;
    }
}
