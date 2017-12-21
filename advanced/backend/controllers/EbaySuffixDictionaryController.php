<?php

namespace backend\controllers;

use backend\models\EbaySuffixDictionarySearch;
use Yii;
use yii\web\Controller;
use backend\models\OaEbaySuffix;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WishSuffixDictionaryController implements the CRUD actions for WishSuffixDictionary model.
 */
class EbaySuffixDictionaryController extends Controller
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
     * Lists all WishSuffixDictionary models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EbaySuffixDictionarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WishSuffixDictionary model.
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
     * Creates a new WishSuffixDictionary model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OaEbaySuffix();
        $post = Yii::$app->request->post();
        //var_dump($post);exit;
        if ($model->load($post) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->nid]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WishSuffixDictionary model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $post = Yii::$app->request->post();
        //var_dump($post);exit;
        if ($model->load($post) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->nid]);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing WishSuffixDictionary model.
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
     * Finds the WishSuffixDictionary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WishSuffixDictionary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OaEbaySuffix::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求的页面不存在.');
        }
    }
}
