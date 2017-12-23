<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "oa_ebay_paypal".
 *
 * @property integer $nid
 * @property integer $ebayId
 * @property integer $paypalId
 * @property string $mapType
 */
class OaEbayPaypal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oa_ebay_paypal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ebayId', 'paypalId'], 'integer'],
            [['mapType'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nid' => 'Nid',
            'ebayId' => 'Ebay ID',
            'paypalId' => 'Paypal ID',
            'mapType' => 'Map Type',
        ];
    }
    public function getPayPal(){
        return $this->hasOne(OaPaypal::className(), ['nid' => 'paypalId']);
    }
}
