<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

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
            <?= Html::a('添加ebay账号', "javascript:void(0);", ['title' => 'create', 'data-toggle' => 'modal', 'data-target' => '#index-modal', 'class' => 'index-create btn btn-primary']) ?>

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
                        'update' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', 'javascript:void(0);', ['class' => 'index-update', 'data-id' => $model['nid'], 'data-toggle' => 'modal', 'data-target' => '#sendMessage']);
                        },
                    ]
                ],
                //'nid',
                'ebayName',
                'ebaySuffix',
                'nameCode',
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>


<?php $this->beginBlock('js') ?>
    $('.index-create').on('click', function(){
    var url = '?r=ebay-suffix-dictionary/create';
    $.get(url, function (msg) {
    bootbox.dialog({
    message: msg,
    title: "添加Ebay账号",
    buttons:{
    cancel: {
    label: "取消",
    className: 'btn-info',
    },
    }
    });
    })
    });

    $('.index-update').on('click', function(){
    var id = $(this).data('id');
    var url = '?r=ebay-suffix-dictionary/update&id='+id;
    $.get(url, function (msg) {
    bootbox.dialog({
    message: msg,
    title: "编辑Ebay账号",
    buttons:{
    cancel: {
    label: "取消",
    className: 'btn-info',
    },
    }
    });
    })
    });
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['js'], \yii\web\View::POS_END); ?>