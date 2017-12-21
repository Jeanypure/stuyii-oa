<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "oa_ebay_paypal".
 *
 * @property integer $nid
 * @property string $ebayName
 * @property string $palpayName
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
            [['ebayName', 'palpayName', 'mapType'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nid' => 'Nid',
            'ebayName' => 'Ebay Name',
            'palpayName' => 'Palpay Name',
            'mapType' => 'Map Type',
        ];
    }
}
