<?php

namespace backend\controllers;

use backend\models\GoodsCats;
use backend\models\OaForwardGoods;
use backend\models\OaBackwardGoods;
use PHPUnit\Framework\Exception;
use Yii;
use backend\models\OaGoods;
use backend\models\OaGoodsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \PHPExcel;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\web\Response;

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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, '', '');
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
     * Displays a single OaGoods model.
     * @param integer $id
     * @return mixed
     */
    public function actionForwardView($id)
    {
        return $this->renderAjax('forward-view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new OaGoods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param integer $pid
     * @param integer $typeid
     * @return mixed
     */
    public function actionCreate($pid = 0, $typeid = 1)
    {
        $model = new OaGoods();

        $request = Yii::$app->request;
        if ($request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                //默认值更新到当前行中
                $id = $model->nid;
                $cate = $model->cate;
                $cateModel = GoodsCats::find()->where(['nid' => $cate])->one();
                $current_model = $this->findModel($id);
                $user = yii::$app->user->identity->username;
                //根据类目ID更新类目名称
                $current_model->catNid = $cate;
                $current_model->cate = $cateModel->CategoryName;
                $current_model->devNum = '20' . date('ymd', time()) . strval($id);
                $current_model->devStatus = '';
                $current_model->checkStatus = '未认领';
                $current_model->introducer = $user;
                $current_model->updateDate = strftime('%F %T');
                $current_model->createDate = strftime('%F %T');
                $current_model->update(false);
                return $this->redirect(['index']);
            } else {

                echo "something Wrong!";
            }

        }

        if ($request->isGet) {
            $pid = (int)Yii::$app->request->get('pid');
            $typeid = (int)Yii::$app->request->get('typeid');
            $model->getCatList($pid);
            if ($typeid == 1) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $model->getCatList($pid);
            }

            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Updates an existing OaGoods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            //默认值更新到当前行中
            $id = $model->nid;
            $cate = $model->cate;
            $cateModel = GoodsCats::find()->where(['nid' => $cate])->one();
            $current_model = clone $model;
            //根据类目ID更新类目名称
            $current_model->catNid = $cate;
            $current_model->cate = $cateModel->CategoryName;

            $subCateNameModel = GoodsCats::find()->where(['NID' => $model->subCate])->one();
            $current_model->subCate = $subCateNameModel->CategoryName;

            $current_model->update(false);
            return $this->redirect(['index']);
        } else {
            //根据不同的状态返回不同的view
            $checkStatus = $model->checkStatus;
            if ($checkStatus === '未通过') {
                return $this->renderAjax('updateReset', [
                    'model' => $model,
                ]);
            } else {

                $request = Yii::$app->request;
                if ($request->isGet) {
                    $cid = (int)Yii::$app->request->get('pid');
                    $typeid = (int)Yii::$app->request->get('typeid');
                    $model->getCatList($cid);
                    if ($typeid == 1) {
                        Yii::$app->response->format = Response::FORMAT_JSON;
                        return $model->getCatList($cid);
                    }
                    return $this->renderAjax('update', [
                        'model' => $model,
                    ]);
                }


            }


        }
    }


    /**
     * Creates a new OaGoods model.
     * @param $type .
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionForwardCreate($type = 'create')
    {
        $model = new OaForwardGoods();

        $status = ['create' => '待提交', 'check' => '待审批'];
        $request = Yii::$app->request;
        if ($request->isPost) {
            if ($model->load($request->post()) && $model->save()) {
                //默认值更新到当前行中
                $id = $model->nid;
                $current_model = $this->findModel($id);
                $user = yii::$app->user->identity->username;

                //根据类目ID更新类目名称
                $sub_cate = $model->subCate;
                try {
                    $cateModel = GoodsCats::find()->where(['nid' => $sub_cate])->one();
                }
                catch (\Exception $e) {
                    $cateModel = GoodsCats::find()->where(['CategoryName' => $sub_cate])->one();
                }
                //自动计算预估月毛利
                $price = $current_model->salePrice;
                $rate = $current_model->hopeRate;
                $sale = $current_model->hopeSale;
                $moth_profit = $price*$rate*$sale*0.01;
                $current_model->hopeMonthProfit = $moth_profit;
                $current_model->devNum = '20' . date('ymd', time()) . strval($id);
                $current_model->devStatus = '正向认领';
                $current_model->checkStatus = $status[$type];
                $current_model->developer = $user;
                $current_model->updateDate = strftime('%F %T');
                $current_model->createDate = strftime('%F %T');
                $current_model->catNid = $cateModel->CategoryParentID;
                $current_model->cate = $cateModel->CategoryParentName;
                $current_model->subCate = $cateModel->CategoryName;
                $current_model->update(false);
                return $this->redirect(['forward-products']);
            } else {

                echo "something Wrong!";
            }

        }

        if ($request->isGet) {
            $pid = (int)Yii::$app->request->get('pid');
            $typeid = (int)Yii::$app->request->get('typeid');
            $model->getCatList($pid);
            if ($typeid == 1) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $model->getCatList($pid);
            }

            return $this->renderAjax('forwardCreate', [
                'model' => $model,
            ]);
        }

    }


    /**
     * Creates a new OaGoods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionBackwardCreate($type = 'create')
    {
        $status = ['create' => '待提交', 'check' => '待审批'];
        $model = new OaBackwardGoods();

        $request = Yii::$app->request;
        if ($request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
                //默认值更新到当前行中
                $id = $model->nid;
                $current_model = $this->findModel($id);
                $user = yii::$app->user->identity->username;
                //根据类目ID更新类目名称
                $sub_cate = $model->subCate;
                try {

                    $cateModel = GoodsCats::find()->where(['nid' => $sub_cate])->one();
                }
                catch (\Exception $e) {
                    $cateModel = GoodsCats::find()->where(['CategoryName' => $sub_cate])->one();
                }
                $current_model->cate = $cateModel->CategoryName;
                $price = $current_model->salePrice;
                $rate = $current_model->hopeRate;
                $sale = $current_model->hopeSale;
                $moth_profit = $price*$rate*$sale*0.01;
                $current_model->hopeMonthProfit = $moth_profit;
//                $subCateNameModel = GoodsCats::find()->where(['NID' => $model->subCate])->one();
//                $current_model->subCate = $subCateNameModel->CategoryName;
                $current_model->devNum = '20' . date('ymd', time()) . strval($id);
                $current_model->devStatus = '逆向认领';

                $current_model->checkStatus = $status[$type];;
                $current_model->developer = $user;
                $current_model->updateDate = strftime('%F %T');
                $current_model->createDate = strftime('%F %T');
                $current_model->catNid = $cateModel->CategoryParentID;
                $current_model->cate = $cateModel->CategoryParentName;
                $current_model->subCate = $cateModel->CategoryName;
                $current_model->update(false);
                return $this->redirect(['backward-products']);
            } else {
                echo "something Wrong!";
            }

        }

        if ($request->isGet) {
            $pid = (int)Yii::$app->request->get('pid');
            $typeid = (int)Yii::$app->request->get('typeid');
            $model->getCatList($pid);
            if ($typeid == 1) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $model->getCatList($pid);
            }

            return $this->renderAjax('backwardCreate', [
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
    public function actionForwardUpdate($id)
    {
//        $model = $this->findModel($id);
        $model = OaForwardGoods::find()->where(['nid' => $id]) ->one();

        if ($model->load(Yii::$app->request->post()) && $model->save(false) ) {

            //默认值更新到当前行中
            $sub_cate = $model->subCate;
            try {

                $cateModel = GoodsCats::find()->where(['nid' => $sub_cate])->one();
            }
            catch (\Exception $e) {
                $cateModel = GoodsCats::find()->where(['CategoryName' => $sub_cate])->one();
            }

            //根据类目ID更新类目名称
            $current_model = $this->findModel($id);
            $price = $current_model->salePrice;
            $rate = $current_model->hopeRate;
            $sale = $current_model->hopeSale;
            $moth_profit = $price*$rate*$sale*0.01;
            $current_model->hopeMonthProfit = $moth_profit;
            $current_model->catNid = $cateModel->CategoryParentID;
            $current_model->cate = $cateModel->CategoryParentName;
            $current_model->subCate = $cateModel->CategoryName;
            $current_model->update(false);
            return $this->redirect(['forward-products']);
        } else {
            // 根据不同的产品状态返回不同的view
            $status = $model->checkStatus;
            if ($status == '未通过') {
                return $this->renderAjax('forwardUpdateReset', [
                    'model' => $model,
                ]);
            } else {
                return $this->renderAjax('forwardUpdate', [
                    'model' => $model,
                ]);
            }


        }
    }

    public function actionForwardUpdateCheck($id)
    {
        $model = OaForwardGoods::find()->where(['nid' => $id]) ->one();


        if ($model->load(Yii::$app->request->post()) && $model->save(false) ) {

            //默认值更新到当前行中
            $sub_cate = $model->subCate;
            try {
                $cateModel = GoodsCats::find()->where(['nid' => $sub_cate])->one();
            }
            catch (\Exception $e) {
                $cateModel = GoodsCats::find()->where(['CategoryName' => $sub_cate])->one();
            }

            //根据类目ID更新类目名称
            $current_model = $this->findModel($id);
            $price = $current_model->salePrice;
            $rate = $current_model->hopeRate;
            $sale = $current_model->hopeSale;
            $moth_profit = $price*$rate*$sale*0.01;
            $current_model->hopeMonthProfit = $moth_profit;
            $current_model->catNid = $cateModel->CategoryParentID;
            $current_model->cate = $cateModel->CategoryParentName;
            $current_model->subCate = $cateModel->CategoryName;
            $current_model->checkStatus = '待审批';
            $current_model->update(false);
            return $this->redirect(['forward-products']);
        }

    }

    //2级分类
    public function actionCategory($typeid, $pid)
    {
        $request = Yii::$app->request;
        $model = new GoodsCats();
        if ($request->isGet) {
            $cid = (int)Yii::$app->request->get('pid');
            $typeid = (int)Yii::$app->request->get('typeid');
            $model->getCatList($cid);
            if ($typeid == 1) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $model->getCatList($cid);
            }
            return $this->renderAjax('update', [
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
    public function actionBackwardUpdate($id)
    {
        $model = OaForwardGoods::find()->where(['nid' => $id]) ->one();

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            //默认值更新到当前行中
            $cate = $model->cate;
            $cateModel = GoodsCats::find()->where(['nid' => $cate])->one();
            //根据类目ID更新类目名称
        $sub_cate = $model->subCate;
        try {
            $cateModel = GoodsCats::find()->where(['nid' => $sub_cate])->one();
        }
        catch (\Exception $e) {
            $cateModel = GoodsCats::find()->where(['CategoryName' => $sub_cate])->one();
        }

        //根据类目ID更新类目名称
            $current_model = $this->findModel($id);
            $price = $current_model->salePrice;
            $rate = $current_model->hopeRate;
            $sale = $current_model->hopeSale;
            $moth_profit = $price*$rate*$sale*0.01;
            $current_model->hopeMonthProfit = $moth_profit;
            $current_model->catNid = $cateModel->CategoryParentID;
            $current_model->cate = $cateModel->CategoryParentName;
            $current_model->subCate = $cateModel->CategoryName;
            $current_model->update(false);
            return $this->redirect(['backward-products']);
        } else {
            // 根据不同的产品状态返回不同的view
            $status = $model->checkStatus;
            if ($status == '未通过') {
                return $this->renderAjax('backwardUpdateReset', [
                    'model' => $model,
                ]);
            } else {
                return $this->renderAjax('backwardUpdate', [
                    'model' => $model,
                ]);
            }


        }
    }


    public function actionBackwardUpdateCheck($id)
    {
        $model = OaForwardGoods::find()->where(['nid' => $id]) ->one();
        if ($model->load(Yii::$app->request->post()) && $model->save(false) ) {

            //默认值更新到当前行中
            $sub_cate = $model->subCate;
            try {
                $cateModel = GoodsCats::find()->where(['nid' => $sub_cate])->one();
            }
            catch (\Exception $e) {
                $cateModel = GoodsCats::find()->where(['CategoryName' => $sub_cate])->one();
            }

            //根据类目ID更新类目名称
            $current_model = $this->findModel($id);
            $price = $current_model->salePrice;
            $rate = $current_model->hopeRate;
            $sale = $current_model->hopeSale;
            $moth_profit = $price*$rate*$sale*0.01;
            $current_model->hopeMonthProfit = $moth_profit;
            $current_model->catNid = $cateModel->CategoryParentID;
            $current_model->cate = $cateModel->CategoryParentName;
            $current_model->subCate = $cateModel->CategoryName;
            $current_model->checkStatus = '待审批';
            $current_model->update(false);
            return $this->redirect(['backward-products']);
        }

    }

    /**
     * Deletes an existing OaGoods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id, $type string
     * @return mixed
     */
    public function actionDelete()
    {
        $id = $_POST['id'];
        $type = $_POST['type'];
        $this->findModel($id)->delete();

        return $this->redirect([$type]);
    }






    /**
     * Recheck an existing OaGoods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionRecheck($id)
    {

        $model = $this->findModel($id);


        $model->checkStatus = '待审批';
        $model->update(['checkStatus']);
//        return $this->redirect(['index']);
    }

    /**
     * BackwardRecheck an existing OaGoods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBackwardRecheck($id)
    {

        $model = OaForwardGoods::find()->where(['nid' => $id]) ->one();

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            //默认值更新到当前行中
            $cate = $model->cate;
            $cateModel = GoodsCats::find()->where(['nid' => $cate])->one();
            //根据类目ID更新类目名称
            $sub_cate = $model->subCate;
            try {
                $cateModel = GoodsCats::find()->where(['nid' => $sub_cate])->one();
            }
            catch (\Exception $e) {
                $cateModel = GoodsCats::find()->where(['CategoryName' => $sub_cate])->one();
            }

            //根据类目ID更新类目名称
            $current_model = $this->findModel($id);
            $price = $current_model->salePrice;
            $rate = $current_model->hopeRate;
            $sale = $current_model->hopeSale;
            $moth_profit = $price*$rate*$sale*0.01;
            $current_model->hopeMonthProfit = $moth_profit;
            $current_model->catNid = $cateModel->CategoryParentID;
            $current_model->cate = $cateModel->CategoryParentName;
            $current_model->subCate = $cateModel->CategoryName;
            $current_model->checkStatus = '待审批';
            $current_model->update(false);
            return $this->redirect(['backward-products']);
        }
        echo  "something wrong";
    }


    /**
     * ForwardRecheck an existing OaGoods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionForwardRecheck($id)
    {

        $model = OaForwardGoods::find()->where(['nid' => $id]) ->one();
        //先更新数据
        if ($model->load(Yii::$app->request->post())  ) {
            //默认值更新到当前行中
            $sub_cate = $model->subCate;
            try {

                $cateModel = GoodsCats::find()->where(['nid' => $sub_cate])->one();
            }
            catch (\Exception $e) {
                $cateModel = GoodsCats::find()->where(['CategoryName' => $sub_cate])->one();
            }

            //根据类目ID更新类目名称
            $current_model = $this->findModel($id);
            $price = $current_model->salePrice;
            $rate = $current_model->hopeRate;
            $sale = $current_model->hopeSale;
            $moth_profit = $price*$rate*$sale*0.01;
            $current_model->hopeMonthProfit = $moth_profit;
            $current_model->catNid = $cateModel->CategoryParentID;
            $current_model->cate = $cateModel->CategoryParentName;
            $current_model->subCate = $cateModel->CategoryName;
            $current_model->checkStatus = '待审批';
            $current_model->update(false);
            return $this->redirect(['forward-products']);
        }
        echo  "something wrong";
    }


    /**
     * Trash an existing OaGoods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionTrash($id)
    {

        $model = $this->findModel($id);

        $model->checkStatus = '已作废';
        $model->update(['checkStatus']);
        return $this->redirect(['index']);
    }


    /**
     * Trash an existing OaGoods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBackwardTrash($id)
    {

        $model = $this->findModel($id);

        $model->checkStatus = '已作废';
        $model->update(['checkStatus']);
        return $this->redirect(['backward-products']);
    }


    /**
     * Trash an existing OaGoods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionForwardTrash($id)
    {

        $model = $this->findModel($id);

        $model->checkStatus = '已作废';
        $model->update(['checkStatus']);
        return $this->redirect(['backward-products']);
    }

    /**
     *  lots fail simultaneously
     * @param null
     * @return mixed
     */
    public function actionDeleteLots()
    {
        $ids = yii::$app->request->post()["id"];
        foreach ($ids as $id) {
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
        $outfile = 'template.csv';
        $template = htmlspecialchars_decode(file_get_contents('template.csv'));
        $outfile = 'template.csv';
        header('Content-type: application/octet-stream; charset=GB2312');
        Header("Accept-Ranges: bytes");
        header('Content-Disposition: attachment; filename=' . $outfile);
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
        $rows = json_decode($data, true)['data'];
        foreach ($rows as $row) {
            $_model = clone $model;
            $_model->setAttributes($row);
            if ($_model->save()) {
                $id = $_model->nid;
                $current_model = $this->findModel($id);
                $current_model->devNum = '20' . date('ymd', time()) . strval($id);
                $current_model->devStatus = '';
                $current_model->checkStatus = '';
                $current_model->introducer = $user;
                $current_model->updateDate = strftime('%F %T');
                $current_model->createDate = strftime('%F %T');
                $current_model->update(array('devStatus', 'developer', 'updateDate'));

            } else {

            }
        }
        return $this->redirect(['index']);

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

        return $this->renderAjax('heart', [
            'model' => $model,
        ]);
    }


    // Forward action

    public function actionForward($id)
    {
        $model = $this->findModel($id);
        $user = yii::$app->user->identity->username;

        $model->devStatus = '正向认领';
        $model->checkStatus = '已认领';
        $model->developer = $user;
        $model->updateDate = strftime('%F %T');
        $model->update(false);
        return $this->redirect(['index']);
    }

    //Backward action

    public function actionBackward($id)
    {
        $model = $this->findModel($id);
        $user = yii::$app->user->identity->username;
        $model->devStatus = '逆向认领';
        $model->checkStatus = '已认领';
        $model->developer = $user;
        $model->updateDate = strftime('%F %T');
        $model->update(false);
        return $this->redirect(['index']);
    }


    // forward products
    public function actionForwardProducts()
    {
        $searchModel = new OaGoodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, '正向认领', '');

        return $this->render('forwardProducts', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    // backward products
    public function actionBackwardProducts()
    {
        $searchModel = new OaGoodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, '逆向认领', '');

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


    /**
     * commit and approve
     * @param integer $id
     * @return string {'msg':'OK'} or {'msg':'fail'}
     *
     */

    public function actionApprove($id, $type)
    {

        $model = $this->findModel($id);
        $model->checkStatus = '待审批';
        $model->update(false);
        if ($model->save(false)) {
            return $this->redirect($type);
        } else {
            return "{'msg':'fail'}";
        }


    }

    /**
     * approveLots the products
     * @param $module []
     * @return mixed approve-lots
     */
    public function actionApproveLots()
    {
        $ids = yii::$app->request->post()["id"];
        $type = yii::$app->request->post()["type"];

        foreach ($ids as $id) {
            $model = $this->findModel($id);
            $model->checkStatus = '待审批';
            $model->update(false);

        }
        return $this->redirect($type);
    }
}




