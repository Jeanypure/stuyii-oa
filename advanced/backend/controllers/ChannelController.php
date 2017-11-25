<?php

namespace backend\controllers;


use Yii;
use backend\models\Channel;
use backend\models\OaTemplatesVar;
use backend\models\OaTemplates;
use backend\models\ChannelSearch;
use backend\models\Goodssku;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
/**
 * ChannelController implements the CRUD actions for Channel model.
 */
class ChannelController extends Controller
{
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
     * Lists all Channel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChannelSearch();
//        $oaGoodsinfo = new Channel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider = new ActiveDataProvider([
//            'query' => $oaGoodsinfo->find()->with('oa_goods'),
//            'pagination' => [
//                'pageSize' => 10,
//            ]
//        ]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Displays a single Channel model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Channel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Channel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Channel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $info = OaTemplates::find()->where(['infoid' =>$id])->one();
        $Goodssku = Goodssku::find()->where(['pid'=>$id])->all();
        $templatesVar = new ActiveDataProvider([
            'query' => OaTemplatesVar::find()->where(['tid' =>$id]),
            'pagination' => [
                'pageSize' => 150,
            ],
        ]);
        $dataProvider = new ActiveDataProvider([
            'query' => Goodssku::find()->where(['pid'=>$id]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if(Yii::$app->request->isPost){

        }
        else{
            $inShippingService = $this->getShippingService('In');
            $OutShippingService = $this->getShippingService('Out');
            return $this->render('update',[
                'info' =>$info,
                'dataProvider' => $dataProvider,
                'Goodssku' => $Goodssku[0],
                'templatesVar' => $templatesVar,
                'inShippingService' => $inShippingService,
                'outShippingService' => $OutShippingService,

            ]);
        }

//        if($info->load(Yii::$app->request->post())){
//
//            $info->save();
//            return $this->redirect(['view','id'=>$info->nid]);
//
//        }else{
//
//            return $this->render('update',[
//                'info' =>$info,
//                'dataProvider' => $dataProvider,
//                'Goodssku' => $Goodssku[0],
//
//            ]);
//        }
    }



    /**
     * 多属性保存
     * @param $id
     */
    public function actionVarSave($id)
    {
        $varData = $_POST['OaTemplatesVar'];
        $label = json_decode($_POST['label'],true);
        foreach ($varData as $key=>$value)
        {
            $value['tid'] = $id;
            //设置标签
            foreach($label as $property=>$name){
                if(!empty($name)){
                    $value[$property] = "{$name}:{$value[$property]}";
                }
            }
            if(strpos($key, 'New') ===false){
                //update
                $ret =$this->findVar($key);
                $ret->setAttributes($value,$safeOnly=false);
                $ret->save(false);
            }
            else{
                //create
                $model = new OaTemplatesVar();
                $model->setAttributes($value);
                if($model->save(false)){

                }
                else {
                    echo "Wrong!";
                }
            }

        }
        //根据varId的值，来决定更新还是创建

    }

    /**
     * 多属性设置页面
     * @param $id
     * @return mixed
     */

    public function actionTemplatesVar($id)
    {
        $templatesVar = new ActiveDataProvider([
            'query' => OaTemplatesVar::find()->where(['tid' =>$id]),
            'pagination' => [
                'pageSize' => 150,
            ],
        ]);
        $propertyVar = OaTemplatesVar::find()->where(['tid'=>$id])->all();
        return $this->renderAjax('templatesVar',[
            'templatesVar' => $templatesVar,
            'tid' => $id,
            'propertyVar' => $propertyVar,
        ]);
    }

    /**
     * delete row from templatesVar
     * @return mixed
     */

    public function actionDeleteVar(){
        $id = $_POST["id"];

        // 根据id的类型来执行不同的操作
        if(is_array($id)){
            foreach($id as $row){
                $this->findVar($row)->delete();
            }

        }
        else{
            $this->findVar($id)->delete();
        }
    }
    /**
    /*
     * UpdateWish
     * url  http://localhost:8076/channel/update-wish?id=
     *
     */

    public function actionUpdateWish($id){
        $model = $this->findModel($id);




        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pid]);
        } else {
            return $this->render('editwish', [
                'model' => $model,
            ]);
        }
    }



    /**
     * Deletes an existing Channel model.
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
     * exists or not
     * @param $id
     * @return mixed
     */
    protected function findVar($id)
    {
        $model = OaTemplatesVar::find()->where(['nid'=>$id])->one();
        if (!empty($model))
        {
            return $model;
        }
        else{
            return false;
        }
    }
    /**
     * Finds the Channel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Channel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Channel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     *  返回物流名称
     */
    protected function getShippingService($type)
    {
        $sql = "select id, shippingName from oa_shippingService where type='{$type}'";
        $connection = Yii::$app->db;
        $ret = $connection->createCommand($sql)->queryAll();
        $options = ArrayHelper::map($ret, 'id','shippingName');
        return $options;
    }

}
