<?php

namespace backend\controllers;

use PHPUnit\Framework\Exception;
use Yii;
use yii\base\Model;
use backend\models\Goodssku;
use backend\models\OaSysRules;
use backend\models\OaGoodsinfo;
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

    public function actionSaveOnly($pid,$type)
    {

        $request = Yii::$app->request;
        $model = new Goodssku();
        if($request->isPost)
        {
            //提交过来的表单数据
            try

            {
                if($type == 'goods-info')
                {
                    $skuRows = $request->post()['Goodssku'];
                    foreach ($skuRows as $row_key=>$row_value)
                    {
                        $row_value['pid'] = intval($pid); //pid传进来
                        $sid = $row_key;
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
                        {
                            $update_model = Goodssku::find()->where(['sid' => $sid])->one();
                            $update_model->sku = $row_value['sku'];
                            $update_model->property1 = $row_value['property1'];
                            $update_model->property2 = $row_value['property2'];
                            $update_model->property3 = $row_value['property3'];
                            $update_model->CostPrice = $row_value['CostPrice'];
                            $update_model->Weight = $row_value['Weight'];
                            $update_model->RetailPrice = $row_value['RetailPrice'];
                            $update_model->update(['sku','property1','property2','property3',
                                'CostPrice','Weight','RetailPrice']);

//                        echo "{'msg':'update successfully'}";

                        }

                    }
                    $this->redirect(['oa-goodsinfo/update','id'=>$pid]);
                }

                if($type == 'pic-info')
                {
                    $Rows = $request->post()['Goodssku'];
                    foreach ($Rows as $row_key=>$row_value)
                    {
                        $sid = $row_key;
                        $update_model = Goodssku::find()->where(['sid' => $sid])->one();
                        $update_model->linkurl = $row_value['linkurl'];
                        $update_model->save(false);

                    }
                    $this->redirect(['oa-picinfo/update','id'=>$pid]);
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

    public function actionSaveComplete($pid,$type)
    {
        $request = Yii::$app->request;
        $model = new Goodssku();

        if($request->isPost)
        {
            //提交过来的表单数据
            try
            {
                if($type=='goods-info')
                {
                    $skuRows = $request->post()['Goodssku'];
                    foreach ($skuRows as $row_key=>$row_value)
                    {
                        $row_value['pid'] = intval($pid); //pid传进来
                        $sid = $row_key;
                        //新增行
                        if(strstr($row_key,'New'))
                        {
                            $_model = clone $model;
                            //配合rules 进行安全检查;需要改变的数据都要声明下类型。
                            $_model ->setAttributes($row_value,true); //逐行入库
                            $_model->save(false);
                        }
                        //更新行
                        else
                        {
                            $update_model = Goodssku::find()->where(['sid' => $sid])->one();
                            $update_model->sku = $row_value['sku'];
                            $update_model->property1 = $row_value['property1'];
                            $update_model->property2 = $row_value['property2'];
                            $update_model->property3 = $row_value['property3'];
                            $update_model->CostPrice = $row_value['CostPrice'];
                            $update_model->Weight = $row_value['Weight'];
                            $update_model->RetailPrice = $row_value['RetailPrice'];
                            $update_model->update(false);

                        }

                    }

                    //更新产品状态
                    $goods_model = OaGoodsinfo::find()->where(['pid' => $pid])->one();
                    $developer = $goods_model ->developer;
                    try {
                        $arc_model = OaSysRules::find()->where(['ruleKey' => $developer])->andWhere(['ruleType' => 'dev-arc-map'])->one();
                        $pur_model = OaSysRules::find()->where(['ruleKey' => $developer])->andWhere(['ruleType' => 'dev-pur-map'])->one();
                        $arc = $arc_model->ruleValue;
                        $pur = $pur_model->ruleValue;
                        $goods_model ->achieveStatus = '已完善';
                        $goods_model ->picStatus = '待处理';
                        $goods_model->updateTime =strftime('%F %T');
                        $goods_model->possessMan1 = $arc;
                        $goods_model->Purchaser = $pur;
                        $goods_model->update(false);
                        echo "保存完成";
//                        $this->redirect(['oa-goodsinfo/index']);
                    }
                    catch (\Exception $e) {
                        echo $e;
                        echo "美工或采购填写不对,请仔细检查数据";
                    }



                }

                if ($type=='pic-info')
                {
                    $Rows = $request->post()['Goodssku'];

                    foreach ($Rows as $row_key=>$row_value)
                    {
                        $sid = $row_key;
                        $update_model = Goodssku::find()->where(['sid' => $sid])->one();
                        $update_model->linkurl = $row_value['linkurl'];

                        $update_model->save(false);

                    }
                    //更新商品状态
                    $goods_model = OaGoodsinfo::find()->where(['pid' => $pid])->one();
                    $goods_model ->picStatus = '已完善';
                    $goods_model->updateTime =strftime('%F %T');
                    $goods_model->update();
//                 $arr = [33,36,38,40,42,43,51,66,81,82,83,84,85,91,93,100,104,105,106,107,108,110,
//                     111,115,116,117,118,122,124,130,134,155,157,165,166,167,168,170,172,176,197,200,
//                     201,225,233,234,235,236,237,238];
//
//                    foreach ($arr as $key=>$value){
//                        $sql_wish = "exec P_oaGoods_TowishGoods '".$value."'";
//                        $posts = Yii::$app->db->createCommand($sql_wish)->execute();
//                    }


                    //标记完善时，开产品导入ebay和wish模板

                    //图片验空
                   $pic_url = array_column($Rows, 'linkurl');
                   $val_count = array_count_values($pic_url);
                   $res = array_key_exists('',  $val_count);

                   if(!$res){
                       $sql_wish = "exec P_oaGoods_TowishGoods '".$pid."'";
                       $sql_ebay = "";
                       $posts = Yii::$app->db->createCommand($sql_wish)->execute();

//
                    }
                    $this->redirect(['oa-goodsinfo/index']);
                    $this->redirect(['oa-picinfo/update','id'=>$pid]);

                }


            }
            catch (Exception  $e)
            {
                echo $e;
            }

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
