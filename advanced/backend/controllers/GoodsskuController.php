<?php

namespace backend\controllers;

use Yii;
use yii\base\Model;
use backend\models\Goodssku;
use backend\models\GoodsskuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
//actionSave中对应的命名空间要加上
use yii\web\Response;


/**
 * GoodsskuController implements the CRUD actions for Goodssku model.
 */
class GoodsskuController extends Controller
{
    /**
     * @inheritdoc
     *
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST','GET'],
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



    /**
     *  SKU info
     */

    public function actionInfo($id)
    {

        $model = Goodssku::find()->where(['pid'=>1])->one();
        $dataProvider = new ActiveDataProvider([
            'query' => Goodssku::find()->where(['pid'=>$id]),
            'pagination' => [
                'pageSize' => 25,
            ],
        ]);
        return $this->renderAjax('info',[
            'info'=> $model,
            'dataProvider'=>$dataProvider
        ]);
    }


    /**
     *  save sku data only
     */

    public function actionSaveOnly($pid)
    {
        $request = Yii::$app->request;
        $model = new Goodssku();
        if($request->isPost)
        {
            //提交过来的表单数据
            try
            {
                $skuRows = $request->post()['Goodssku'];
                foreach ($skuRows as $row_key=>$row_value)
                {
                    $row_value['pid'] = intval($pid); //pid传进来
                    //新增行
                    if(strstr($row_key,'New'))
                    {
                        $_model = clone $model;
                        //配合rules 进行安全检查;需要改变的数据都要声明下类型。
                        $_model ->setAttributes($row_value,true); //逐行入库
                        if($_model->save()){
                            echo "{'msg':'Done'}";
                        }

                        else {
                            echo "{'msg:'Fail'}";
                        }
                    }
                    //更新行
                    else
                    {   $sku = $row_value['sku'];

                        $update_moadel = Goodssku::find()->where(['sku' => $sku])->one();
                        $update_moadel->property1 = $row_value['property1'];
                        $update_moadel->property2 = $row_value['property2'];
                        $update_moadel->property3 = $row_value['property3'];
                        $update_moadel->CostPrice = $row_value['CostPrice'];
                        $update_moadel->Weight = $row_value['Weight'];
                        $update_moadel->RetailPrice = $row_value['RetailPrice'];
                        $update_moadel->update(['property1','property2','property3',
                            'CostPrice','Weight','RetailPrice']);

//                        echo "{'msg':'update successfully'}";

                    }
                    $this->redirect(['oa-goodsinfo/update','id'=>$pid]);
                }

            }
            catch (Exception  $e)
            {
                echo $e;
            }

        }
    }



    /**
     *  save and complete sku data
     */

    public function actionSaveComplete()
    {
        $request = Yii::$app->request;
        if($request->isPost)
        {
            var_dump($request->post());die;
        }
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
    public function actionCreate($id =null)
    {

        $model = new Goodssku();

        if ($model->load(Yii::$app->request->post())&&$model->save()) {
            $pid = $_POST['Goodssku']['pid'];
            $this->redirect(['oa-goodsinfo/update','id'=>$pid]);
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            return ['result' =>$model->save() ];
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'pid' => $id,
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
    public function actionDelete($id=null)
    {
        $request = Yii::$app->request;
        if ($request->isGet)
        {
            $sku = Goodssku::find()->where(['sid'=>$id])->one();
            $pid = $sku['pid'];
            $this->findModel($id)->delete();
            return $this->redirect(['oa-goodsinfo/update','id'=>$pid]);}
        if ($request->isPost)
        {
            $id =  $_POST['id'];
            $this->findModel($id)->delete();
            echo "{'msg':'Deleted'}";
        }

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
