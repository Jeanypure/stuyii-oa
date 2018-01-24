<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-01-23
 * Time: 17:05
 */

namespace backend\models;

use Yii;
use yii\base\Model;

class EntryForm extends \yii\db\ActiveRecord
{
    public $type;
    public $order_range;
    public $create_range;

    public function rules()
    {
        return [
            [['type', 'order_range'], 'required'],
        ];
    }
}