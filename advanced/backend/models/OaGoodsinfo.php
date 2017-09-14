<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "oa_goodsinfo".
 *
 * @property integer $pid
 * @property integer $IsLiquid
 * @property integer $IsPowder
 * @property integer $isMagnetism
 * @property integer $IsCharged
 * @property integer $SupplierID
 * @property string $description
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
 */
class OaGoodsinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oa_goodsinfo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IsLiquid', 'IsPowder', 'isMagnetism', 'IsCharged', 'SupplierID', 'SampleFlag', 'SampleCount', 'GroupFlag', 'SellCount', 'SellDays', 'PackageCount', 'StockDays', 'StoreID'], 'integer'],
            [['description', 'Notes', 'SampleMemo', 'SalerName', 'PackName', 'GoodsStatus', 'SalerName2', 'Purchaser', 'LinkUrl', 'LinkUrl2', 'LinkUrl3'], 'string'],
            [['CreateDate', 'DevDate', 'ChangeStatusTime'], 'safe'],
            [['PackFee', 'BatchPrice', 'MaxSalePrice', 'RetailPrice', 'MarketPrice'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pid' => 'Pid',
            'IsLiquid' => 'Is Liquid',
            'IsPowder' => 'Is Powder',
            'isMagnetism' => 'Is Magnetism',
            'IsCharged' => 'Is Charged',
            'SupplierID' => 'Supplier ID',
            'description' => 'Description',
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
        ];
    }
}
