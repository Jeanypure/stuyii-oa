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
            [['IbaySuffix'], 'string'],
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
            'IbaySuffix' => 'Ibay Suffix',
        ];
    }
}
