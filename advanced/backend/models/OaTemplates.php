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
 * @property string $IbayTemplate
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
            [['infoid','goodsid', 'prepareDay', 'quantity'], 'integer'],
            [['headKeywords','requiredKeywords','randomKeywords','tailKeywords','IbayTemplate','specifics','sku','mainPage','extraPage','location', 'country', 'postCode', 'site', 'listedCate', 'listedSubcate', 'title', 'subTitle', 'description', 'UPC', 'EAN', 'Brand', 'MPN', 'Color', 'Type', 'Material', 'IntendedUse', 'unit', 'bundleListing', 'shape', 'features', 'regionManufacture', 'reserveField', 'InshippingMethod1', 'InshippingMethod2', 'OutshippingMethod1', 'OutShiptoCountry1', 'OutshippingMethod2', 'OutShiptoCountry2'], 'string'],
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
            'infoid' => 'infoid',
            'goodsid' => '产品编号',
            'sku' => 'SKU',
            'mainPage' => '主图',
            'extraPage' => '附加图',
            'location' => '商品所在地',
            'country' => '国家',
            'postCode' => '邮编',
            'prepareDay' => '备货天数',
            'site' => '站点',
            'listedCate' => '刊登分类',
            'listedSubcate' => '刊登分类2',
            'title' => '标题',
            'subTitle' => '子标题',
            'description' => '描述',
            'quantity' => '数量',
            'nowPrice' => '一口价',
            'UPC' => 'UPC',
            'EAN' => 'EAN',
            'Brand' => 'Brand',
            'MPN' => 'MPN',
            'Color' => 'Color',
            'Type' => 'Type',
            'Material' => 'Material',
            'IntendedUse' => 'Intended Use',
            'unit' => 'Unit',
            'bundleListing' => 'Bundle Listing',
            'shape' => 'Shape',
            'features' => 'Features',
            'regionManufacture' => 'Country/Region Manufacture',
            'reserveField' => 'Reserve Field',
            'InshippingMethod1' => '运输方式1',
            'InFirstCost1' => '首件运费',
            'InSuccessorCost1' => '续件运费',
            'InshippingMethod2' => '运输方式2',
            'InFirstCost2' => '首件运费',
            'InSuccessorCost2' => '续建运费',
            'OutshippingMethod1' => '运输方式1',
            'OutFirstCost1' => '首件运费',
            'OutSuccessorCost1' => '续件运费',
            'OutShiptoCountry1' => '可运送至国家',
            'OutshippingMethod2' => '运输方式2',
            'OutFirstCost2' => '首件运费',
            'OutSuccessorCost2' => '续件运费',
            'OutShiptoCountry2' => '可运送至国家',
            'specifics' => '物品属性',
            'IbayTemplate' => '刊登风格',
            'headKeywords' => '最前关键词',
            'requiredKeywords' => '最前关键词',
            'randomKeywords' => '最前关键词',
            'tailKeywords' => '最前关键词',
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
