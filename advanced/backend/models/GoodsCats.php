<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;




/**
 * This is the model class for table "{{%B_GoodsCats}}".
 *
 * @property integer $NID
 * @property integer $CategoryLevel
 * @property string $CategoryName
 * @property integer $CategoryParentID
 * @property string $CategoryParentName
 * @property integer $CategoryOrder
 * @property string $CategoryCode
 * @property integer $GoodsCount
 */
class GoodsCats extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%B_GoodsCats}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CategoryLevel', 'CategoryParentID', 'CategoryOrder', 'GoodsCount'], 'integer'],
            [['CategoryName', 'CategoryParentName', 'CategoryCode'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'NID' => Yii::t('app', 'Nid'),
            'CategoryLevel' => Yii::t('app', 'Category Level'),
            'CategoryName' => Yii::t('app', 'Category Name'),
            'CategoryParentID' => Yii::t('app', 'Category Parent ID'),
            'CategoryParentName' => Yii::t('app', 'Category Parent Name'),
            'CategoryOrder' => Yii::t('app', 'Category Order'),
            'CategoryCode' => Yii::t('app', 'Category Code'),
            'GoodsCount' => Yii::t('app', 'Goods Count'),
        ];
    }


    public function getCityList($pid)
    {
        $model = GoodsCats::find()->where('CategoryParentID =:pid',[':pid'=>$pid])->all();
        return ArrayHelper::map($model,'NID','CategoryName');
    }






}
