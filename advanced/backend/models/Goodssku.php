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
 */
class Goodssku extends \yii\db\ActiveRecord
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
//            [['pid'], 'required'],
            [['pid'], 'integer'],
            [['sku', 'property1', 'property2', 'property3', 'memo1', 'memo2', 'memo3', 'memo4','CostPrice', 'Weight', 'RetailPrice','linkurl'], 'string'],
            [['linkurl','stockNum'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sid' => 'skuID',
            'pid' => '产品id',
            'sku' => 'Sku',
            'property1' => '颜色',
            'property2' => '大小',
            'property3' => '款式3',
            'CostPrice' => '成本价',
            'Weight' => '重量',
            'RetailPrice' => '零售价',
            'memo1' => '备注1',
            'memo2' => '备注2',
            'memo3' => '备注3',
            'memo4' => '备注4',
            'stockNum' => '备货数量',
        ];
    }
}
