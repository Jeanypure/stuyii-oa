<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "oa_sysRules".
 *
 * @property integer $nid
 * @property string $ruleName
 * @property string $ruleKey
 * @property string $ruleValue
 * @property string $ruleType
 */
class OaSysRules extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oa_sysRules';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ruleName', 'ruleKey', 'ruleValue', 'ruleType'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nid' => Yii::t('app', 'Nid'),
            'ruleName' => Yii::t('app', 'Rule Name'),
            'ruleKey' => Yii::t('app', 'Rule Key'),
            'ruleValue' => Yii::t('app', 'Rule Value'),
            'ruleType' => Yii::t('app', 'Rule Type'),
        ];
    }
}
