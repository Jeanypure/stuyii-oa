<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2017-12-20
 * Time: 9:37
 */

namespace backend\controllers;

use Yii;
use yii\base\Controller;
use yii\filters\VerbFilter;
use backend\models\ChannelSearch;
use backend\models\Channel;
use yii\data\ActiveDataProvider;

/**
 * Class OaDataCenterController show all data we have
 * @package backend\controllers
 */
class OaDataCenterController extends Controller
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
            ]
        ];
    }


    /**
     * @brief show data
     * @return mixed
     */
    public function actionTemplates(){
        $searchModel = new ChannelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'oa-data-center');

        return $this->render('templates',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }
}