<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-12-20
 * Time: 15:17
 */

namespace backend\models;


class OaEbaySuffix extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%oa_ebay_suffix}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ebayName'], 'required'],
            [['ebayName', 'ebaySuffix'], 'string', 'max' => 50],
            [['nameCode'], 'string', 'max' => 10],
            //[['ebayName'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'NID' => 'Nid',
            'ebayName' => 'Ebay账号',
            'ebaySuffix' => 'Ebay账号简称',
            'nameCode' => '账号编号',
        ];
    }



}