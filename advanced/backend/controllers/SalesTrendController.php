<?php

namespace backend\controllers;


use backend\models\EntryForm;
use Yii;
use yii\helpers\ArrayHelper;

class SalesTrendController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new EntryForm();
        //获取搜索条件
        $get = Yii::$app->request->get();
        if(isset($get['EntryForm'])){
            $data = $get['EntryForm'];
            $model->type = $get['EntryForm']['type'];
            $model->cat = $get['EntryForm']['cat'];
            $model->order_range = $get['EntryForm']['order_range'];
            $model->create_range = $get['EntryForm']['create_range'];
        }else{
            $data['type'] = 0;
            $data['cat'] = '';
            $data['order_range'] = date('Y-m-d',strtotime("-30 day"));
            $data['create_range'] = date('Y-m-d');
            $model->order_range = $data['order_range'];//设置开始时间初始值
            $model->create_range = $data['create_range'];//设置结束时间初始值
        }
        $sql = "P_oa_AMTtrend 0,'" . $data['order_range'] . "','" . $data['create_range'] . "','" . $data['type'] . "','" . $data['cat'] ."'";
        //缓存数据
        $cache = Yii::$app->local_cache;
        $ret = $cache->get($sql);
        if($ret !== false){
            $result = $ret;
        } else {
            $result = Yii::$app->db->createCommand($sql)->queryAll();
            $cache->set($sql,$result,86400);
        }
        //处理数据
        if($data['type']){//按月
            $date = array_unique(ArrayHelper::getColumn($result,'mt'));
        }else{//按天
            $date = array_unique(ArrayHelper::getColumn($result,'dt'));
        }
        $date = array_values($date);
        $name = array_unique(ArrayHelper::getColumn($result,'ADDRESSOWNER'));
        sort($name);
        $arr_qty = $arr_amt = [];
        foreach ($name as $k => $v){
            $it = $item = [];
            foreach ($result as $key => $value) {
                if ($v == $value['ADDRESSOWNER']) {
                    $it[] =  empty($value['l_qty'])?0:$value['l_qty'];
                    $item[] =  empty($value['l_AMT'])?0:$value['l_AMT'];
                }
            }
            $arr_qty[] = $it;
            $arr_amt[] = $item;
        }
        //处理name
        //var_dump($name);exit;
        $name_arr = [];
        foreach ($name as $k => $v){
            if($v == 'aliexpress'){
                $name_arr[$k] = 'SMT';
            }elseif ($v == 'amazon11'){
                $name_arr[$k] = 'Amazon';
            }elseif ($v == 'ebay'){
                $name_arr[$k] = 'eBay';
            }elseif ($v == 'joom'){
                $name_arr[$k] = 'Joom';
            }elseif ($v == 'lazada'){
                $name_arr[$k] = 'Lazada';
            }elseif ($v == 'shopee'){
                $name_arr[$k] = 'Shopee';
            }elseif ($v == 'topbuy'){
                $name_arr[$k] = 'Topbuy';
            }elseif ($v == 'wish'){
                $name_arr[$k] = 'Wish';
            }else{
                $name_arr[$k] = $v;
            }
        }
        //获取销量数据
        $salesData = [
            'date' => $date,
            'name' => $name_arr,
            'value' => $arr_qty
        ];
        //var_dump($salesData);exit;
        //获取销售额数据
        $salesVolumeData = [
            'date' => $date,
            'name' => $name_arr,
            'value' => $arr_amt
        ];

        return $this->render('index', [
            'model' => $model,
            'salesData' => $salesData,
            'salesVolumeData' => $salesVolumeData,
        ]);
    }

}
