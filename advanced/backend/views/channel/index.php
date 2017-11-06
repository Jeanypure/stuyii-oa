<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ChannelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '平台信息');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channel-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Channel'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\ActionColumn'],

//            'pid',
//            'IsLiquid',
//            'IsPowder',
//            'isMagnetism',
//            'IsCharged',
            // 'description',
            [
                'attribute' => 'picUrl',
                'value' =>function($model,$key, $index, $widget) {
                    return "<img src='$model->picUrl' width='100' height='100'/>";
                },
                'format' => 'raw',
            ],
            'GoodsCode',
             'GoodsName',
            'oa_goods.cate',
            'oa_goods.subCate',
            // 'AliasCnName',
            // 'AliasEnName',
            // 'PackName',
            // 'Season',

             'SupplierName',
             'StoreName',
            'developer',
             'Purchaser',
             'possessMan1',

            // 'possessMan2',
            // 'DeclaredValue',
            // 'picUrl:url',
            // 'goodsid',

            // 'achieveStatus',
             'devDatetime',
            'completeStatus',
            'DictionaryName',


            // 'updateTime',
            // 'picStatus',
            // 'SupplierID',
            // 'StoreID',
            // 'AttributeName',
            // 'bgoodsid',


        ],
    ]); ?>
</div>
