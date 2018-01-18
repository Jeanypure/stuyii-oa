<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%oa_wishgoods}}".
 *
 * @property integer $itemid
 * @property string $SKU
 * @property string $title
 * @property string $description
 * @property integer $inventory
 * @property string $price
 * @property string $msrp
 * @property string $shipping
 * @property string $shippingtime
 * @property string $tags
 * @property string $main_image
 * @property integer $goodsid
 * @property integer $infoid
 */
class OaWishgoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%oa_wishgoods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SKU', 'title', 'description', 'shippingtime', 'main_image','extra_images', 'headKeywords', 'requiredKeywords', 'randomKeywords', 'tailKeywords','wishtags'], 'string'],
            [['inventory', 'goodsid', 'infoid'], 'integer'],
            [['price', 'msrp', 'shipping'], 'number'],
            [['stockUp'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'itemid' => Yii::t('app', 'Itemid'),
            'SKU' => Yii::t('app', 'SKU'),
            'title' => Yii::t('app', '标题'),
            'description' => Yii::t('app', '描述'),
            'inventory' => Yii::t('app', '数量'),
            'price' => Yii::t('app', '价格'),
            'msrp' => Yii::t('app', '保留价'),
            'shipping' => Yii::t('app', '运费'),
            'shippingtime' => Yii::t('app', '运输时间'),
//            'tags' => Yii::t('app', '关键词tags'),
            'main_image' => Yii::t('app', '主图'),
            'extra_images' => Yii::t('app', '附加图'),
            'goodsid' => Yii::t('app', '商品ID'),
            'infoid' => Yii::t('app', 'Infoid'),
            'wishtags' => Yii::t('app', '关键词tags'),
            'stockUp' => Yii::t('app', '是否备货'),
        ];
    }
}
