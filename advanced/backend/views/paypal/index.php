<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EbayPaypalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '添加PayPal账号';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-ebay-paypal-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加PayPal账号', "javascript:void(0);", ['data-href' => Url::to(['create']), 'class' => 'index-create btn btn-primary']) ?>
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
                            ['data-href' => Url::to(['view', 'id' => $model['nid']]), 'class' => 'index-view', 'data-id' => $model['nid']]);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', 'javascript:void(0);',
                            ['data-href' => Url::to(['update', 'id' => $model['nid']]), 'class' => 'index-update', 'data-id' => $model['nid']]);
                    },
                ]
            ],
            'paypalName',
            'usedNum',
        ],
    ]); ?>
</div>
<script>
    window.onload = function () {
        $('.index-create').on('click', function () {
            var url = $(this).data('href');
            $.get(url, function (msg) {
                bootbox.dialog({
                    message: msg,
                    title: "添加PayPal账号",
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
                    title: "编辑PayPal账号",
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
                    title: "PayPal账号详情",
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
    <?php //$this->registerJs($this->blocks['js'], \yii\web\View::POS_END); ?>
</script>