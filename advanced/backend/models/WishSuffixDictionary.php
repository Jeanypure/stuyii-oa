<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%Oa_WishSuffixDictionary}}".
 *
 * @property integer $NID
 * @property string $IbaySuffix
 */
class WishSuffixDictionary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%Oa_WishSuffixDictionary}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IbaySuffix'], 'required'],
            [['IbaySuffix', 'ShortName', 'MainImg', 'Suffix'], 'string'],
            [['Rate'], 'number'],
            [['IbaySuffix'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'NID' => 'Nid',
            'IbaySuffix' => 'Ibay账号简称',
            'ShortName' => '普元简称',
            'Suffix' => '后缀',
            'Rate' => '运费比例',
            'MainImg' => '主图名称',
        ];
    }
}
