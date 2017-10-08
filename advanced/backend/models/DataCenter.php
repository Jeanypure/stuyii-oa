<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%B_Goods}}".
 *
 * @property integer $NID
 * @property integer $GoodsCategoryID
 * @property string $CategoryCode
 * @property string $GoodsCode
 * @property string $GoodsName
 * @property string $ShopTitle
 * @property string $SKU
 * @property string $BarCode
 * @property string $FitCode
 * @property integer $MultiStyle
 * @property string $Material
 * @property string $Class
 * @property string $Model
 * @property string $Unit
 * @property string $Style
 * @property string $Brand
 * @property integer $LocationID
 * @property integer $Quantity
 * @property string $SalePrice
 * @property string $CostPrice
 * @property string $AliasCnName
 * @property string $AliasEnName
 * @property double $Weight
 * @property string $DeclaredValue
 * @property string $OriginCountry
 * @property string $OriginCountryCode
 * @property integer $ExpressID
 * @property integer $Used
 * @property string $BmpFileName
 * @property string $BmpUrl
 * @property integer $MaxNum
 * @property integer $MinNum
 * @property integer $GoodsCount
 * @property integer $SupplierID
 * @property string $Notes
 * @property integer $SampleFlag
 * @property integer $SampleCount
 * @property string $SampleMemo
 * @property string $CreateDate
 * @property integer $GroupFlag
 * @property string $SalerName
 * @property integer $SellCount
 * @property integer $SellDays
 * @property string $PackFee
 * @property string $PackName
 * @property string $GoodsStatus
 * @property string $DevDate
 * @property string $SalerName2
 * @property string $BatchPrice
 * @property string $MaxSalePrice
 * @property string $RetailPrice
 * @property string $MarketPrice
 * @property integer $PackageCount
 * @property string $ChangeStatusTime
 * @property integer $StockDays
 * @property integer $StoreID
 * @property string $Purchaser
 * @property string $LinkUrl
 * @property string $LinkUrl2
 * @property string $LinkUrl3
 * @property integer $StockMinAmount
 * @property string $MinPrice
 * @property string $HSCODE
 * @property string $ViewUser
 * @property string $InLong
 * @property string $InWide
 * @property string $InHigh
 * @property string $InGrossweight
 * @property string $InNetweight
 * @property string $OutLong
 * @property string $OutWide
 * @property string $OutHigh
 * @property string $OutGrossweight
 * @property string $OutNetweight
 * @property string $ShopCarryCost
 * @property string $ExchangeRate
 * @property string $WebCost
 * @property string $PackWeight
 * @property string $LogisticsCost
 * @property string $GrossRate
 * @property string $CalSalePrice
 * @property string $CalYunFei
 * @property string $CalSaleAllPrice
 * @property string $PackMsg
 * @property string $ItemUrl
 * @property integer $IsCharged
 * @property integer $DelInFile
 * @property string $Season
 * @property integer $IsPowder
 * @property integer $IsLiquid
 * @property string $possessMan1
 * @property string $possessMan2
 * @property string $LinkUrl4
 * @property string $LinkUrl5
 * @property string $LinkUrl6
 * @property integer $isMagnetism
 * @property string $NoSalesDate
 * @property string $NotUsedReason
 */
