<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ShippingServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '运输方式';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-shipping-service-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加', 'javascript:void(0);', ['data-href' => Url::to(['create']), 'class' => 'index-create btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
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
            'servicesName',
            [
                'attribute' => 'type',
                'value' => function($model){
        //var_dump($model);exit;
                    return Yii::$app->params['typeList'][$model->type];
                },
            ],
            [
                'attribute' => 'Name',
                'value' => 'country.Name',
            ],
            'ibayShipping',
        ],
    ]); ?>
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
