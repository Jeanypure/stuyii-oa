<?php

namespace backend\controllers;


use Yii;
use backend\models\Channel;
use backend\models\ChannelSearch;
use backend\models\Goodssku;
use backend\models\OaWishgoods;
use backend\models\Wishgoodssku;
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
     * Updates an existing Channel model. dafault Wish
     * If update is successful, the browser will be redirected to the 'editwish' page.
     * @param integer $id.
     * @return mixed
     */

    public function actionUpdate($id)
    {

        $info = Channel::findOne($id);
        $Goodssku = Goodssku::find()->where(['pid'=>$id])->all();
        $sku = OaWishgoods::find()->where(['infoid'=>$id])->all();
        $dataProvider = new ActiveDataProvider([
            'query' => Wishgoodssku::find()->where(['pid'=>$id]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        if (!$info) {
            throw new NotFoundHttpException("The product was not found.");
        }


        if($sku[0]->load(Yii::$app->request->post())){
           $dataPost =  $_POST;
            $sku[0]['main_image'] =  $dataPost['main_image'];
           unset( $sku[0]['extra_images']);
            foreach($dataPost["extra_images"] as $key=>$value){
                $sku[0]['extra_images'] .= $value."\r\n";

            }

            $sku[0]->update(false);
            echo '更新成功！';
//            return $this->redirect(['update','id'=>$info->pid]);

        }else{
            return $this->render('editwish',[
                'info' =>$info,
                'dataProvider' => $dataProvider,
                'Goodssku' => $Goodssku[0],
                'sku' => $sku[0],

            ]);
        }
    }


    /*
     * 多属性信息
     */
    public function actionVarations($id='86'){
        $sku = OaWishgoods::find()->where(['infoid'=>$id])->all();
        $dataProvider = new ActiveDataProvider([
            'query' => Wishgoodssku::find()->where(['pid'=>$id]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->renderAjax('varations',[
            'dataProvider' => $dataProvider,
            'sku' => $sku[0],

        ]);
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

    //导出数据
    public  function actionExport($id){

        $objPHPExcel = new \PHPExcel();
        $sheet=0;

        $objPHPExcel->setActiveSheetIndex($sheet);
        $foos[0] = OaWishgoods::find()->where(['infoid'=>$id])->all();
        $variants = Wishgoodssku::find()->where(['pid'=>$id])->all();
        $variation = [];
        $varitem = [];
        foreach($variants as $key=>$value){
            $varitem['sku'] = $value['sku'];
            $varitem['color'] = $value['color'];
            $varitem['size'] = $value['size'];
            $varitem['inventory'] = $value['inventory'];
            $varitem['price'] = $value['price'];
            $varitem['shipping'] = $value['shipping'];
            $varitem['msrp'] = $value['msrp'];
            $varitem['shipping_time'] = $value['shipping_time'];
            $varitem['main_image'] = $value['linkurl'];
            $variation[] = $varitem;
        }
    $strvariant = json_encode($variation,true);



        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);

        $objPHPExcel->getActiveSheet()->setTitle('xxx')
            ->setCellValue('A1', 'sku')
            ->setCellValue('B1', 'selleruserid')
            ->setCellValue('C1', 'name')
            ->setCellValue('D1', 'inventory')
            ->setCellValue('E1', 'price')
            ->setCellValue('F1', 'msrp')
            ->setCellValue('G1', 'shipping')
            ->setCellValue('H1', 'shipping_time')
            ->setCellValue('I1', 'main_image')
            ->setCellValue('J1', 'extra_images')
            ->setCellValue('K1', 'variants')
            ->setCellValue('L1', 'landing_page_url')
            ->setCellValue('M1', 'tags')
            ->setCellValue('N1', 'description')
            ->setCellValue('O1', 'brand')
            ->setCellValue('P1', 'upc');

        $row=2;

        foreach ($foos as $foo) {

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$foo[0]['SKU']);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,'01-buycloth');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$foo[0]['title']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$foo[0]['inventory']);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$foo[0]['price']);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$foo[0]['msrp']);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$foo[0]['shipping']);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,'shipping_time');
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,$foo[0]['main_image']);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row,$foo[0]['extra_images']);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,$strvariant);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,'landing_page_url');
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$row,$foo[0]['tags']);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$row,$foo[0]['description']);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$row,'brand');
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$row,'upc');

            $row++ ;
        }

        header('Content-Type: application/vnd.ms-excel');
        $filename = "MyExcelReport_".date("d-m-Y-His").".xls";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
}