class DataCenter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%B_Goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GoodsCategoryID', 'MultiStyle', 'LocationID', 'Quantity', 'ExpressID', 'Used', 'MaxNum', 'MinNum', 'GoodsCount', 'SupplierID', 'SampleFlag', 'SampleCount', 'GroupFlag', 'SellCount', 'SellDays', 'PackageCount', 'StockDays', 'StoreID', 'StockMinAmount', 'IsCharged', 'DelInFile', 'IsPowder', 'IsLiquid', 'isMagnetism'], 'integer'],
            [['CategoryCode', 'GoodsCode', 'GoodsName', 'ShopTitle', 'SKU', 'BarCode', 'FitCode', 'Material', 'Class', 'Model', 'Unit', 'Style', 'Brand', 'AliasCnName', 'AliasEnName', 'OriginCountry', 'OriginCountryCode', 'BmpFileName', 'BmpUrl', 'Notes', 'SampleMemo', 'SalerName', 'PackName', 'GoodsStatus', 'SalerName2', 'Purchaser', 'LinkUrl', 'LinkUrl2', 'LinkUrl3', 'HSCODE', 'ViewUser', 'PackMsg', 'ItemUrl', 'Season', 'possessMan1', 'possessMan2', 'LinkUrl4', 'LinkUrl5', 'LinkUrl6', 'NotUsedReason'], 'string'],
            [['SalePrice', 'CostPrice', 'Weight', 'DeclaredValue', 'PackFee', 'BatchPrice', 'MaxSalePrice', 'RetailPrice', 'MarketPrice', 'MinPrice', 'InLong', 'InWide', 'InHigh', 'InGrossweight', 'InNetweight', 'OutLong', 'OutWide', 'OutHigh', 'OutGrossweight', 'OutNetweight', 'ShopCarryCost', 'ExchangeRate', 'WebCost', 'PackWeight', 'LogisticsCost', 'GrossRate', 'CalSalePrice', 'CalYunFei', 'CalSaleAllPrice'], 'number'],
            [['CreateDate', 'DevDate', 'ChangeStatusTime', 'NoSalesDate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'NID' => 'Nid',
            'GoodsCategoryID' => 'Goods Category ID',
            'CategoryCode' => 'Category Code',
            'GoodsCode' => 'Goods Code',
            'GoodsName' => 'Goods Name',
            'ShopTitle' => 'Shop Title',
            'SKU' => 'Sku',
            'BarCode' => 'Bar Code',
            'FitCode' => 'Fit Code',
            'MultiStyle' => 'Multi Style',
            'Material' => 'Material',
            'Class' => 'Class',
            'Model' => 'Model',
            'Unit' => 'Unit',
            'Style' => 'Style',
            'Brand' => 'Brand',
            'LocationID' => 'Location ID',
            'Quantity' => 'Quantity',
            'SalePrice' => 'Sale Price',
            'CostPrice' => 'Cost Price',
            'AliasCnName' => 'Alias Cn Name',
            'AliasEnName' => 'Alias En Name',
            'Weight' => 'Weight',
            'DeclaredValue' => 'Declared Value',
            'OriginCountry' => 'Origin Country',
            'OriginCountryCode' => 'Origin Country Code',
            'ExpressID' => 'Express ID',
            'Used' => 'Used',
            'BmpFileName' => 'Bmp File Name',
            'BmpUrl' => 'Bmp Url',
            'MaxNum' => 'Max Num',
            'MinNum' => 'Min Num',
            'GoodsCount' => 'Goods Count',
            'SupplierID' => 'Supplier ID',
            'Notes' => 'Notes',
            'SampleFlag' => 'Sample Flag',
            'SampleCount' => 'Sample Count',
            'SampleMemo' => 'Sample Memo',
            'CreateDate' => 'Create Date',
            'GroupFlag' => 'Group Flag',
            'SalerName' => 'Saler Name',
            'SellCount' => 'Sell Count',
            'SellDays' => 'Sell Days',
            'PackFee' => 'Pack Fee',
            'PackName' => 'Pack Name',
            'GoodsStatus' => 'Goods Status',
            'DevDate' => 'Dev Date',
            'SalerName2' => 'Saler Name2',
            'BatchPrice' => 'Batch Price',
            'MaxSalePrice' => 'Max Sale Price',
            'RetailPrice' => 'Retail Price',
            'MarketPrice' => 'Market Price',
            'PackageCount' => 'Package Count',
            'ChangeStatusTime' => 'Change Status Time',
            'StockDays' => 'Stock Days',
            'StoreID' => 'Store ID',
            'Purchaser' => 'Purchaser',
            'LinkUrl' => 'Link Url',
            'LinkUrl2' => 'Link Url2',
            'LinkUrl3' => 'Link Url3',
            'StockMinAmount' => 'Stock Min Amount',
            'MinPrice' => 'Min Price',
            'HSCODE' => 'Hscode',
            'ViewUser' => 'View User',
            'InLong' => 'In Long',
            'InWide' => 'In Wide',
            'InHigh' => 'In High',
            'InGrossweight' => 'In Grossweight',
            'InNetweight' => 'In Netweight',
            'OutLong' => 'Out Long',
            'OutWide' => 'Out Wide',
            'OutHigh' => 'Out High',
            'OutGrossweight' => 'Out Grossweight',
            'OutNetweight' => 'Out Netweight',
            'ShopCarryCost' => 'Shop Carry Cost',
            'ExchangeRate' => 'Exchange Rate',
            'WebCost' => 'Web Cost',
            'PackWeight' => 'Pack Weight',
            'LogisticsCost' => 'Logistics Cost',
            'GrossRate' => 'Gross Rate',
            'CalSalePrice' => 'Cal Sale Price',
            'CalYunFei' => 'Cal Yun Fei',
            'CalSaleAllPrice' => 'Cal Sale All Price',
            'PackMsg' => 'Pack Msg',
            'ItemUrl' => 'Item Url',
            'IsCharged' => 'Is Charged',
            'DelInFile' => 'Del In File',
            'Season' => 'Season',
            'IsPowder' => 'Is Powder',
            'IsLiquid' => 'Is Liquid',
            'possessMan1' => 'Possess Man1',
            'possessMan2' => 'Possess Man2',
            'LinkUrl4' => 'Link Url4',
            'LinkUrl5' => 'Link Url5',
            'LinkUrl6' => 'Link Url6',
            'isMagnetism' => 'Is Magnetism',
            'NoSalesDate' => 'No Sales Date',
            'NotUsedReason' => 'Not Used Reason',
        ];
    }
}
