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

class OaGoodsinfo extends GoodsCats
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
            [['headKeywords','requiredKeywords','randomKeywords','tailKeywords','isVar','completeStatus','picStatus','updateTime','developer','devDatetime','GoodsCode','achieveStatus','description','SupplierName','Season','StoreName','PackName','DictionaryName','GoodsName'], 'string'],
            [['StoreName','GoodsName','SupplierName', 'AliasCnName','AliasEnName','PackName','description',], 'required'],
            [['wishtags','completeStatus','DictionaryName','vendor1'],'safe'],
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
            'possessMan2' => '责任人2',
            'achieveStatus' => '进度状态',
            'devDatetime' => '开发时间',
            'achieveStatus' => '属性状态',
            'picStatus' => '图片状态',
            'developer' => '开发员',
            'Purchaser' => '采购',
            'possessMan1' => '美工',
            'vendor1' => '供应商链接1',
            'isVar' => '是否多属性',
            'headKeywords' => '最前关键词',
            'requiredKeywords' => '必选关键词',
            'randomKeywords' => '随机关键词',
            'tailKeywords' => '最后关键词',



        ];

    }

    //oa_goodsinfo 关联oa_goods
    public function getoa_goods()
    {
        //同样第一个参数指定关联的子表模型类名
        return $this->hasOne(OaGoods::className(), ['nid' => 'goodsid']);
    }


    //关联oa_goodssku
    public function getgoodssku(){
        return $this->hasMany(Goodssku::className(),['pid' => 'pid']);
    }


}
