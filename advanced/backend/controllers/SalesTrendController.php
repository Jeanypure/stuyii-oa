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
            $date = array_unique(ArrayHelper::getColumn($result,'ordermonth'));
        }else{//按天
            $date = array_unique(ArrayHelper::getColumn($result,'ordertime'));
        }
        $name = array_unique(ArrayHelper::getColumn($result,'ADDRESSOWNER'));
        $value = [];

        var_dump($name);exit;
        //获取销售额数据
        /*$date = ['2017-12-31','2018-01-01','2018-01-02','2018-01-03','2018-01-04','2018-01-05','2018-01-06','2018-01-07','2018-01-08','2018-01-09'];
        $name = ['张三','李四','王五','赵六','孙琦','周吧','五九'];
        $value = [
            [1,2,3,4,5,6,7,8,9,10],
            [1,2,3,4,5,6,7,8,9,10],
            [1,2,3,4,5,6,7,8,9,10],
            [1,2,3,4,5,6,7,8,9,10],
            [1,2,3,4,5,6,7,8,9,10],
            [1,2,3,4,5,6,7,8,9,10],
            [1,2,3,4,5,6,7,8,9,10],
        ];*/
        //$salesVolumeData = $this->getSalesVolumeData($model->type, $model->code, $model->start, $model->end);
        $salesVolumeData = [
            'date' => $date,
            'name' => $name,
            'value' => $value
        ];
        //获取销量数据
        //$salesData = $this->getSalesVolumeData($model->type, $model->code, $model->start, $model->end, 1);
        $salesData = [
            'date' => $date,
            'name' => $name,
            'value' => $value
        ];

        
        return $this->render('index', [
            'model' => $model,
            'list' => $salesData,
            'list1' => $salesVolumeData,
        ]);
    }


    /**
     * 获取销售额/销量
     * @param $type //1-按天 2-按月
     * @param $code //产品编码
     * @param $start //开始时间（按交易时间）
     * @param $end //结束时间（按交易时间）
     * @param $dataType //数据类型 0-销售额  1-销量
     * @return array
     */
    public function getSalesVolumeData($type, $code, $start, $end, $dataType = 0)
    {
        $timeSql = "select convert(varchar(10),dateadd(day,number, '" . $start . "'),121)
		from master.dbo.spt_values  where type ='P'
		and number <=DATEDIFF(day, '" . $start . "', '" . $end . "')";
        $date = Yii::$app->db->createCommand($timeSql)->queryAll();
        //获取产品订单数组
        if ($type == 1) {
            $condition = "(convert(varchar(10),pt.ordertime,121) between '" . $start . "' and '" . $end . "')";
        }else{
            $condition = "(convert(varchar(10),DATEADD(HOUR,8,pt.ordertime),121) between '" . $start . "' and '" . $end . "')";
        }
        //正常单
        $sql1 = "SELECT pt.nid,pt.suffix,
	            CONVERT (VARCHAR (10),dateadd(HOUR, 8, ordertime),121) AS ordertime,
	            CONVERT (VARCHAR (7),dateadd(HOUR, 8, ordertime),121) AS ordermonth,
	            amt,pt.currencycode,code.ExchangeRate,ysp.pingtai
                FROM p_trade AS pt
                LEFT JOIN Y_suffixPingtai AS ysp ON ysp.suffix = pt.suffix
                Left JOIN B_CurrencyCode as code on code.Currencycode = pt.currencycode
                WHERE " . $condition;
        $data1 = Yii::$app->db->createCommand($sql1)->queryAll();
        //归档单
        $sql2 = "SELECT pt.nid,pt.suffix,
	            CONVERT (VARCHAR (10),dateadd(HOUR, 8, ordertime),121) AS ordertime,
	            CONVERT (VARCHAR (7),dateadd(HOUR, 8, ordertime),121) AS ordermonth,
	            amt,pt.currencycode,code.ExchangeRate,ysp.pingtai
                FROM p_trade_his AS pt
                LEFT JOIN Y_suffixPingtai AS ysp ON ysp.suffix = pt.suffix
                Left JOIN B_CurrencyCode as code on code.Currencycode = pt.currencycode
                WHERE " . $condition;
        $data2 = Yii::$app->db->createCommand($sql2)->queryAll();
        //缺货单
        $sql3 = "SELECT pt.nid,pt.suffix,
	            CONVERT (VARCHAR (10),dateadd(HOUR, 8, ordertime),121) AS ordertime,
	            CONVERT (VARCHAR (7),dateadd(HOUR, 8, ordertime),121) AS ordermonth,
	            amt,pt.currencycode,code.ExchangeRate,ysp.pingtai
                FROM p_tradeun AS pt
                LEFT JOIN Y_suffixPingtai AS ysp ON ysp.suffix = pt.suffix
                Left JOIN B_CurrencyCode as code on code.Currencycode = pt.currencycode
                WHERE " . $condition;
        $data3 = Yii::$app->db->createCommand($sql3)->queryAll();

        $data = array_merge($data1,$data2,$data3);
        var_dump($data);exit;
        return [];
    }


    /**
     * 获取销量
     * @param $type //1-按天 2-按月
     * @param $code //产品编码
     * @param $start //开始时间（按交易时间）
     * @param $end //结束时间（按交易时间）
     * @return array
     */
    public function getSalesData($type, $code, $start, $end)
    {
        return [];
    }

}
