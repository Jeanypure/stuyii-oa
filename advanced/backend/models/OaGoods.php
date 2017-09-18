<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "oa_goods".
 *
 * @property integer $nid
 * @property integer $img
 * @property string $cate
 * @property string $devNum
 * @property string $origin
 * @property string $hopeProfit
 * @property string $develpoer
 * @property string $introducer
 * @property string $devStatus
 * @property string $checkStatus
 * @property string $createDate
 * @property string $updateDate
 */
class OaGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oa_goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['img','cate', 'devNum', 'origin', 'develpoer', 'introducer', 'devStatus', 'checkStatus'], 'string'],
            [['hopeProfit'], 'number'],
            [['createDate', 'updateDate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nid' => '编号',
            'img' => '图片',
            'cate' => '主类目',
            'devNum' => '开发编号',
            'origin' => '参考链接',
            'hopeProfit' => '预估毛利',
            'develpoer' => '开发者',
            'introducer' => '推荐人',
            'devStatus' => '认领',
            'checkStatus' => '审核',
            'createDate' => '创建时间',
            'updateDate' => '更新时间',
        ];
    }
}
