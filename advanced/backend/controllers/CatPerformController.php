<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-01-17
 * Time: 11:20
 */

namespace backend\controllers;
use Yii;
use yii\web\Controller;


class CatPerformController extends Controller
{
    public  function actionIndex(){
        return $this->render('index');
    }

    public function actionCategory(){
      $sql = 'P_oa_CategoryPerformance';
      $result =  Yii::$app->db->createCommand($sql)->queryAll();
        foreach ($result as $key => $value) {
            if ($value['Distinguished'] == 'catNum') {
                $va['value'] =(int) $value['value'];
                $va['name'] = $value['name'];
                $Data['catNum'][] = $va;
            } else {
                $va['value'] = (int)$value['value'];
                $va['name'] = $value['name'];
                $Data['catAmt'][] = $va;
            }
        }
        $Data['name'] = array_column($Data['catNum'], 'name');
        echo json_encode($Data);
    }
}