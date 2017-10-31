<?php

namespace backend\controllers;

use backend\models\OaGoods;
use PHPUnit\Framework\Exception;
use Yii;
use yii\base\Model;
use backend\models\OaGoodsinfo;
use backend\models\OaGoodsinfoSearch;
use backend\models\Goodssku;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use yii\data\ActiveDataProvider;

//actionSave中对应的命名空间要加上
use yii\web\Response;
use yii\widgets\ActiveForm;


/**
 * OaGoodsinfoController implements the CRUD actions for OaGoodsinfo model.
 */
class OaGoodsinfoController extends Controller
{

    public $pid;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all OaGoodsinfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OaGoodsinfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OaGoodsinfo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id = null)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new OaGoodsinfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OaGoodsinfo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pid]);
        } else {
         $data = $this->actionSelectParam();

            return $this->render('create', [
                'model' => $model,
                'result' => $data['res'],
                'lock' => $data['platFrom'],

            ]);
        }
    }



    public function actionUpdate($id)
    {

        $info = OaGoodsinfo::findOne($id);

        if (!$info) {
            throw new NotFoundHttpException("The product was not found.");
        }



        if($info->load(Yii::$app->request->post())){

            $SupplerName = $_POST['OaGoodsinfo']['SupplierName'];
            // 如果该查询没有结果则返回 false
            $Suppler = Yii::$app->db->createCommand("SELECT * from  B_Supplier WHERE SupplierName='$SupplerName'")
                ->queryOne();
            if(empty($Suppler)){
                $Recorder = yii::$app->user->identity->username;
                $InputDate = strftime('%F %T');
                Yii::$app->db->createCommand("insert into  B_Supplier (SupplierName,Recorder,InputDate) 
                  VALUES ('$SupplerName','$Recorder','$InputDate')")->execute();
            }

            $SupplerID = Yii::$app->db->createCommand("SELECT NID from  B_Supplier WHERE SupplierName='$SupplerName'")
                ->queryOne();

            $info->SupplierID = $SupplerID['NID'];


            if (!empty($_POST['DictionaryName'])){
                $info->DictionaryName = implode(',',$_POST['DictionaryName']);
            }
            $info->save();
            $this->redirect(['oa-goodsinfo/update','id'=>$id]);

        }else{

            $data = $this->actionSelectParam();

            $dataProvider = new ActiveDataProvider([
                'query' => Goodssku::find()->where(['pid'=>$id]),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
            return $this->render('updetail',[
                'info'=>$info,
                'pid' =>$id,
                'dataProvider' => $dataProvider,
                'result' => $data['res'],
                'lock' => $data['platFrom'],

            ]);

        }



    }






    /**
     * Deletes an existing OaGoodsinfo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the OaGoodsinfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OaGoodsinfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OaGoodsinfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Update child sku
     * add child sku
     */

    public function actionCreatesku($id =null)
    {

        $model = new Goodssku();

        if ($model->load(Yii::$app->request->post())&&$model->save()){
            $pid = $_POST['Goodssku']['pid'];
              $this->redirect(['oa-goodsinfo/update','id'=>$pid]);
        } else {
            return $this->renderAjax('createsku', [
                'model' => $model,
                'pid' => $id,
            ]);
        }
    }

    //该方法是异步校验字段，输入框失去焦点之后自动会自动请求改地址
    public function actionValidate(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new Goodssku();
        $model->load(Yii::$app->request->post());
        return ActiveForm::validate($model);

    }


    /**
     * @return array $data 包含仓库 禁售平台信息
     */
    public function actionSelectParam(){
        $connection = Yii::$app->db;
        $sql ="SELECT StoreName from B_store";
        $command = $connection->createCommand($sql);
        $result = $command->queryAll();
        array_push($result,['StoreName'=>'']);
        foreach ($result as $key=>$value){
            $StoreName[$key] = $value['StoreName'];
        }
        array_multisort($StoreName,SORT_ASC,$result);
        $res = array_column($result, 'StoreName', 'StoreName');

        $comm = $connection->createCommand('select DictionaryName from B_Dictionary where CategoryID=9');
        $plat = $comm->queryAll();
        array_push($plat,['DictionaryName'=>'']);
        foreach ($plat as $key=>$value){
            $DictionaryName[$key] = $value['DictionaryName'];
        }
        array_multisort($DictionaryName,SORT_ASC,$plat);
        $platFrom = array_column($plat, 'DictionaryName', 'DictionaryName');
        $data =[];
        $data['res'] =$res;
        $data['platFrom'] =$platFrom;
        return $data;
    }

/**
 * input to py
 * @param $id
 * return mixed
 *
 */

public function actionInput($id)
{
    $input_goods = "P_OaGoodsToBGoods '{$id}'";
    $udpate_status = "update oa_goodsinfo set achieveStatus='已导入' where pid = '{$id}'";
    $connection = Yii::$app->db;
    $trans = $connection->beginTransaction();
    try {
        $connection->createCommand($input_goods)->execute();
        $connection->createCommand($udpate_status)->execute();
        $trans->commit();
        echo "导入成功";
    }
    catch (\Exception  $e) {
        $trans->rollBack();
        echo "导入失败";
    }

}



    /**
     * input to py
     * @para $ids
     * return mixed
     *
     */

    public function actionInputLots()
    {
        $connection = Yii::$app->db;
        $ids = $_POST['ids'];
        $trans = $connection->beginTransaction();//状态更新和数据插入做成事务
        foreach($ids as $goods_id){
            $update_status = "update oa_goodsinfo set achieveStatus='已导入' where pid ='{$goods_id}'";
            $input_goods = "P_OaGoodsToBGoods '{$goods_id}'";
            try {
                $connection->createCommand($input_goods)->execute();
                $connection->createCommand($update_status)->execute();
                $trans->commit();
            }
            catch (\Exception  $e) {
                $trans->rollBack();
            }
        }
        echo "批量导入完成！";

    }


    /**
     * generate code
     */
    public function actionGenerateCode()
    {
        $ids = $_GET['ids'];
        foreach ($ids as $info_id){
            $info_model = OaGoodsinfo::find()->where(['pid'=>$info_id])->one();
            $goods_id = $info_model->goodsid;

            $current_code = $info_model->GoodsCode;
            $goods_model = OaGoods::find()->where(['nid'=>$goods_id])->one();
            $cate = $goods_model->cate;
            $b_previous_code = Yii::$app->db->createCommand(
                "select  isnull(goodscode,'UNKNOWN') as maxCode from b_goods where nid in 
            (select  max(bgs.nid) from B_Goods as bgs left join B_GoodsCats as bgc
            on bgs.GoodsCategoryID= bgc.nid where bgc.CategoryParentName='$cate' and len(goodscode)=6 )"
            )->queryOne();
            $oa_previous_code = Yii::$app->db->createCommand(
                "select isnull(goodscode,'UN0000') as maxCode from oa_goodsinfo
            where pid in (select max(pid) from oa_goodsinfo as info LEFT join 
            oa_goods as og on info.goodsid=og.nid where goodscode != 'REPEAT' and cate = '$cate')")->queryOne();
            //按规则生成编码
            $b_max_code = $b_previous_code['maxCode'];
            $oa_max_code = $oa_previous_code['maxCode'];
            if(intval(substr($b_max_code,2,4))>=intval(substr($oa_max_code,2,4))) {
                $max_code = $b_max_code;
            }
            else {
                $max_code = $oa_max_code;
            }
            if(strpos($current_code, 'REPEAT-') !== false){
                $max_code = substr($current_code,7,6);
            }
            $head = substr($max_code,0,2);
            $tail = intval(substr($max_code,2,4)) + 1;
            $zero_bit = substr('0000',0,4-strlen($tail));
            $code = $head.$zero_bit.$tail;
            //检查SKU是否已经存在
            $check_oa_goods = Yii::$app->db->createCommand(
                "select * from oa_goodsinfo where goodscode= '$code'"
            )->queryOne();
            $check_b_goods = Yii::$app->db->createCommand(
                "select * from b_goods where goodscode= '$code'"
            )->queryOne();
            if(!(empty($check_oa_goods) && empty($check_b_goods))) {
                $code = "REPEAT-".$code;
            }
            $info_model->GoodsCode = $code;
            $status = $info_model->achieveStatus;
            if($status !== '已导入')
            {
                $info_model->update(false);
            }


        }
        return $this->redirect(['index']);
    }
}
