<?php

namespace backend\controllers;

use PHPUnit\Framework\Exception;
use Yii;
use backend\models\Wishgoodssku;
use backend\models\WishgoodsskuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WishgoodsskuController implements the CRUD actions for Wishgoodssku model.
 */
class WishgoodsskuController extends Controller
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
     * Lists all Wishgoodssku models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WishgoodsskuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Wishgoodssku model.
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
     * Creates a new Wishgoodssku model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Wishgoodssku();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->itemid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Wishgoodssku model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->itemid]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionSavesku(){
        $request = Yii::$app->request;
        $model =  new Wishgoodssku();
        try{
            if($request->isPost){
                $skuRows = $request->post()['Wishgoodssku'];
                foreach($skuRows as $key=>$value){
                    $sku_model = $model->find()->where(['itemid'=>$key])->one();
                    $sku_model->sku = $value['sku'];
                    $sku_model->color = $value['color'];
                    $sku_model->size = $value['size'];
                    $sku_model->inventory = $value['inventory'];
                    $sku_model->price = $value['price'];
                    $sku_model->shipping = $value['shipping'];
                    $sku_model->msrp = $value['msrp'];
                    $sku_model->shipping_time = $value['shipping_time'];
                    $sku_model->linkurl = $value['linkurl'];
                    $sku_model->update(false);
                }
                echo '保存成功!';
            }
            else{
                echo '保存失败!';
            }
        }catch(Exception $e){
           echo $e;
        }


    }

    /**
     * Deletes an existing Wishgoodssku model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDelete()
    {
        $id = $_POST['id'];
        $model =  new Wishgoodssku();
       $result =  $model->find()->where(['itemid'=>$id])->one();

      $res = $this->findModel($id)->delete();
      if(!empty($res)){
          echo '删除成功!';
      }else{
          echo '删除失败!';
      }

        return $this->redirect(['channel/update','id' => $result->pid]);
    }

    /**
     * Finds the Wishgoodssku model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Wishgoodssku the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Wishgoodssku::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
