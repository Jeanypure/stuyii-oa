<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "oa_ebay_suffix".
 *
 * @property integer $nid
 * @property string $ebayName
 * @property string $ebaySuffix
 * @property string $nameCode
 */
class OaEbaySuffix extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oa_ebay_suffix';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ebayName'], 'required'],
            [['ebayName'], 'unique'],
            [['ebayName', 'ebaySuffix', 'nameCode'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nid' => 'Nid',
            'ebayName' => 'Ebay账号',
            'ebaySuffix' => 'Ebay账号简称',
            'nameCode' => 'Ebay编码',
        ];
    }
}
