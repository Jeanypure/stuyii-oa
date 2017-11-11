<?php

namespace backend\controllers;


use Yii;
use backend\models\Channel;
use backend\models\ChannelSearch;
use backend\models\Goodssku;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

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
//        $model = $this->findModel($id);

//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->pid]);
//        } else {
//            return $this->render('editwish', [
//                'model' => $model,
//            ]);
//        }
        $info = Channel::findOne($id);
        $Goodssku = Goodssku::find()->where(['pid'=>$id])->all();
        $dataProvider = new ActiveDataProvider([
            'query' => Goodssku::find()->where(['pid'=>$id]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);


//        var_dump($dataProvider);die;
        if($info->load(Yii::$app->request->post())){
            $info->save();
            return $this->redirect(['view','id'=>$info->pid]);

        }else{
            return $this->render('editwish',[
                'info' =>$info,
                'dataProvider' => $dataProvider,
                'Goodssku' => $Goodssku[0],
            ]);
        }
    }

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
}
