<?php

namespace backend\controllers;

use backend\models\EntryForm;
use Yii;
use yii\helpers\ArrayHelper;

class DevPerformController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new EntryForm();
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
        $sql = "P_oa_DeveloperPerformance " . $data['type'] . " ,'" . $data['order_start'] . "','" . $data['order_end'] . "','" . $data['create_start'] . "','" . $data['create_end'] ."'";
        //缓存数据
        //缓存数据
        $cache = Yii::$app->local_cache;
        $ret = $cache->get($sql);
        if($ret !== false){
            $result = $ret;
        } else {
            $result = Yii::$app->db->createCommand($sql)->queryAll();
            $cache->set($sql,$result,86400);
        }
        //获取销量和销售额图表数据
        $sale['name'] = $saleNum['name'] = ArrayHelper::getColumn($result,'SalerName');
        $arr1 = $arr2 = [];
        foreach ($result as $k => $v){
            $arr1[$k] = ['name' => $v['SalerName'], 'value' => $v['codeNum']];
            $arr2[$k] = ['name' => $v['SalerName'], 'value' => $v['l_AMT']];
        }
        $sale['data'] = $arr1;
        $sale['maxValue'] = max(ArrayHelper::getColumn($result,'codeNum'));
        $saleNum['data'] = $arr2;
        $saleNum['maxValue'] = max(ArrayHelper::getColumn($result,'l_AMT'));;
        //var_dump($sale['maxValue']);exit;
        return $this->render('index',[
            'model' => $model,
            'sale' => $sale,
            'saleNum' => $saleNum,
        ]);
    }

    /**
     * 获取图表数据
     * @return string
     */
    public function actionDevelop()
    {
        $model = new EntryForm();
        $devList = [];
        return $this->render('index',[
            'model' => $model,
            'list' => $devList,
        ]);
    }

}
