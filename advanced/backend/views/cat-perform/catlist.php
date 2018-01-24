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
            'attribute'=>'supplier_id',
            'width'=>'310px',
            'value'=>function ($model, $key, $index, $widget) {
                return $model->supplier->company_name;
            },
            'filterType'=>GridView::FILTER_SELECT2,
//            'filter'=>ArrayHelper::map(Suppliers::find()->orderBy('company_name')->asArray()->all(), 'id', 'company_name'),
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Any supplier'],
            'group'=>true,  // enable grouping
        ],
        [
            'attribute'=>'category_id',
            'width'=>'250px',
            'value'=>function ($model, $key, $index, $widget) {
                return $model->category->category_name;
            },
            'filterType'=>GridView::FILTER_SELECT2,
           // 'filter'=>ArrayHelper::map(Categories::find()->orderBy('category_name')->asArray()->all(), 'id', 'category_name'),
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Any category']
        ],
        [
            'attribute'=>'product_name',
            'pageSummary'=>'Page Summary',
            'pageSummaryOptions'=>['class'=>'text-right text-warning'],
        ],
        [
            'attribute'=>'unit_price',
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 2],
            'pageSummary'=>true,
            'pageSummaryFunc'=>GridView::F_AVG
        ],
        [
            'attribute'=>'units_in_stock',
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 0],
            'pageSummary'=>true
        ],
        [
            'class'=>'kartik\grid\FormulaColumn',
            'header'=>'Amount In Stock',
            'value'=>function ($model, $key, $index, $widget) {
                $p = compact('model', 'key', 'index');
                return $widget->col(4, $p) * $widget->col(5, $p);
            },
            'mergeHeader'=>true,
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 2],
            'pageSummary'=>true
        ],
    ],
]);