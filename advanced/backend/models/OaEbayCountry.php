<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "oa_ebay_country".
 *
 * @property integer $nid
 * @property string $Name
 * @property integer $code
 * @property string $currencyCode
 */
class OaEbayCountry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oa_ebay_country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Name', 'currencyCode'], 'string'],
            [['code'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nid' => 'Nid',
            'Name' => 'Name',
            'code' => 'Code',
            'currencyCode' => 'Currency Code',
        ];
    }
}
