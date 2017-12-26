<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * WishSuffixDictionarySearch represents the model behind the search form about `backend\models\WishSuffixDictionary`.
 */
class EbaySuffixDictionarySearch extends OaEbaySuffix
{
    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['nid'], 'integer'],
            [['ebayName', 'ebaySuffix', 'nameCode', 'mainImg', 'ibayTemplate', 'mapType', 'highEbayPaypal', 'lowEbayPaypal'], 'safe']
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
        $query = OaEbaySuffix::find()
            ->select("oa_ebay_suffix.nid,min(oa_ebay_suffix.ebayName) as ebayName,min(oa_ebay_suffix.nameCode) as nameCode,min(oa_ebay_suffix.ebaySuffix) as ebaySuffix,max(oa_ebay_suffix.mainImg) as mainImg,max(oa_ebay_suffix.ibayTemplate) as ibayTemplate,min(oa_paypal.paypalName) as paypalName")
            ->joinWith('ebayPayPal')
            ->joinWith('payPal')
            ->groupBy('oa_ebay_suffix.nid,ebayName,nameCode,ebaySuffix,mainImg,ibayTemplate');
            //->groupBy('oa_ebay_suffix.nid,oa_ebay_suffix.ebayName,oa_ebay_suffix.nameCode,oa_ebay_suffix.ebaySuffix');
            //->select('*');
        //var_dump($query->asArray()->all());exit;
        //var_dump($query->createCommand()->getRawSql());exit;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'defaultOrder' => [
                //'capital' => SORT_DESC,
                'nid' => SORT_DESC,
            ],
            'attributes' => [
                'nid' => [
                    'asc' => ['oa_ebay_suffix.nid' => SORT_ASC],
                    'desc' => ['oa_ebay_suffix.nid' => SORT_DESC],
                ],
                'ebayName' => [
                    'asc' => ['ebayName' => SORT_ASC],
                    'desc' => ['ebayName' => SORT_DESC],
                ],
                'nameCode' => [
                    'asc' => ['nameCode' => SORT_ASC],
                    'desc' => ['nameCode' => SORT_DESC],
                ],
                'ebaySuffix' => [
                    'asc' => ['ebaySuffix' => SORT_ASC],
                    'desc' => ['ebaySuffix' => SORT_DESC],
                ],
                'mainImg' => [
                    'asc' => ['mainImg' => SORT_ASC],
                    'desc' => ['mainImg' => SORT_DESC],
                ],
                'ibayTemplate' => [
                    'asc' => ['ibayTemplate' => SORT_ASC],
                    'desc' => ['ibayTemplate' => SORT_DESC],
                ],
                /*'highEbayPaypal' => [
                    'asc' => ['oa_paypal.paypalName' => SORT_ASC],
                    'desc' => ['oa_paypal.paypalName' => SORT_DESC],
                ],
                'lowEbayPaypal' => [
                    'asc' => ['oa_paypal.paypalName' => SORT_ASC],
                    'desc' => ['oa_paypal.paypalName' => SORT_DESC],
                ],*/
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
            'nid' => $this->nid,
        ]);

        $query->andFilterWhere(['like', 'ebayName', $this->ebayName]);
        $query->andFilterWhere(['like', 'ebaySuffix', $this->ebaySuffix]);
        $query->andFilterWhere(['like', 'nameCode', $this->nameCode]);
        $query->andFilterWhere(['like', 'mainImg', $this->mainImg]);
        $query->andFilterWhere(['like', 'ibayTemplate', $this->ibayTemplate]);
        //var_dump($this->highEbayPaypal);exit;
        if($this->highEbayPaypal){
            $query->andFilterWhere(['and', ['like', 'oa_paypal.paypalName', $this->highEbayPaypal],['oa_ebay_paypal.mapType' => 'high']]);
        }
        if($this->lowEbayPaypal){
            $query->andFilterWhere(['and', ['like', 'oa_paypal.paypalName', $this->lowEbayPaypal],['oa_ebay_paypal.mapType' => 'low']]);
        }
        return $dataProvider;
    }
}
