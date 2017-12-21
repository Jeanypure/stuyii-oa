<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "oa_paypal".
 *
 * @property integer $nid
 * @property string $paypalName
 */
class OaPaypal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oa_paypal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paypalName'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nid' => 'Nid',
            'paypalName' => 'Paypal Name',
        ];
    }
}
