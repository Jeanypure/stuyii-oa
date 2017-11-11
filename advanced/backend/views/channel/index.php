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



    <p>
        <?= Html::a(Yii::t('app', '标记已完善'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    </div>

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
            [
                'attribute'=> 'cate',
                'value'=>'oa_goods.cate'
            ],
            [
                'attribute'=> 'subCate',
                'value'=>'oa_goods.subCate'
            ],
//            'oaGoods.cate',
//            'oaGoods.subCate',
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
