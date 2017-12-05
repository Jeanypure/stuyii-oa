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
 * @property string $GoodsCode
 * @property string $achieveStatus
 * @property string $devDatetime
 * @property string $developer
 * @property string $updateTime
 * @property string $picStatus
 * @property integer $SupplierID
 * @property integer $StoreID
 * @property string $AttributeName
 * @property integer $bgoodsid
 * @completeStatus varchar $completeStatus
 */
class Channel extends \yii\db\ActiveRecord
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
            [['IsLiquid', 'IsPowder', 'isMagnetism', 'IsCharged', 'goodsid', 'SupplierID', 'StoreID', 'bgoodsid'], 'integer'],
            [['completeStatus','description', 'GoodsName', 'AliasCnName', 'AliasEnName', 'PackName', 'Season', 'DictionaryName', 'SupplierName', 'StoreName', 'Purchaser', 'possessMan1', 'possessMan2', 'picUrl', 'GoodsCode', 'achieveStatus', 'developer', 'picStatus', 'AttributeName','completeStatus'], 'string'],
            [['DeclaredValue'], 'number'],
            [['devDatetime', 'updateTime'], 'safe'],
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
            'GoodsName' => Yii::t('app', '商品名称'),
            'AliasCnName' => Yii::t('app', 'Alias Cn Name'),
            'AliasEnName' => Yii::t('app', 'Alias En Name'),
            'PackName' => Yii::t('app', 'Pack Name'),
            'Season' => Yii::t('app', 'Season'),
            'DictionaryName' => Yii::t('app', '禁售平台'),
            'SupplierName' => Yii::t('app', '供应商名称'),
            'StoreName' => Yii::t('app', '仓库'),
            'Purchaser' => Yii::t('app', '采购'),
            'possessMan1' => Yii::t('app', '美工'),
            'possessMan2' => Yii::t('app', 'Possess Man2'),
            'DeclaredValue' => Yii::t('app', 'Declared Value'),
            'picUrl' => Yii::t('app', '图片'),
            'goodsid' => Yii::t('app', 'Goodsid'),
            'GoodsCode' => Yii::t('app', '商品编码'),
            'achieveStatus' => Yii::t('app', 'Achieve Status'),
            'devDatetime' => Yii::t('app', '开发时间'),
            'developer' => Yii::t('app', '开发员'),
            'updateTime' => Yii::t('app', 'Update Time'),
            'picStatus' => Yii::t('app', 'Pic Status'),
            'SupplierID' => Yii::t('app', 'Supplier ID'),
            'StoreID' => Yii::t('app', 'Store ID'),
            'AttributeName' => Yii::t('app', 'Attribute Name'),
            'bgoodsid' => Yii::t('app', 'Bgoodsid'),
            'completeStatus' => Yii::t('app', '完成状况'),
            'cate' => Yii::t('app', '主类目'),
            'subCate' => Yii::t('app', '子类目'),
        ];
    }

    /**
     *  关联oa_Goods表
     */
    public function getoa_goods()
    {
        // hasOne要求返回两个参数 第一个参数是关联表的类名 第二个参数是两张表的关联关系
        // 这里uid是auth表关联id, 关联user表的uid id是当前模型的主键id
        return $this->hasOne(OaGoods::className(), ['nid' => 'goodsid']);
    }





}



