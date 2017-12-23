<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "oa_shippingService".
 *
 * @property integer $nid
 * @property string $servicesName
 * @property string $type
 * @property integer $siteId
 * @property string $ibayShipping
 */
class OaShippingService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oa_shippingService';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['servicesName', 'type', 'ibayShipping'], 'string'],
            [['siteId'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nid' => 'Nid',
            'servicesName' => '运输方式',
            'type' => '属性',
            'siteId' => '国家',
            'ibayShipping' => 'Ibay识别运输方式',
        ];
    }
}
