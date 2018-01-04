<?php

namespace backend\controllers;

use PHPUnit\Framework\Exception;
use Yii;
use backend\models\OaGoods;
use backend\models\OaGoodsSearch;
use backend\models\OaGoodsinfo;
use backend\models\OaSysRules;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
/**
 * OaCheckController implements the CRUD actions for OaGoods model.
 */
class OaCheckController extends Controller
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


    public function actionToCheck()
    {
        $searchModel = new OaGoodsSearch();
        //待审批产品
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'','待审批','');

        return $this->render('toCheck', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Action of Pass
     * @param integer $id
     * @return mixed
     */
    public function actionPassForm($id)
    {
        $model = $this->findModel($id);
        return $this->renderAjax('passForm',[
            'model' => $model
        ]);

    }
    /**
     * Action of Pass
     * @return mixed
     */
    public function actionPass()
    {
        $request = yii::$app->request->post()['OaGoods'];
        $connection = yii::$app->db;
        $id = $request['nid'];
        $approvalNote = $request['approvalNote'];
        $model = $this->findModel($id);
        $trans = $connection->beginTransaction();
        try{
            $cate = $model->cate;
            $_model = new OaGoodsinfo();
            $model ->checkStatus = '已审批';
            $model ->approvalNote = $approvalNote;
            $model ->updateDate = strftime('%F %T');
            $model->update(false);
            //审批状态改变之后就插入数据到OaGoodsInfo
            $code = $this->generateCode($cate);
            $nid = $model->nid;
            $img = $model->img;
            $developer = $model->developer;
            $_model->goodsid =$nid;
            $_model->GoodsCode =$code;
            $_model->picUrl = $img;
            $_model->developer =$developer;
            $_model->devDatetime =strftime('%F %T');;
            $_model->updateTime =strftime('%F %T');;
            $_model->achieveStatus='待处理';
            $_model->GoodsName='';
            if(empty($_model->possessMan1)){
                $arc_model = OaSysRules::find()->where(['ruleKey' => $developer])->andWhere(['ruleType' => 'dev-arc-map'])->one();
                $arc = $arc_model->ruleValue;
                $_model->possessMan1 = $arc;
            }

            if(empty($_model->Purchaser)){
                $pur_model = OaSysRules::find()->where(['ruleKey' => $developer])->andWhere(['ruleType' => 'dev-pur-map'])->one();
                $pur = $pur_model->ruleValue;
                $_model->Purchaser = $pur;
            }
            if($_model->save(false)){
                $trans->commit();
                return "保存成功";
            }
            else {
                throw new Exception('Fail to save data');
            }
        }
        catch (Exception $e){
            $trans->rollBack();
            return "保存失败！";
        }
//        return $this->redirect(['to-check']);
    }


    /**
     * Action of Pass Lots
     * @return mixed
     */
    public function actionPassLots()
    {
        $_model = new OaGoodsinfo();
        $ids = yii::$app->request->post()["id"];
        $connection = yii::$app->db;
        foreach ($ids as $id)
        {
            $trans = $connection->beginTransaction();
            try{
                $model = $this->findModel($id);
                //插入到OagoodsInfo里面
                $developer = $model->developer;
                $_model = clone $_model;
                $nid = $model->nid;
                $img = $model->img;
                $cate = $model->cate;
                $code = $this->generateCode($cate);
                $_model->goodsid =$nid;
                $_model->GoodsCode =$code;
                $_model->picUrl = $img;
                $_model->developer =$developer;
                $_model->devDatetime =strftime('%F %T');
                $_model->updateTime =strftime('%F %T');
                $_model->achieveStatus='待处理';
                $_model->GoodsName='';
                $arc_model = OaSysRules::find()->where(['ruleKey' => $developer])->andWhere(['ruleType' => 'dev-arc-map'])->one();
                $pur_model = OaSysRules::find()->where(['ruleKey' => $developer])->andWhere(['ruleType' => 'dev-pur-map'])->one();
                $arc = $arc_model->ruleValue;
                $pur = $pur_model->ruleValue;
                $_model->possessMan1 = $arc;
                $_model->Purchaser = $pur;
                $model->checkStatus = '已审批';
                if(!($_model->save(false))) {
                    throw new Exception('fail to insert data into oa-goodsInfo!');
                }
                if(!$model->save(false)){
                    throw new Exception('fail to update checkStatus!');
                }
                $trans->commit();
            }
            catch (Exception $e){
                $trans->rollBack();
            }
        }
        return $this->redirect(['to-check']);
    }

    /**
     * Action of Pass
     * @param integer $id
     * @return mixed
     */
    public function actionFailForm($id)
    {
        $model = $this->findModel($id);
        return $this->renderAjax('failForm',[
            'model' => $model
        ]);

    }
    /**
     * Action of Fail
     * @return mixed
     */
    public function actionFail()
    {
        $request = yii::$app->request->post()['OaGoods'];
        $id = $request['nid'];
        $approvalNote = $request['approvalNote'];
        $model = $this->findModel($id);
        $model ->checkStatus = '未通过';
        $model ->approvalNote = $approvalNote;
        $model ->updateDate = strftime('%F %T');
        $model->update(false);
        return $this->redirect(['to-check']);
    }


    /**
     * Action of Fail Lots
     * @return mixed
     */
    public function actionFailLots()
    {
        $ids = yii::$app->request->post()["id"];
        foreach ($ids as $id)
        {
            $model = $this->findModel($id);
            $model->checkStatus ='未通过';
            $model->update(['checkStatus']);
        }
        return $this->redirect(['to-check']);
    }

    /**
     * Action of Fail
     * @param integer $id
     * @return mixed
     */
    public function actionTrash($id)
    {
        $model = $this->findModel($id);
        $model ->checkStatus = '已作废';
        $model ->updateDate = strftime('%F %T');
        $model->update(array('checkStatus','developer','updateDate'));
        return $this->redirect(['to-check']);
    }


    /**
     * Action of Fail Lots
     * @return mixed
     */
    public function actionTrashLots()
    {
        $ids = yii::$app->request->post()["id"];
        foreach ($ids as $id)
        {
            $model = $this->findModel($id);
            $model->checkStatus ='已作废';
            $model->update(['checkStatus']);
        }
        return $this->redirect(['to-check']);
    }


    /**
     * Action of Passed
     * @return mixed
     */
    public function actionPassed()
    {
        $searchModel = new OaGoodsSearch();
        // 已审批产品
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'','已审批','');
        return $this->render('passed', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Action of Failed
     * @return mixed
     */
    public function actionFailed()
    {
        $searchModel = new OaGoodsSearch();
        //未通过产品
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'','未通过','');
        return $this->render('failed', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Action of delete goods where status is '未通过'
     * @params integer  $id
     * @return mixed
     */
     public function actionDelete($id){

         $this->findModel($id)->delete();

         return $this->redirect(['failed']);
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->nid]);
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
            return $this->render('update', [
                'model' => $model,
            ]);
        }
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

    /**
     * @param $cate
     * @return string $code
     */
    private function generateCode($cate)
    {
        $connection = Yii::$app->db;
        $b_previous_code = $connection->createCommand(
            "select isnull(goodscode,'UN0000') as maxCode from b_goods where nid in 
            (select max(bgs.nid) from B_Goods as bgs left join B_GoodsCats as bgc
            on bgs.GoodsCategoryID= bgc.nid where bgc.CategoryParentName='$cate' and len(goodscode)=6)"
        )->queryOne();

        $oa_previous_code = $connection->createCommand(
            "select isnull(goodscode,'UN0000') as maxCode from oa_goodsinfo
            where pid in (select max(pid) from oa_goodsinfo as info LEFT join 
            oa_goods as og on info.goodsid=og.nid where cate = '$cate')")->queryOne();

        $oa_goodsId_query= $connection->createCommand("select max(nid) as maxNid from os_goods")->queryOne();
        $oa_maxNid = $oa_goodsId_query['maxNid'];

        //按规则生成编码
        $b_max_code =$b_previous_code['maxCode'];
        $oa_max_code = str_replace('-test','',$oa_previous_code['maxCode']);

        if(is_numeric($oa_max_code)){
            return strval($oa_maxNid).'-test';
        }
        if(intval(substr($b_max_code,2,4))>=intval(substr($oa_max_code,2,4))) {
            $max_code = $b_max_code;
        }
        else {
            $max_code = $oa_max_code;
        }
        $head = substr($max_code,0,2);
        $tail = intval(substr($max_code,2,4));
        $code = $oa_maxNid;
        while($tail<=9999)
        {
            $tail = $tail + 1;
            $zero_bit = substr('0000',0,4-strlen($tail));
            $code = $head.$zero_bit.$tail;
            //检查SKU是否已经存在
            $check_oa_goods = $connection->createCommand(
                "select * from oa_goodsinfo where goodscode= '$code'"
            )->queryOne();
            $check_b_goods = $connection->createCommand(
                "select * from b_goods where goodscode= '$code'"
            )->queryOne();
            if((empty($check_oa_goods) && empty($check_b_goods))) {
                break;
            }
            else{
                $code = $oa_maxNid;
            }
        }
        return $code.'-test';
    }
}
