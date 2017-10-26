<?php

namespace backend\controllers;

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
//            var_dump($_POST);die;
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
 * @para $id
 * return mixed
 *
 */

public function actionInput($id)
{
    $input_goods = "P_OaGoodsToBGoods '{$id}'";
    $connection = Yii::$app->db;
    $trans = $connection->beginTransaction();
    try {
        $connection->createCommand($input_goods)->execute();
        $trans->commit();
    }
    catch (Exception  $e) {
        $trans->rollBack();
    }
    echo '{"msg":"Inputing Done"}';
}



    /**
     * input to py
     * @para $ids
     * return mixed
     *
     */

    public function actionInputLots($ids)
    {
        foreach($ids as $goods_id){
            $input_goods = "P_OaGoodsToBGoods '{$goods_id}'";
            $connection = Yii::$app->db;
            $trans = $connection->beginTransaction();
            try {
                $connection->createCommand($input_goods)->execute();
                $trans->commit();
            }
            catch (Exception  $e) {
                $trans->rollBack();
            }
        }
        echo '{"msg":"Inputted Done!"}';
    }


}
