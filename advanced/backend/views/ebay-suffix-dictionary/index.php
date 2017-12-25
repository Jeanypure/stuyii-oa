<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WishSuffixDictionarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ebay账号字典';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wish-suffix-dictionary-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?php //echo Html::a('添加ebay账号', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('添加ebay账号', "javascript:void(0);", ['title' => 'create', 'data-toggle' => 'modal', 'data-target' => '#index-modal',
            'data-href' => Url::to(['create']), 'class' => 'index-create btn btn-primary']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'headerOptions' => ['width' => '200'],
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', 'javascript:void(0);',
                            ['data-href' => Url::to(['view', 'id' => $model['nid']]), 'class' => 'index-view']);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', 'javascript:void(0);',
                            ['data-href' => Url::to(['update', 'id' => $model['nid']]), 'class' => 'index-update']);
                    },
                ]
            ],
            //'nid',
            'ebayName',
            'ebaySuffix',
            'nameCode',
            'mainImg',
            [
                'attribute' => 'highEbayPaypal',
                'value' => function($model){
                    $id = $model->nid;
                    $arr = \backend\models\OaEbayPaypal::find()->joinWith('payPal')->andWhere(['ebayId' => $id, 'maptype' => 'high'])->asArray()->one();
                    //var_dump($arr);exit;
                    if($arr){
                        return $arr['payPal']['paypalName'];
                    }
                },
                //'payPal.paypalName',
            ],
            [
                'attribute' => 'lowEbayPaypal',
                'value' => function($model){
                    $id = $model->nid;
                    $arr = \backend\models\OaEbayPaypal::find()->joinWith('payPal')->andWhere(['ebayId' => $id, 'maptype' => 'low'])->asArray()->one();
                    //var_dump($arr);exit;
                    if($arr){
                        return $arr['payPal']['paypalName'];
                    }
                },
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
<script>
    window.onload = function (ev) {
        $('.index-create').on('click', function () {
            var url = $(this).data('href');
            $.get(url, function (msg) {
                bootbox.dialog({
                    message: msg,
                    title: "添加Ebay账号",
                    buttons: {
                        cancel: {
                            label: "取消",
                            className: 'btn-default',
                        },
                    }
                });
            })
        });
        $('.index-update').on('click', function () {
            var url = $(this).data('href');
            $.get(url, function (msg) {
                bootbox.dialog({
                    message: msg,
                    title: "编辑Ebay账号",
                    buttons: {
                        cancel: {
                            label: "取消",
                            className: 'btn-default',
                        },
                    }
                });
            })
        });
        $('.index-view').on('click', function () {
            var url = $(this).data('href');
            $.get(url, function (msg) {
                bootbox.dialog({
                    message: msg,
                    title: "Ebay账号详情",
                    buttons: {
                        cancel: {
                            label: "取消",
                            className: 'btn-default',
                        },
                    }
                });
            })
        });
    }
</script>

