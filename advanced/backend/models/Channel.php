<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%B_Dictionary}}".
 *
 * @property integer $NID
 * @property integer $CategoryID
 * @property string $DictionaryName
 * @property string $FitCode
 * @property integer $Used
 * @property string $Memo
 */
class Channel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%B_Dictionary}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CategoryID', 'Used'], 'integer'],
            [['DictionaryName', 'FitCode', 'Memo'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'NID' => 'Nid',
            'CategoryID' => 'Category ID',
            'DictionaryName' => '平台信息',
            'FitCode' => 'Fit Code',
            'Used' => 'Used',
            'Memo' => 'Memo',
        ];
    }
}
