<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "oa_templatesVar".
 *
 * @property integer $nid
 * @property integer $tid
 * @property string $sku
 * @property integer $quantity
 * @property string $retailPrice
 * @property string $imageUrl
 * @property string $color
 * @property string $UPC
 * @property string $EAN
 */
class OaTemplatesVar extends \yii\db\ActiveRecord
{
    public $image;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oa_templatesVar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tid', 'quantity'], 'integer'],
            [['property','picProperty','sku', 'imageUrl','image', 'property1','property2','property3', 'UPC', 'EAN'], 'string'],
            [['retailPrice'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nid' => 'Nid',
            'tid' => 'Tid',
            'sku' => 'Sku',
            'property' => 'Property',
            'picProperty' => '关联属性',
            'quantity' => '数量',
            'retailPrice' => '价格',
            'imageUrl' => '图片地址',
            'image' => '图片',
            'property1' => '款式-1',
            'property2' => '款式-2',
            'property3' => '款式-3',
            'UPC' => 'UPC',
            'EAN' => 'EAN',
        ];
    }
}
