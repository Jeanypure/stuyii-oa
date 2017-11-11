<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%oa_templates}}".
 *
 * @property integer $nid
 * @property integer $goodsid
 * @property string $location
 * @property string $country
 * @property string $postCode
 * @property integer $prepareDay
 * @property string $site
 * @property string $listedCate
 * @property string $listedSubcate
 * @property string $title
 * @property string $subTitle
 * @property string $description
 * @property integer $quantity
 * @property string $nowPrice
 * @property string $UPC
 * @property string $EAN
 * @property string $Brand
 * @property string $MPN
 * @property string $Color
 * @property string $Type
 * @property string $Material
 * @property string $IntendedUse
 * @property string $unit
 * @property string $bundleListing
 * @property string $shape
 * @property string $features
 * @property string $regionManufacture
 * @property string $reserveField
 * @property string $InshippingMethod1
 * @property string $InFirstCost1
 * @property string $InSuccessorCost1
 * @property string $InshippingMethod2
 * @property string $InFirstCost2
 * @property string $InSuccessorCost2
 * @property string $OutshippingMethod1
 * @property string $OutFirstCost1
 * @property string $OutSuccessorCost1
 * @property string $OutShiptoCountry1
 * @property string $OutshippingMethod2
 * @property string $OutFirstCost2
 * @property string $OutSuccessorCost2
 * @property string $OutShiptoCountry2
 */
class OaTemplates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%oa_templates}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goodsid', 'prepareDay', 'quantity'], 'integer'],
            [['location', 'country', 'postCode', 'site', 'listedCate', 'listedSubcate', 'title', 'subTitle', 'description', 'UPC', 'EAN', 'Brand', 'MPN', 'Color', 'Type', 'Material', 'IntendedUse', 'unit', 'bundleListing', 'shape', 'features', 'regionManufacture', 'reserveField', 'InshippingMethod1', 'InshippingMethod2', 'OutshippingMethod1', 'OutShiptoCountry1', 'OutshippingMethod2', 'OutShiptoCountry2'], 'string'],
            [['nowPrice', 'InFirstCost1', 'InSuccessorCost1', 'InFirstCost2', 'InSuccessorCost2', 'OutFirstCost1', 'OutSuccessorCost1', 'OutFirstCost2', 'OutSuccessorCost2'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nid' => 'Nid',
            'goodsid' => 'Goodsid',
            'location' => 'Location',
            'country' => 'Country',
            'postCode' => 'Post Code',
            'prepareDay' => 'Prepare Day',
            'site' => 'Site',
            'listedCate' => 'Listed Cate',
            'listedSubcate' => 'Listed Subcate',
            'title' => 'Title',
            'subTitle' => 'Sub Title',
            'description' => 'Description',
            'quantity' => 'Quantity',
            'nowPrice' => 'Now Price',
            'UPC' => 'Upc',
            'EAN' => 'Ean',
            'Brand' => 'Brand',
            'MPN' => 'Mpn',
            'Color' => 'Color',
            'Type' => 'Type',
            'Material' => 'Material',
            'IntendedUse' => 'Intended Use',
            'unit' => 'Unit',
            'bundleListing' => 'Bundle Listing',
            'shape' => 'Shape',
            'features' => 'Features',
            'regionManufacture' => 'Region Manufacture',
            'reserveField' => 'Reserve Field',
            'InshippingMethod1' => 'Inshipping Method1',
            'InFirstCost1' => 'In First Cost1',
            'InSuccessorCost1' => 'In Successor Cost1',
            'InshippingMethod2' => 'Inshipping Method2',
            'InFirstCost2' => 'In First Cost2',
            'InSuccessorCost2' => 'In Successor Cost2',
            'OutshippingMethod1' => 'Outshipping Method1',
            'OutFirstCost1' => 'Out First Cost1',
            'OutSuccessorCost1' => 'Out Successor Cost1',
            'OutShiptoCountry1' => 'Out Shipto Country1',
            'OutshippingMethod2' => 'Outshipping Method2',
            'OutFirstCost2' => 'Out First Cost2',
            'OutSuccessorCost2' => 'Out Successor Cost2',
            'OutShiptoCountry2' => 'Out Shipto Country2',
        ];
    }

    /**
     * @inheritdoc
     * @return OaTemplatesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OaTemplatesQuery(get_called_class());
    }
}
