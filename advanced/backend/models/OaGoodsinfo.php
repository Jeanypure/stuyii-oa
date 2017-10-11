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
 * @property integer $SupplierName
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
            [['IsLiquid', 'IsPowder', 'isMagnetism', 'IsCharged','goodsid'], 'integer'],
            [['description','SupplierName','Season','StoreName','PackName','DictionaryName','GoodsName'], 'string'],

            [['GoodsName','SupplierName', 'AliasCnName','AliasEnName','PackName','description',], 'required'],
            [['DictionaryName'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'picUrl' => '商品图片',
            'GoodsName' => '商品名称',
            'SupplierName' => '供应商名称',
            'AliasCnName' => '中文申报名',
            'AliasEnName' => '英文申报名',
            'PackName' => '规格',
            'description' => '描述',
            'Season' => '季节',
            'StoreName' => '仓库',
            'IsLiquid' => '是否液体',
            'IsPowder' => '是否粉末',
            'isMagnetism' => '是否带磁',
            'IsCharged' => '是否带电',


        ];
    }
}
