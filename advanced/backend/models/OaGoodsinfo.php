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
            [['IsLiquid', 'IsPowder', 'isMagnetism', 'IsCharged', 'SupplierID'], 'integer'],
            [['description'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
//            'pid' => 'Pid',
            'IsLiquid' => 'Is Liquid',
            'IsPowder' => 'Is Powder',
            'isMagnetism' => 'Is Magnetism',
            'IsCharged' => 'Is Charged',
            'SupplierID' => 'Supplier ID',
//            'description' => 'Description',
        ];
    }
}
