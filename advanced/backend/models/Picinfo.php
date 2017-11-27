<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%oa_goodsinfo}}".
 *
 * @property integer $pid
 * @property integer $IsLiquid
 * @property integer $IsPowder
 * @property integer $isMagnetism
 * @property integer $IsCharged
 * @property string $description
 * @property string $GoodsName
 * @property string $AliasCnName
 * @property string $AliasEnName
 * @property string $PackName
 * @property string $Season
 * @property string $DictionaryName
 * @property string $SupplierName
 * @property string $StoreName
 * @property string $Purchaser
 * @property string $possessMan1
 * @property string $possessMan2
 * @property string $DeclaredValue
 * @property string $picUrl
 * @property integer $goodsid
 */
class Picinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%oa_goodsinfo}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IsLiquid', 'IsPowder', 'isMagnetism', 'IsCharged', 'goodsid'], 'integer'],
            [['description', 'GoodsName', 'AliasCnName', 'AliasEnName', 'PackName', 'Season', 'DictionaryName', 'SupplierName', 'StoreName', 'Purchaser', 'possessMan1', 'possessMan2', 'picUrl'], 'string'],
            [['DeclaredValue'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pid' => Yii::t('app', 'Pid'),
            'IsLiquid' => Yii::t('app', 'Is Liquid'),
            'IsPowder' => Yii::t('app', 'Is Powder'),
            'isMagnetism' => Yii::t('app', 'Is Magnetism'),
            'IsCharged' => Yii::t('app', 'Is Charged'),
            'description' => Yii::t('app', 'Description'),
            'GoodsName' => Yii::t('app', 'Goods Name'),
            'AliasCnName' => Yii::t('app', 'Alias Cn Name'),
            'AliasEnName' => Yii::t('app', 'Alias En Name'),
            'PackName' => Yii::t('app', 'Pack Name'),
            'Season' => Yii::t('app', 'Season'),
            'DictionaryName' => Yii::t('app', 'Dictionary Name'),
            'SupplierName' => Yii::t('app', 'Supplier Name'),
            'StoreName' => Yii::t('app', 'Store Name'),
            'Purchaser' => Yii::t('app', 'Purchaser'),
            'possessMan1' => Yii::t('app', '美工'),
            'possessMan2' => Yii::t('app', 'Possess Man2'),
            'DeclaredValue' => Yii::t('app', 'Declared Value'),
            'picUrl' => Yii::t('app', 'Pic Url'),
            'goodsid' => Yii::t('app', 'Goodsid'),
        ];
    }

    //oa_goodsinfo 关联oa_goods  获取 类别
    public function getoa_goods()
    {
        //同样第一个参数指定关联的子表模型类名
        return $this->hasOne(OaGoods::className(), ['nid' => 'goodsid']);
    }
}
