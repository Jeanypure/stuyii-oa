<?php

namespace backend\controllers;

use Yii;
use backend\models\OaGoods;
use backend\models\OaGoodsSearch;
use backend\models\OaGoodsForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use \PHPExcel;
use app\models\UploadForm;
use yii\web\UploadedFile;
/**
 * OaGoodsController implements the CRUD actions for OaGoods model.
 */
class OaGoodsController extends Controller
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
     * Lists all OaGoods models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OaGoodsSearch();
        $model = new OaGoods();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
            'query' => OaGoods::find()->where(['devStatus'=>'']),
            'pagination' => [
                'pageSize' => 25,
            ],
        ]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    /**
     * Displays a single OaGoods model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new OaGoods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OaGoods();

        if ($model->load(Yii::$app->request->post())  ) {
            if($model->save()) {
                //默认值更新到当前行中
                $id = $model->nid;
                $current_model = $this->findModel($id);
                $user = yii::$app->user->identity->username;
                $current_model->devNum = '20'.date('ymd',time()).strval($id);
                $current_model->devStatus = '';
                $current_model->checkStatus = '';
                $current_model ->introducer = $user;
                $current_model ->updateDate = strftime('%F %T');
                $current_model ->createDate = strftime('%F %T');
                $current_model->update(array('devStatus','developer','updateDate'));
                return $this->redirect(['view', 'id' => $model->nid]);
            }
            else {

                echo "something Wrong!";
            }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing OaGoods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->nid]);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing OaGoods model.
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
     *  lots fail simultaneously
     * @param null
     * @return mixed
     */
    public  function  actionDeleteLots()
    {
        $ids = yii::$app->request->post()["id"];
        foreach ($ids as $id)
        {
            $this->findModel($id)->delete();
        }
        return $this->redirect(['index']);
    }

    /**
     *  read uploading templates locally
     */

    public function actionTemplate()
    {
        // template in csv formatter
//        $template = htmlspecialchars_decode(file_get_contents('template.xlsx'));
//        $outfile='template.xlsx';
//        header('Content-type: application/octet-stream; charset=utf8');
        $template = htmlspecialchars_decode(file_get_contents('template.csv'));
        $outfile='template.csv';
        header('Content-type: application/octet-stream; charset=GB2312');
        Header("Accept-Ranges: bytes");
        header('Content-Disposition: attachment; filename='.$outfile);
        echo $template;
        exit();
    }


    /**
     *  import excel file in php way and  abandoned
     */

    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                // 文件上传成功
                return;
            }
        }

        return $this->render('upload', ['model' => $model]);

    }

    /**
     * import templates in h5 way
     */
    public function actionImport()
    {
        $model = new OaGoods();
        $user = yii::$app->user->identity->username;
        $data = Yii::$app->request->post('data');
        $data = str_replace("*", '', $data);// 把标题中的星号去掉
        $rows = json_decode($data,true)['data'];
        foreach ($rows as $row)
        {
            $_model = clone $model;
            $_model->setAttributes($row);
            if($_model->save())
            {
                $id = $_model->nid;
                $current_model = $this->findModel($id);
                $current_model->devNum = '20'.date('ymd',time()).strval($id);
                $current_model->devStatus = '';
                $current_model->checkStatus = '';
                $current_model ->introducer = $user;
                $current_model ->updateDate = strftime('%F %T');
                $current_model ->createDate = strftime('%F %T');
                $current_model->update(array('devStatus','developer','updateDate'));
                return $this->redirect(['index']);
            }
            else {
                return $this->redirect(['index']);
            }
        }

    }
    /**
     *   generate uploading templates with PHPExcel
     * @param null
     * @return mixed
     */

    public function actionTemplates()
    {
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('导入模板');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'img');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="这里是excel文件的名称.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }


    public function actionHeart($id)
    {
        $model = $this->findModel($id);

        return $this->renderAjax('heart',[
            'model' => $model,
        ]);
    }


    // Forward action

    public function actionForward($id)
    {
        $model = $this->findModel($id);
        $user = yii::$app->user->identity->username;
        $model ->devStatus = '正向认领';
        $model ->developer = $user;
        $model ->updateDate = strftime('%F %T');
//        var_dump($model);die;
        $model->update(array('devStatus','developer','updateDate'));
        return $this->redirect(['index']);
    }

    //Backward action

    public function actionBackward($id)
    {
        $model = $this->findModel($id);
        $user = yii::$app->user->identity->username;
        $model ->devStatus = '逆向认领';
        $model ->developer = $user;
        $model ->updateDate = strftime('%F %T');
        $model->update(array('devStatus','developer','updateDate'));
        return $this->redirect(['index']);
    }


    // forward products
    public function actionForwardProducts()
    {
        $searchModel = new OaGoodsSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => OaGoods::find()->where(['devStatus'=>'正向认领']),
            'pagination' => [
                'pageSize' => 25,
            ],
        ]);
        return $this->render('forwardProducts', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    // backward products
    public function actionBackwardProducts()
    {
        $searchModel = new OaGoodsSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => OaGoods::find()->where(['devStatus'=>'逆向认领']),
            'pagination' => [
                'pageSize' => 25,
            ],
        ]);
        return $this->render('backwardProducts', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Finds the OaGoods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OaGoods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OaGoods::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
