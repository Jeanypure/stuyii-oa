<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%oa_goodssku}}".
 *
 * @property integer $sid
 * @property integer $pid
 * @property string $sku
 * @property string $property1
 * @property string $property2
 * @property string $property3
 * @property string $CostPrice
 * @property double $Weight
 * @property string $RetailPrice
 * @property string $memo1
 * @property string $memo2
 * @property string $memo3
 * @property string $memo4
 * @property string $linkurl
 */
class Picinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%oa_goodssku}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid'], 'required'],
            [['pid'], 'integer'],
            [['sku', 'property1', 'property2', 'property3', 'memo1', 'memo2', 'memo3', 'memo4', 'linkurl'], 'string'],
            [['CostPrice', 'Weight', 'RetailPrice'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sid' => 'Sid',
            'pid' => 'Pid',
            'sku' => 'Sku',
            'property1' => 'Property1',
            'property2' => 'Property2',
            'property3' => 'Property3',
            'CostPrice' => 'Cost Price',
            'Weight' => 'Weight',
            'RetailPrice' => 'Retail Price',
            'memo1' => 'Memo1',
            'memo2' => 'Memo2',
            'memo3' => 'Memo3',
            'memo4' => 'Memo4',
            'linkurl' => '图片库链接',
        ];
    }
}
