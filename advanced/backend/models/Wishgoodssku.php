<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%oa_wishgoodssku}}".
 *
 * @property integer $itemid
 * @property integer $pid
 * @property integer $sid
 * @property string $sku
 * @property string $pSKU
 * @property string $color
 * @property string $size
 * @property integer $inventory
 * @property string $price
 * @property string $shipping
 * @property string $msrp
 * @property string $shipping_time
 * @property string $linkurl
 * @property integer $goodsskuid
 */
class Wishgoodssku extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%oa_wishgoodssku}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'sid', 'inventory', 'goodsskuid'], 'integer'],
            [['sku', 'pSKU', 'color', 'size', 'shipping_time', 'linkurl'], 'string'],
            [['price', 'shipping', 'msrp'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
//            'itemid' => Yii::t('app', 'Itemid'),
            'pid' => Yii::t('app', 'Pid'),
            'sid' => Yii::t('app', 'Sid'),
            'sku' => Yii::t('app', 'Sku'),
            'pSKU' => Yii::t('app', 'P Sku'),
            'color' => Yii::t('app', 'Color'),
            'size' => Yii::t('app', 'Size'),
            'inventory' => Yii::t('app', 'Inventory'),
            'price' => Yii::t('app', 'Price'),
            'shipping' => Yii::t('app', 'Shipping'),
            'msrp' => Yii::t('app', 'Msrp'),
            'shipping_time' => Yii::t('app', 'Shipping Time'),
            'linkurl' => Yii::t('app', 'Linkurl'),
            'goodsskuid' => Yii::t('app', 'Goodsskuid'),
        ];
    }
}
