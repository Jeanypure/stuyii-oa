<?php

use  yii\helpers\Html;
use \kartik\form\ActiveForm;
use  \kartik\grid\GridView;
use kartik\daterange\DateRangePicker;

$this->title = '类别表现';
?>
<?php //echo $this->render('_search'); ?>
<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<div class="product-perform-index">

    <!--搜索框开始-->
    <div class="box-body row">
        <?php $form = ActiveForm::begin([
            'action' => ['product-perform/index'],
            'method' => 'get',
            'options' => ['class' => 'form-inline drp-container form-group col-lg-12'],
            'fieldConfig' => [
                'template' => '{label}<div class="form-group text-right">{input}{error}</div>',
                //'labelOptions' => ['class' => 'col-lg-3 control-label'],
                'inputOptions' => ['class' => 'form-control'],
            ],
        ]); ?>

        <?= $form->field($model, 'cat', ['template' => '{label}{input}', 'options' => ['class' => 'col-lg-2']])
            ->dropDownList($list, ['prompt' => '请选择开发员'])->label('开发员:') ?>

        <?= $form->field($model, 'type', [
            'template' => '{label}{input}',
            'options' => ['class' => 'col-lg-2']
        ])->dropDownList(['0' => '交易时间', '1' => '发货时间'], ['placeholder' => '交易类型'])->label('交易类型:'); ?>

        <?= $form->field($model, 'order_range', [
            'template' => '{label}{input}{error}',
            //'addon' => ['prepend' => ['content' => '<i class="glyphicon glyphicon-calendar"></i>']],
            'options' => ['class' => 'col-lg-3']
        ])->widget(DateRangePicker::classname(), [
            'pluginOptions' => [
                'autoUpdateOnInit' => true,
                'startDate' => date("Y-m-01"),
                'endDate' => date("Y-m-d"),
                //'autoclose'=>true,
                'format' => 'yyyy-mm-dd',
            ]
        ])->label("<span style = 'color:red'>* 时间必选:</span>"); ?>

        <?= $form->field($model, 'create_range', [
            'template' => '{label}{input}{error}',
            //'addon' => ['prepend' => ['content' => '<i class="glyphicon glyphicon-calendar"></i>']],
            'options' => ['class' => 'col-lg-3']
        ])->widget(DateRangePicker::classname(), [
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ])->label("开发时间:"); ?>

        <div class="">
            <?= Html::submitButton('<i class="glyphicon glyphicon-hand-up"></i> 确定', ['class' => 'btn btn-primary']); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <!--搜索框结束-->

    <!--列表开始-->
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
//    'filterModel'=>$searchModel,
        'showPageSummary' => true,
        'pjax' => true,
        'striped' => true,
        'hover' => true,
        'panel' => ['type' => 'primary', 'heading' => '类目表现'],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'GoodsCode',
                'header' => '商品编码',
                'width' => '310px',
                'value' => function ($model, $key, $index, $widget) {
                    return $model['GoodsCode'];
                },
                'group' => true,  // enable grouping
                'pageSummary' => 'Page Summary',
                'pageSummaryOptions' => ['class' => 'text-right text-warning'],
            ],
            [
                'attribute' => 'GoodsName',
                'label' => '商品名称',
                'pageSummary' => true,
            ],
            [
                'attribute' => 'CreateDate',
                'label' => '开发日期',
                'pageSummary' => true,
            ],
            [
                'attribute' => 'Developer',
                'width' => '150px',
                'hAlign' => 'right',
                //'format' => ['decimal', 2],
                'label' => '开发员',
                'pageSummary' => true,
                'pageSummaryFunc' => GridView::F_AVG
            ],
            [
                'attribute' => 'Introducer',
                'width' => '150px',
                'hAlign' => 'right',
                //'format' => ['decimal', 0],
                'label' => '推荐人',
                'pageSummary' => true
            ],
            [
                'attribute' => 'GoodsStatus',
                'width' => '150px',
                'hAlign' => 'right',
                //'format' => ['decimal', 0],
                'label' => '产品状态',
                'pageSummary' => true
            ],
            [
                'attribute' => 'l_qty',
                'width' => '150px',
                'hAlign' => 'right',
                'format' => ['decimal', 0],
                'label' => '销量',
                'pageSummary' => true
            ],
            [
                'attribute' => 'l_AMT',
                'width' => '150px',
                'hAlign' => 'right',
                'format' => ['decimal', 0],
                'label' => '销售额($)',
                'pageSummary' => true
            ],
        ],
    ]); ?>
    <!--列表结束-->
</div>




