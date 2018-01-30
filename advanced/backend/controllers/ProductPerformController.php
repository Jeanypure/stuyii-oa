<?php

namespace backend\controllers;

use backend\models\EntryForm;
use Yii;
use yii\data\ArrayDataProvider;

class ProductPerformController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new EntryForm();
        //获取开发员列表
        $devList = $this->getDevList();
        //获取搜索条件
        $get = Yii::$app->request->get();
        if(isset($get['EntryForm'])){
            $data['type'] = $get['EntryForm']['type'];
            $data['cat'] = $get['EntryForm']['cat'];
            $order_range = $get['EntryForm']['order_range'];
            $create_range = $get['EntryForm']['create_range'];
            $order = explode(' - ', $order_range);
            $data['order_start'] = $order[0];
            $data['order_end'] = $order[1];
            $create = explode(' - ', $create_range);
            $data['create_start'] = (!empty($create[0])) ? $create[0] : '';
            $data['create_end'] = (!empty($create[1])) ? $create[1] : '';
            $model->type = $get['EntryForm']['type'];
            $model->cat = $get['EntryForm']['cat'];
            $model->order_range = $order_range;
            $model->create_range = $create_range;
        }else{
            $data['type'] = 0;
            $data['cat'] = '';
            $data['order_start'] = date('Y-m-d',strtotime("-30 day"));
            $data['order_end'] = date('Y-m-d');
            $data['create_start'] = '';
            $data['create_end'] = '';
            $model->order_range = $data['order_start'].' - '.$data['order_end'];//设置时间初始值
        }
        //var_dump($data);exit;
        //获取数据
        $sql = "P_oa_ProductPerformance " . $data['type'] . " ,'" . $data['order_start'] . "','" . $data['order_end'] . "','" . $data['create_start'] . "','" . $data['create_end'] . "','".$data['cat']."'";
//        P_oa_CategoryPerformance_demo 0 ,'2018-01-01','2018-01-23','',''

        //缓存数据
        $cache = Yii::$app->local_cache;
        $ret = $cache->get($sql);
        if($ret !== false){
            $result = $ret;
        } else {
            $result = Yii::$app->db->createCommand($sql)->queryAll();
            $cache->set($sql,$result,2592000);
        }
        //$result = Yii::$app->db->createCommand($sql)->queryAll();
        //var_dump($result);exit;
        $dataProvider = new ArrayDataProvider([
            'allModels' => $result,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['l_AMT', 'l_qty'],
            ],
        ]);

        return $this->render('index', [
            'model' => $model,
            'list' => $devList,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 根据登录人员身份获取开发员列表
     */
    public function getDevList(){
        /*$username = Yii::$app->user->identity->username;
        $username = '韩珍';
        $res = Yii::$app->db->createCommand("select mid from Y_manger WHERE manger='$username'")->queryAll();
        if($res){
            $mangerid =$res[0]['mid'];
            $sql ="select DISTINCT u.username from Y_role r
                LEFT JOIN Y_user_role ur on ur.roleid=r.roleid
                LEFT JOIN Y_user u ON u.uid=ur.uid
                WHERE r.rolename='开发员' AND mangerid='$mangerid'";
        }elseif($username=='admin'){*/
            $sql = "select u.username from Y_role r
                    LEFT JOIN Y_user_role ur on ur.roleid=r.roleid
                    LEFT JOIN Y_user u ON u.uid=ur.uid
                    WHERE rolename='开发员' ";
        /*}else{
            $sql ="select r.rolename, u.username from Y_role r
                    LEFT JOIN Y_user_role ur on ur.roleid=r.roleid
                    LEFT JOIN Y_user u ON u.uid=ur.uid
                    WHERE rolename='开发员' AND u.username='$username'";
        }*/
        $developer= Yii::$app->db->createCommand($sql)->queryAll();
        foreach($developer as $v){
            $dev[$v['username']]  = $v['username'];
        }
        return array_unique($dev);
    }
}
