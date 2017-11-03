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
            [['picStatus','updateTime','developer','devDatetime','GoodsCode','achieveStatus','description','SupplierName','Season','StoreName','PackName','DictionaryName','GoodsName'], 'string'],

            [['GoodsName','SupplierName', 'AliasCnName','AliasEnName','PackName','description',], 'required'],
            [['DictionaryName','vendor1'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'picUrl' => '商品图片',
            'GoodsCode' => '商品编码',
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
            'possessMan2' => '美工',
            'achieveStatus' => '进度状态',
            'devDatetime' => '开发时间',
            'achieveStatus' => '属性状态',
            'picStatus' => '图片状态',
            'developer' => '开发员'


        ];
    }

// 关联2张表 oa_goodsinfo ,oa_goods
    public function getOaGoods()
    {
        // 第一个参数为要关联的子表模型类名，
        // 第二个参数指定 通过子表的customer_id，关联主表的id字段
        return $this->hasOne(OaGoods::className(), ['nid'=>'pid']);
    }
}
