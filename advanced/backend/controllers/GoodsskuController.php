<?php

namespace backend\controllers;

use Yii;
use yii\base\Model;
use backend\models\Goodssku;
use backend\models\GoodsskuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//actionSave中对应的命名空间要加上
use yii\web\Response;


/**
 * GoodsskuController implements the CRUD actions for Goodssku model.
 */
class GoodsskuController extends Controller
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
     * Lists all Goodssku models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GoodsskuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDemo()
    {
        $searchModel = new GoodsskuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderAjax('demo', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Goodssku model.
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
     * Creates a new Goodssku model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Goodssku();
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['result' =>$model->save() ];
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Goodssku model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $pid = $_POST['Goodssku']['pid'];
            return $this->redirect(['oa-goodsinfo/update','id'=>$pid]);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }



    /**
     * Deletes an existing Goodssku model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //User::find()->where(['name' => 'ttt'])->one()
        $sku = Goodssku::find()->where(['sid'=>$id])->one();
        $pid = $sku['pid'];

        $this->findModel($id)->delete();
        return $this->redirect(['oa-goodsinfo/update','id'=>$pid]);
    }

    /**
     * Finds the Goodssku model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Goodssku the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goodssku::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
