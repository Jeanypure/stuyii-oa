<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "oa_ebay_suffix_paypal".
 *
 * @property integer $nid
 * @property integer $ebay_id
 * @property integer $paypal_id
 */
class OaEbaySuffixPaypal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oa_ebay_suffix_paypal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ebay_id', 'paypal_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nid' => 'Nid',
            'ebay_id' => 'Ebay ID',
            'paypal_id' => 'Paypal ID',
        ];
    }
}
