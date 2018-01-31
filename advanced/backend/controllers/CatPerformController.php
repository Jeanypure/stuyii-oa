<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-01-17
 * Time: 11:20
 */

namespace backend\controllers;

use backend\models\GoodsCats;
use backend\models\SalesTrendForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use backend\models\EntryForm;
use yii\data\SqlDataProvider;
use yii\data\ArrayDataProvider;


class CatPerformController extends Controller
{
    public function actionIndex()
    {
        $model = new EntryForm;
        $data = GoodsCats::findAll(['CategoryParentID' => 0]);
        $list = ArrayHelper::map($data,'CategoryName','CategoryName');
        return $this->render('index', ['model' => $model, 'list' => $list]);
    }

    /*
     * 30天类目表现
     */
    public function actionCategory()
    {
        $sql = 'P_oa_CategoryPerformance';
        $cache = Yii::$app->local_cache;
        $today = 'category-' . date('y-m-d');
        $ret = $cache->get($today);
        if (!empty($ret)) {
            $result = $ret;
        } else {
            $result = Yii::$app->db->createCommand($sql)->queryAll();
            $cache->set($today, $result, 86400);
        }
        foreach ($result as $key => $value) {
            if ($value['Distinguished'] == 'catNum') {
                $va['value'] = (int)$value['value'];
                $va['name'] = $value['name'];
                $Data['catNum'][] = $va;
            } else {
                $va['value'] = (int)$value['value'];
                $va['name'] = $value['name'];
                $Data['catAmt'][] = $va;
            }
        }
        $Data['maxValue'] = max(ArrayHelper::getColumn($result,'value'));
        $Data['name'] = array_column($Data['catNum'], 'name');
        echo json_encode($Data);
    }

    /*
     * 一定时间段类别表现
     */
    public function actionCat()
    {
        $get = Yii::$app->request->get();
        $data['type'] = $get['EntryForm']['type'];
        $data['cat'] = $get['EntryForm']['cat'];
        $data['order_range'] = $get['EntryForm']['order_range'];
        $data['create_range'] = $get['EntryForm']['create_range'];
        $order = explode(' - ', $data['order_range']);
        $data['order_start'] = $order[0];
        $data['order_end'] = $order[1];
        $create = explode(' - ', $data['create_range']);
        $data['create_start'] = (!empty($create[0])) ? $create[0] : '';
        $data['create_end'] = (!empty($create[1])) ? $create[1] : '';
        $sql = "P_oa_CategoryPerformance_demo " . $data['type'] . " ,'" . $data['order_start'] . "','" . $data['order_end'] . "','" . $data['create_start'] . "','" . $data['create_end'] . "','".$data['cat']."'";
        //P_oa_CategoryPerformance_demo 0 ,'2018-01-01','2018-01-23','',''
        //缓存数据
        $cache = Yii::$app->local_cache;
        $ret = $cache->get($sql);
        if($ret !== false){
            $result = $ret;
        } else {
            $result = Yii::$app->db->createCommand($sql)->queryAll();
            $cache->set($sql,$result,2592000);
        }
        //选择了主目录，重组结果数组
        if($data['cat']){
            foreach ($result as $v){
                $v['CategoryParentName'] = $v['CategoryName'];
                unset($v['CategoryName']);
                $list[] = $v;
            }
        }else{
            $list = $result;
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $list,
            'pagination' => [
                'pageSize' => false,
            ],
            'sort' => [
                'attributes' => ['catCodeNum', 'non_catCodeNum', 'numRate', 'l_qty', 'non_l_qty', 'qtyRate', 'l_AMT', 'non_l_AMT', 'amtRate'],
            ],
        ]);
        return $this->render('catlist', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTimeRange()
    {
        $model = new EntryForm;
        return $this->render('range',
            ['model' => $model]
        );
    }
}