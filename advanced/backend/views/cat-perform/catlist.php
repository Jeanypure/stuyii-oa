<?php
use  \kartik\grid\GridView;
use   yii\helpers\ArrayHelper;
echo GridView::widget([
    'dataProvider'=>$dataProvider,
//    'filterModel'=>$searchModel,
    'showPageSummary'=>true,
    'pjax'=>true,
    'striped'=>true,
    'hover'=>true,
    'panel'=>['type'=>'primary', 'heading'=>'Grid Grouping Example'],
    'columns'=>[
        ['class'=>'kartik\grid\SerialColumn'],
        [
            'attribute'=>'CategoryParentName',
            'width'=>'310px',
            'value'=>function ($model, $key, $index, $widget) {
                return $model['CategoryParentName'];
            },
            'group'=>true,  // enable grouping
            'pageSummary'=>'Page Summary',
            'pageSummaryOptions'=>['class'=>'text-right text-warning'],
        ],
        [
            'attribute'=>'catCodeNum',
//            'header'=>'产品总款数',
            'pageSummary'=>true,


        ],[
            'attribute'=>'non_catCodeNum',
            'pageSummary'=>true,

        ],
        [
            'attribute'=>'numRate',
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 2],
//            'header'=>'非清仓款数占比%',
            'pageSummary'=>true,
            'pageSummaryFunc'=>GridView::F_AVG
        ],
        [
            'attribute'=>'l_qty',
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 0],
            'header'=>'销量',
            'pageSummary'=>true
        ],
        [
            'attribute'=>'non_l_qty',
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 0],
            'header'=>'非请仓-销量',
            'pageSummary'=>true
        ],
        [
            'attribute'=>'qtyRate',
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 0],
            'header'=>'销量占比',
            'pageSummary'=>true
        ],  [
            'attribute'=>'l_AMT',
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 0],
            'header'=>'销售额($)',
            'pageSummary'=>true
        ],  [
            'attribute'=>'non_l_AMT',
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 0],
            'header'=>'非请仓-销售额($)',
            'pageSummary'=>true
        ],
        [
            'attribute'=>'amtRate',
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 0],
            'header'=>'销售额占比(%)',
            'pageSummary'=>true
        ],

    ],
]);