<?php

namespace console\controllers;


use yii\console\Controller;
use Yii;
use yii\db\Exception;

class SiteController extends Controller
{

    /**
     * 查询产品状态，更新产品备货天数
     * @return mixedd
     */
    public function actionIndex()
    {
        //更新属性信息
        $sql = "P";
        $connection = Yii::$app->db;
        $import_trans = $connection->beginTransaction();
        try{
            $connection->createCommand($sql)->execute();
            $import_trans->commit();
        }
        catch (Exception $e) {
            $import_trans->rollBack();
        }
        return '';
    }


}