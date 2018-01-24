<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-01-17
 * Time: 11:20
 */

namespace backend\controllers;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use backend\models\EntryForm;
use yii\db\Query;


class CatPerformController extends Controller
{
    public  function actionIndex(){
        return $this->render('index');
    }
    /*
     * 30天类目表现
     */
    public function actionCategory(){
        $sql = 'P_oa_CategoryPerformance';
        $cache = Yii::$app->local_cache;
        $today = 'category-'.date('y-m-d');
        $ret = $cache->get($today);
        if(!empty($ret)){
            $result = $ret;
        }else{
            $result =  Yii::$app->db->createCommand($sql)->queryAll();
            $cache->set($today,$result,86400);
        }
        foreach ($result as $key => $value) {
            if ($value['Distinguished'] == 'catNum') {
                $va['value'] =(int) $value['value'];
                $va['name'] = $value['name'];
                $Data['catNum'][] = $va;
            } else {
                $va['value'] = (int) $value['value'];
                $va['name'] = $value['name'];
                $Data['catAmt'][] = $va;
            }
        }
        $Data['name'] = array_column($Data['catNum'], 'name');
        echo json_encode($Data);
    }

    /*
     * 一定时间段类别表现
     */
    public  function actionCat(){
            $data['type'] = $_POST['EntryForm']['type'];
            $data['order_range'] = $_POST['EntryForm']['order_range'];
            $data['create_range'] = $_POST['EntryForm']['create_range'];
        $order = explode(' - ',$data['order_range']);

        $data['order_start'] = $order[0];
        $data['order_end'] = $order[1];
        $create = explode(' - ',$data['create_range']);
        $data['create_start'] = (!empty($create[0]))?$create[0]:'';
        $data['create_end'] = (!empty($create[1]))?$create[1]:'';
        $sql = "P_oa_CategoryPerformance_demo '".$data['type']."' ,'".$data['order_start']."','".$data['order_end']."','".$data['create_start']."','".$data['create_end']."'";  //P_oa_Category 0 ,'2018-01-01','2018-01-23','',''
        $result = Yii::$app->db->createCommand($sql)->queryAll();
        var_dump($result);die;
//        $res = EntryForm::findBySql($sql);
        $dataProvider = new ActiveDataProvider([
            'query' => $res
        ]);
        return $this->render('catlist',[
            'dataProvider' => $dataProvider,
        ]);
    }

    public function  actionTimeRange(){
        $model = new EntryForm;
        return $this->render('range',
            ['model' => $model]
            );
    }
}