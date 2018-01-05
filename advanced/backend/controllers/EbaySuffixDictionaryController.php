<?php

namespace backend\controllers;

use backend\models\EbaySuffixDictionarySearch;
use backend\models\OaEbayPaypal;
use backend\models\OaPaypal;
use Yii;
use yii\db\Exception;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
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
        $model = $this->findModel($id);
        $arr1 = OaEbayPaypal::find()->joinWith('payPal')->andWhere(['ebayId' => $id, 'maptype' => 'high'])->asArray()->one();
        $arr2 = OaEbayPaypal::find()->joinWith('payPal')->andWhere(['ebayId' => $id, 'maptype' => 'low'])->asArray()->one();
        if($arr1) $model->highEbayPaypal = $arr1['payPal']['paypalName'];
        if($arr2) $model->lowEbayPaypal = $arr2['payPal']['paypalName'];
        return $this->renderAjax('view', [
            'model' => $model,
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
        $request = Yii::$app->request;
        if ($request->isPost) {
            $post = $request->post('OaEbaySuffix');
            //var_dump($post);exit;
            $transaction = OaEbaySuffix::getDb()->beginTransaction();
            try {
                $model->attributes = $post;
                $model->save();
                //var_dump($post);exit;
                //保存大额账号
                if (isset($post['highEbayPaypal']) and $post['highEbayPaypal']) {
                    $ebayPaypal = new OaEbayPaypal();
                    $ebayPaypal->ebayId = $model->nid;
                    $ebayPaypal->paypalId = $post['highEbayPaypal'];
                    $ebayPaypal->mapType = 'high';
                    $ebayPaypal->save();
                    //增加PayPal账号绑定数量
                    OaPaypal::updateAll(['usedNum' => new Expression('COALESCE("usedNum",0)+1')], ['nid' => $post['highEbayPaypal']]);
                }
                //保存小额账号
                if (isset($post['lowEbayPaypal']) and $post['lowEbayPaypal']) {
                    $ebayPaypal = new OaEbayPaypal();
                    $ebayPaypal->ebayId = $model->nid;
                    $ebayPaypal->paypalId = $post['lowEbayPaypal'];
                    $ebayPaypal->mapType = 'low';
                    $ebayPaypal->save();
                    //增加PayPal账号绑定数量
                    OaPaypal::updateAll(['usedNum' => new Expression('COALESCE("usedNum",0)+1')], ['nid' => $post['highEbayPaypal']]);
                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
            return $this->redirect(['index']);
        }
        if ($request->isGet) {
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
        $request = Yii::$app->request;
        if ($request->isPost) {
            $post = $request->post('OaEbaySuffix');
            //var_dump($post);exit;
            $transaction = OaEbaySuffix::getDb()->beginTransaction();
            try {
                $model->attributes = $post;
                $model->save();
                //var_dump($post);exit;
                //保存大额账号
                if (isset($post['highEbayPaypal']) and $post['highEbayPaypal']) {
                    $ebayPaypal = OaEbayPaypal::findOne(['ebayId' => $id, 'mapType' => 'high']);
                    //判断该账号是否有高额账号
                    if ($ebayPaypal) {
                        if ($ebayPaypal['paypalId'] != $post['highEbayPaypal']) {
                            //减少原有关联PayPal账号使用量
                            OaPaypal::updateAll(['usedNum' => 'IF(usedNum<1,0,usedNum-1)'], ['nid' => $ebayPaypal['paypalId']]);
                            //更新新的关联关系
                            $ebayPaypal->paypalId = $post['highEbayPaypal'];
                            $ebayPaypal->save();
                            //增加新的关联PayPal账号使用量
                            OaPaypal::updateAll(['usedNum' => new Expression('COALESCE("usedNum",0)+1')], ['nid' => $post['highEbayPaypal']]);

                        }
                    } else {
                        $ebayPaypalModel = new OaEbayPaypal();
                        $ebayPaypalModel->ebayId = $id;
                        $ebayPaypalModel->paypalId = $post['highEbayPaypal'];
                        $ebayPaypalModel->mapType = 'high';
                        $ebayPaypalModel->save();
                        //增加新的PayPal账号使用量
                        OaPaypal::updateAll(['usedNum' => new Expression('COALESCE("usedNum",0)+1')], ['nid' => $post['highEbayPaypal']]);

                    }
                }
                //保存小额账号
                if (isset($post['lowEbayPaypal']) and $post['lowEbayPaypal']) {
                    $ebayPaypalLow = OaEbayPaypal::findOne(['ebayId' => $id, 'mapType' => 'low']);
                    //判断该账号是否有低额账号
                    if ($ebayPaypalLow) {
                        if ($ebayPaypalLow['paypalId'] != $post['lowEbayPaypal']) {
                            //减少原有关联PayPal账号使用量
                            OaPaypal::updateAll(['usedNum' => 'IF(usedNum<1,0,usedNum-1)'], ['nid' => $ebayPaypalLow['paypalId']]);
                            //$query = OaPaypal::updateAll(['usedNum' => new Expression('IF([usedNum]<1,0,COALESCE("usedNum",0)-1)')], ['nid' => $ebayPaypalLow['paypalId']]);
                            //更新新的关联关系
                            $ebayPaypalLow->paypalId = $post['lowEbayPaypal'];
                            $ebayPaypalLow->save();
                            //增加新的关联PayPal账号使用量
                            OaPaypal::updateAll(['usedNum' => new Expression('COALESCE("usedNum",0)+1')], ['nid' => $post['lowEbayPaypal']]);

                        }
                    } else {
                        $ebayPaypalLowModel = new OaEbayPaypal();
                        $ebayPaypalLowModel->ebayId = $id;
                        $ebayPaypalLowModel->paypalId = $post['lowEbayPaypal'];
                        $ebayPaypalLowModel->mapType = 'high';
                        $ebayPaypalLowModel->save();
                        //增加新的PayPal账号使用量
                        OaPaypal::updateAll(['usedNum' => new Expression('COALESCE("usedNum",0)+1')], ['nid' => $post['lowEbayPaypal']]);

                    }
                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
            return $this->redirect(['index']);
        }
        if ($request->isGet) {
            //初始化PayPal账号值
            $model->highEbayPaypal = ArrayHelper::getColumn(OaEbayPaypal::findAll(['ebayId' => $id, 'mapType' => 'high']), 'paypalId');
            //var_dump($model->highEbayPaypal);exit;
            $model->lowEbayPaypal = ArrayHelper::getColumn(OaEbayPaypal::findAll(['ebayId' => $id, 'mapType' => 'low']), 'paypalId');
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
        //var_dump($id);exit;
        $transaction = OaEbaySuffix::getDb()->beginTransaction();
        try {
            //判断该账号是否有高额账号
            $ebayPaypal = OaEbayPaypal::findOne(['ebayId' => $id, 'mapType' => 'high']);
            if ($ebayPaypal) {
                //减少关联PayPal账号使用量
                OaPaypal::updateAll(['usedNum' => 'IF(usedNum<1,0,usedNum-1)'], ['nid' => $ebayPaypal['paypalId']]);
            }

            //判断该账号是否有低额账号
            $ebayPaypalLow = OaEbayPaypal::findOne(['ebayId' => $id, 'mapType' => 'low']);
            if ($ebayPaypalLow) {
                //减少关联PayPal账号使用量
                OaPaypal::updateAll(['usedNum' => 'IF(usedNum<1,0,usedNum-1)'], ['nid' => $ebayPaypalLow['paypalId']]);
            }

            $this->findModel($id)->delete();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the WishSuffixDictionary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WishSuffixDictionary the loaded model || NotFoundHttpException
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

    /**
     * 添加、编辑是进行异步验证
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionValidateForm()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = Yii::$app->request->get('id');
        if ($id) {
            $model = $this->findModel($id);
        } else {
            $model = new OaEbaySuffix();
        }
        $model->load(Yii::$app->request->post());
        return \yii\widgets\ActiveForm::validate($model);
    }
}
