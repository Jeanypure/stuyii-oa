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
            [['sku', 'imageUrl', 'color', 'UPC', 'EAN'], 'string'],
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
            'quantity' => '数量',
            'retailPrice' => '价格',
            'imageUrl' => '图片地址',
            'color' => 'Color',
            'UPC' => 'UPC',
            'EAN' => 'EAN',
        ];
    }
}
