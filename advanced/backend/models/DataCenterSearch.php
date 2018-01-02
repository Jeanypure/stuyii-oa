<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DataCenter;

/**
 * DataCenterSearch represents the model behind the search form about `backend\models\DataCenter`.
 */
class DataCenterSearch extends DataCenter
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NID', 'GoodsCategoryID', 'MultiStyle', 'LocationID', 'Quantity', 'ExpressID', 'Used', 'MaxNum', 'MinNum', 'GoodsCount', 'SupplierID', 'SampleFlag', 'SampleCount', 'GroupFlag', 'SellCount', 'SellDays', 'PackageCount', 'StockDays', 'StoreID', 'StockMinAmount', 'IsCharged', 'DelInFile', 'IsPowder', 'IsLiquid', 'isMagnetism'], 'integer'],
            [['CategoryCode', 'GoodsCode', 'GoodsName', 'ShopTitle', 'SKU', 'BarCode', 'FitCode', 'Material', 'Class', 'Model', 'Unit', 'Style', 'Brand', 'AliasCnName', 'AliasEnName', 'OriginCountry', 'OriginCountryCode', 'BmpFileName', 'BmpUrl', 'Notes', 'SampleMemo', 'CreateDate', 'SalerName', 'PackName', 'GoodsStatus', 'DevDate', 'SalerName2', 'ChangeStatusTime', 'Purchaser', 'LinkUrl', 'LinkUrl2', 'LinkUrl3', 'HSCODE', 'ViewUser', 'PackMsg', 'ItemUrl', 'Season', 'possessMan1', 'possessMan2', 'LinkUrl4', 'LinkUrl5', 'LinkUrl6', 'NoSalesDate', 'NotUsedReason'], 'safe'],
            [['SalePrice', 'CostPrice', 'Weight', 'DeclaredValue', 'PackFee', 'BatchPrice', 'MaxSalePrice', 'RetailPrice', 'MarketPrice', 'MinPrice', 'InLong', 'InWide', 'InHigh', 'InGrossweight', 'InNetweight', 'OutLong', 'OutWide', 'OutHigh', 'OutGrossweight', 'OutNetweight', 'ShopCarryCost', 'ExchangeRate', 'WebCost', 'PackWeight', 'LogisticsCost', 'GrossRate', 'CalSalePrice', 'CalYunFei', 'CalSaleAllPrice'], 'number'],
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
        $query = DataCenter::find();

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
            'GoodsCategoryID' => $this->GoodsCategoryID,
            'MultiStyle' => $this->MultiStyle,
            'LocationID' => $this->LocationID,
            'Quantity' => $this->Quantity,
            'SalePrice' => $this->SalePrice,
            'CostPrice' => $this->CostPrice,
            'Weight' => $this->Weight,
            'DeclaredValue' => $this->DeclaredValue,
            'ExpressID' => $this->ExpressID,
            'Used' => $this->Used,
            'MaxNum' => $this->MaxNum,
            'MinNum' => $this->MinNum,
            'GoodsCount' => $this->GoodsCount,
            'SupplierID' => $this->SupplierID,
            'SampleFlag' => $this->SampleFlag,
            'SampleCount' => $this->SampleCount,
            'CreateDate' => $this->CreateDate,
            'GroupFlag' => $this->GroupFlag,
            'SellCount' => $this->SellCount,
            'SellDays' => $this->SellDays,
            'PackFee' => $this->PackFee,
            'DevDate' => $this->DevDate,
            'BatchPrice' => $this->BatchPrice,
            'MaxSalePrice' => $this->MaxSalePrice,
            'RetailPrice' => $this->RetailPrice,
            'MarketPrice' => $this->MarketPrice,
            'PackageCount' => $this->PackageCount,
            'ChangeStatusTime' => $this->ChangeStatusTime,
            'StockDays' => $this->StockDays,
            'StoreID' => $this->StoreID,
            'StockMinAmount' => $this->StockMinAmount,
            'MinPrice' => $this->MinPrice,
            'InLong' => $this->InLong,
            'InWide' => $this->InWide,
            'InHigh' => $this->InHigh,
            'InGrossweight' => $this->InGrossweight,
            'InNetweight' => $this->InNetweight,
            'OutLong' => $this->OutLong,
            'OutWide' => $this->OutWide,
            'OutHigh' => $this->OutHigh,
            'OutGrossweight' => $this->OutGrossweight,
            'OutNetweight' => $this->OutNetweight,
            'ShopCarryCost' => $this->ShopCarryCost,
            'ExchangeRate' => $this->ExchangeRate,
            'WebCost' => $this->WebCost,
            'PackWeight' => $this->PackWeight,
            'LogisticsCost' => $this->LogisticsCost,
            'GrossRate' => $this->GrossRate,
            'CalSalePrice' => $this->CalSalePrice,
            'CalYunFei' => $this->CalYunFei,
            'CalSaleAllPrice' => $this->CalSaleAllPrice,
            'IsCharged' => $this->IsCharged,
            'DelInFile' => $this->DelInFile,
            'IsPowder' => $this->IsPowder,
            'IsLiquid' => $this->IsLiquid,
            'isMagnetism' => $this->isMagnetism,
            'NoSalesDate' => $this->NoSalesDate,
        ]);

        $query->andFilterWhere(['like', 'CategoryCode', $this->CategoryCode])
            ->andFilterWhere(['like', 'GoodsCode', $this->GoodsCode])
            ->andFilterWhere(['like', 'GoodsName', $this->GoodsName])
            ->andFilterWhere(['like', 'ShopTitle', $this->ShopTitle])
            ->andFilterWhere(['like', 'SKU', $this->SKU])
            ->andFilterWhere(['like', 'BarCode', $this->BarCode])
            ->andFilterWhere(['like', 'FitCode', $this->FitCode])
            ->andFilterWhere(['like', 'Material', $this->Material])
            ->andFilterWhere(['like', 'Class', $this->Class])
            ->andFilterWhere(['like', 'Model', $this->Model])
            ->andFilterWhere(['like', 'Unit', $this->Unit])
            ->andFilterWhere(['like', 'Style', $this->Style])
            ->andFilterWhere(['like', 'Brand', $this->Brand])
            ->andFilterWhere(['like', 'AliasCnName', $this->AliasCnName])
            ->andFilterWhere(['like', 'AliasEnName', $this->AliasEnName])
            ->andFilterWhere(['like', 'OriginCountry', $this->OriginCountry])
            ->andFilterWhere(['like', 'OriginCountryCode', $this->OriginCountryCode])
            ->andFilterWhere(['like', 'BmpFileName', $this->BmpFileName])
            ->andFilterWhere(['like', 'BmpUrl', $this->BmpUrl])
            ->andFilterWhere(['like', 'Notes', $this->Notes])
            ->andFilterWhere(['like', 'SampleMemo', $this->SampleMemo])
            ->andFilterWhere(['like', 'SalerName', $this->SalerName])
            ->andFilterWhere(['like', 'PackName', $this->PackName])
            ->andFilterWhere(['like', 'GoodsStatus', $this->GoodsStatus])
            ->andFilterWhere(['like', 'SalerName2', $this->SalerName2])
            ->andFilterWhere(['like', 'Purchaser', $this->Purchaser])
            ->andFilterWhere(['like', 'LinkUrl', $this->LinkUrl])
            ->andFilterWhere(['like', 'LinkUrl2', $this->LinkUrl2])
            ->andFilterWhere(['like', 'LinkUrl3', $this->LinkUrl3])
            ->andFilterWhere(['like', 'HSCODE', $this->HSCODE])
            ->andFilterWhere(['like', 'ViewUser', $this->ViewUser])
            ->andFilterWhere(['like', 'PackMsg', $this->PackMsg])
            ->andFilterWhere(['like', 'ItemUrl', $this->ItemUrl])
            ->andFilterWhere(['like', 'Season', $this->Season])
            ->andFilterWhere(['like', 'possessMan1', $this->possessMan1])
            ->andFilterWhere(['like', 'possessMan2', $this->possessMan2])
            ->andFilterWhere(['like', 'LinkUrl4', $this->LinkUrl4])
            ->andFilterWhere(['like', 'LinkUrl5', $this->LinkUrl5])
            ->andFilterWhere(['like', 'LinkUrl6', $this->LinkUrl6])
            ->andFilterWhere(['like', 'NotUsedReason', $this->NotUsedReason]);

        return $dataProvider;
    }
}
