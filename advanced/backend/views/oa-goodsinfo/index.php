<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\OaGoodsinfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '属性信息';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="oa-goodsinfo-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('批量导入普源', ['id' => 'input-lots', 'class' => 'btn btn-success']) ?>
        <?= Html::button('重新生成商品编码', ['id' => 'generate-code', 'class' => 'btn btn-info']) ?>
        <?= Html::button('标记已完善', ['id' => 'complete-lots', 'class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([

        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showPageSummary' => true,//显示统计栏，默认为false
        'id' => 'oa-goodsinfo',
        //'pjax' => true,
        //'floatHeader'=>true,//向下滚动时，标题栏可以fixed，默认为false
        'striped' => true,
        //'responsive' => true,//自适应，默认为true
        'hover' => true,//鼠标移动上去时，颜色变色，默认为false
//        'panel'=>['type'=>'primary', 'heading'=>'基本信息'],
        'columns' => [
            ['class' => 'kartik\grid\CheckboxColumn'],
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view} {update} {input} {complete} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $options = [
                            'title' => '查看',
                            'aria-label' => '查看',
                            'data-toggle' => 'modal',
                            'data-target' => '#index-modal',
                            'data-id' => $key,
                            'class' => 'index-view',
                        ];
                        return Html::a('<span  class="glyphicon glyphicon-eye-open"></span>', '#', $options);
                    },
                    'input' => function ($url, $model, $key) {
                        $options = [
                            'title' => '导入普源',
                            'aria-label' => '导入普源',
                            'data-id' => $key,
                            'class' => 'index-input',
                        ];
                        return Html::a('<span  class="glyphicon glyphicon-send"></span>', '#', $options);
                    },
                    'complete' => function ($url, $model, $key) {
                        $options = [
                            'title' => '标记已完善',
                            'aria-label' => '标记已完善',
                            'data-id' => $key,
                            'class' => 'index-complete',
                        ];
                        return Html::a('<span  class="glyphicon glyphicon-check"></span>', '#', $options);
                    },
                ],
            ],
            [
                'attribute' => 'picUrl',
                'value' => function ($model, $key, $index, $widget) {
                    return "<img src='$model->picUrl' width='100' height='100'/>";
                },
                'format' => 'raw',
                'width' => '100px',
            ],
            'GoodsCode',
            [
                'attribute' => 'achieveStatus',
                'width' => '100px',
            ],
            'GoodsName',
            'developer',
            [
                'attribute' => 'devDatetime',
                //'format' => ['date', "php:Y-m-d"],
                'value' => function ($model) {
                    return substr(strval($model->devDatetime),0,10);
                },
                'width' => '250px',
                'contentOptions' => ['width'=>'250px'],
                'headerOptions' => ['width' => '250px'],
                //'filterType' => GridView::FILTER_DATE,
                'filter' => \kartik\widgets\DatePicker::widget([
                    'name' => 'OaGoodsinfoSearch[devDatetime]',
                    'value' => Yii::$app->request->get('OaGoodsinfoSearch')['devDatetime'],
                    'convertFormat' => true,
                    'pluginOptions' => [
                        //'autoclose' => true,
                        'format' => 'php:Y-m-d',
                        'todayHighlight' => true,
                    ]
                ])
            ],
            [
                'attribute' => 'updateTime',
                'label' => '更新时间',
                //'format' => ['date', "php:Y-m-d"],
                'value' => function ($model) {
                    return substr(strval($model->updateTime),0,10);
                },
                'width' => '300px',
                'headerOptions' => ['width' => '300px'],
                //'filterType' => GridView::FILTER_DATE,
                'filter' => \kartik\widgets\DatePicker::widget([
                    'name' => 'OaGoodsinfoSearch[updateTime]',
                    'value' => Yii::$app->request->get('OaGoodsinfoSearch')['updateTime'],
                    'convertFormat' => true,
                    'pluginOptions' => [
                        //'autoclose' => true,
                        'format' => 'php:Y-m-d',
                        'todayHighlight' => true,
                    ]
                ])
            ],
            'AliasCnName',
            'AliasEnName',
            [
                'attribute' => 'IsLiquid',
                'width' => '110px',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->IsLiquid;
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>[1 => '是', 0 => '否'],
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions' => ['placeholder' => '是否是液体'],
                //'group'=>true,  // enable grouping
            ],
            [
                'attribute' => 'IsPowder',
                'width' => '100px',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [1 => '是', 0 => '否'],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '是否是粉末'],
            ],
            [
                'attribute' => 'isMagnetism',
                'width' => '100px',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [1 => '是', 0 => '否'],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '是否带磁'],
            ],
            [
                'attribute' => 'IsCharged',
                'width' => '100px',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [1 => '是', 0 => '否'],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '是否带电'],
            ],
            [
                'attribute' => 'isVar',
                'width' => '100px',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ['是' => '是', '否' => '否'],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '是否多属性'],
            ],
        ],
    ]); ?>

    <?php
    //创建模态框
    use yii\bootstrap\Modal;

    Modal::begin([
        'id' => 'index-modal',
        'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
        'size' => "modal-lg"
    ]);
    //echo
    Modal::end();

    $viewUrl = Url::toRoute('view');
    $inputUrl = Url::toRoute('input');
    $inputLotsUrl = Url::toRoute('input-lots');
    //$generateUrl = Url::toRoute('generate-code');
    $completeUrl = Url::toRoute('complete');
    $completeLotsUrl = Url::toRoute('complete-lots');
    $js = <<<JS



// 查看框
$('.index-view').on('click',  function () {
    $.get('{$viewUrl}',{ id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }
        );
    });


//单个导入普源
$('.index-input').on('click', function() {
    id = $(this).closest('tr').data('key');
    
    $.ajax({
        url: '{$inputUrl}',
        type: "get",
        data: {id:id},
        success:function(res) {
            alert(res);
        }
    });
});

//批量导入普源
$('#input-lots').on('click', function() {
    ids = $('#oa-goodsinfo').yiiGridView('getSelectedRows');
    // alert(ids);
   $.ajax({
          url: '{$inputLotsUrl}',
          type:"post",
          data:{ids:ids},
          success:function(res){
               alert(res);
               //可以前端更改状态，也可以异步刷新   
          }
       });
});

//重新生成商品编码
$('#generate-code').on('click',function() {
    ids = $('#oa-goodsinfo').yiiGridView('getSelectedRows');
    $.get('/oa-goodsinfo/generate-code',{ids:ids});
});


//单个标记已完善
$(".index-complete").on('click',function() {
    id = $(this).closest('tr').data('key');
    
    $.ajax({
        url:'{$completeUrl}',
        type:'get',
        data:{id:id},
        success:function(res) {
            alert(res);//传回结果信息
        }
    });
});

//批量标记完善
$("#complete-lots").on('click',function() {
    ids = $("#oa-goodsinfo").yiiGridView('getSelectedRows');
    $.ajax({
        url:'{$completeLotsUrl}',
        type:'get',
        data:{ids:ids},
        success:function(res) {
            alert(res);
        }
    });
});
JS;
$this->registerJs($js);
?>


