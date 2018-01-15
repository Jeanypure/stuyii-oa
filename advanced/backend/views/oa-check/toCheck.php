<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OaGoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '待审批';
$this->params['breadcrumbs'][] = $this->title;

use yii\bootstrap\Modal;
Modal::begin([
    'id' => 'tocheck-modal',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
    'size' => "modal-lg"
]);
Modal::end();


$viewUrl = Url::toRoute('view');
$failUrl = Url::toRoute('fail');
$passUrl = Url::toRoute('pass-form');
$failUrl = Url::toRoute('fail-form');
$failLotsUrl = Url::toRoute('fail-lots');
$passLotsUrl = Url::toRoute('pass-lots');
$trashLotsUrl = Url::toRoute('trash-lots');

$js = <<<JS

//通过对话框
$('.data-pass').on('click',function() {
    $('.modal-body').children('div').remove();
    $.get('{$passUrl}',  { id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }
        );
});

// 失败对话框
$('.data-fail').on('click',function() {
     $('.modal-body').children('div').remove();
    $.get('{$failUrl}',  { id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }
        );
});

// 查看框
$('.data-view').on('click',  function () {
         $('.modal-body').children('div').remove();
        $.get('{$viewUrl}',  { id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }
        );
    });
    
    
    // 批量未通过
    $('.fail-lots').on('click',function() {
    var ids = $("#oa-check").yiiGridView("getSelectedRows");
    var self = $(this);
    if(ids.length == 0) return false;
     $.ajax({
           url:"{$failLotsUrl}",
           type:"post",
           data:{id:ids},
           success:function(res){
                console.log("oh no lots failed!");
           }
        });
    });
    
    //批量通过
   $('.pass-lots').on('click',function() {
    var ids = $("#oa-check").yiiGridView("getSelectedRows");
    var self = $(this);
    if(ids.length == 0) return false;
     $.ajax({
           url:"{$passLotsUrl}",
           type:"post",
           data:{id:ids},
           success:function(res){
                console.log(res);
           }
        });
    });
    
    //批量作废
   $('.trash-lots').on('click',function() {
    var ids = $("#oa-check").yiiGridView("getSelectedRows");
    var self = $(this);
    if(ids.length == 0) return false;
     $.ajax({
           url:"{$trashLotsUrl}",
           type:"post",
           data:{id:ids},
           success:function(res){
                console.log("oh yeah lots of trash!");
           }
        });
    });
    
    //图标剧中
        $('.glyphicon-eye-open').addClass('icon-cell');
        $('.wrapper').addClass('body-color');


JS;
$this->registerJs($js);

// Example 2
//单元格居中类
class CenterFormatter {
    public function __construct($name) {
        $this->name = $name;
    }
    public  function format() {
        // 超链接显示为超链接
        if ($this->name === 'origin'||$this->name === 'origin1'||$this->name === 'origin1'
            ||$this->name === 'origin2'||$this->name === 'origin3'||$this->name === 'vendor1'||$this->name === 'vendor2'
            ||$this->name === 'vendor3') {
            return  [
                'attribute' => $this->name,
                'value' => function($data) {
                    if(!empty($data[$this->name]))
                    {
                        try {
                            $hostName = parse_url($data[$this->name])['host'];
                        }
                        catch (Exception $e){
                            $hostName = "www.unknown.com";
                        }
                        return "<a class='cell' href='{$data[$this->name]}' target='_blank'>{$hostName}</a>";
                    }
                    else
                    {
                        return '';
                    }
                },
                'format' => 'raw',

            ];
            // 图片显示为图片
        }
        if ($this->name === 'img') {
            return [
                'attribute' => 'img',
                'value' => function($data) {
                    return "<img src='".$data[$this->name]."' width='100' height='100'>";
                },
                'format' => 'raw',

            ];
        }
        if (strpos(strtolower($this->name), 'date') || strpos(strtolower($this->name), 'time')) {
            return [
                'attribute' => $this->name,
                'value' => function($data) {
                    return "<span class='cell'>".substr($data[$this->name],0,10)."</span>";

                },
                'format' => 'raw',

            ];

        }
        return  [
            'attribute' => $this->name,
            'value' => function($data) {
                return "<span class='cell'>".$data[$this->name]."</span>";
//                    return $data['cate'];
            },
            'format' => 'raw',


        ];
    }
};
//封装到格式化函数中
function centerFormat($name) {
    return (new CenterFormatter($name))->format();
};
?>
<style>
    .cell {
        Word-break: break-all;
        display: table-cell;
        vertical-align: middle;
        text-align: center;
        width: 100px;
        height: 100px;
    }

    .icon-cell {
        Word-break: break-all;
        display: table-cell;
        vertical-align: middle;
        text-align: center;
        width: 10px;
        height: 100px;
    }
    .body-color {
        background-color: whitesmoke;
    }
</style>
<div class="oa-goods-index">
   <!-- 页面标题-->
    <p>
        <?= Html::a('批量通过',"javascript:void(0);",  ['title'=>'passLots','class' => 'pass-lots btn btn-info']) ?>

        <?= Html::a('批量未通过',"javascript:void(0);",  ['title'=>'failLots','class' => 'fail-lots btn btn-warning']) ?>

        <?= Html::a('批量作废',"javascript:void(0);",  ['title'=>'trashLots','class' => 'trash-lots btn btn-danger']) ?>
    </p>
    <?= GridView::widget([
        'bootstrap' => true,
        'responsive'=>true,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'oa-check',
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn',],
            ['class' => 'kartik\grid\SerialColumn'],
            [ 'class' => 'kartik\grid\ActionColumn',
                'template' =>'{view} {pass} {fail} {trash}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $options = [
                            'title' => '查看',
                            'aria-label' => '查看',
                            'data-toggle' => 'modal',
                            'data-target' => '#tocheck-modal',
                            'data-id' => $key,
                            'class' => 'data-view',
                        ];
                        return Html::a('<span  class="glyphicon glyphicon-eye-open"></span>', '#', $options);
                    },
                    'pass' => function ($url, $model, $key) {
                        $options = [
                            'title' => '通过',
                            'aria-label' => '通过',
                            'data-toggle' => 'modal',
                            'data-target' => '#tocheck-modal',
                            'data-id' => $key,
                            'class' => 'data-pass',
                        ];
                        return Html::a('<span  class="glyphicon glyphicon-thumbs-up"></span>', '#', $options);
                    },
                    'fail' => function ($url, $model, $key) {
                        $options = [
                            'title' => '未通过',
                            'aria-label' => '未通过',
                            'data-toggle' => 'modal',
                            'data-target' => '#tocheck-modal',
                            'data-id' => $key,
                            'class' => 'data-fail',
                        ];
                        return Html::a('<span  class="glyphicon glyphicon-thumbs-down"></span>', '#', $options);
                    },
                    'trash' => function ($url, $model, $key) {
                        $options = [
                            'title' => '作废',
                            'aria-label' => '作废',
                            'data-toggle' => 'modal',
                            'data-target' => '#trash-dialog',
                            'data-id' => $key,
                            'class' => 'data-trash',
                        ];
                        return Html::a('<span  class="glyphicon glyphicon-trash"></span>', '#', $options);
                    },
                ],
            ],
            centerFormat('img'),
            [
                'attribute' => 'cate',
                'width' => '150px',
                'format' => 'raw',
                'value' => function ($data) {
                    return "<span class='cell'>" . $data->cate . "</span>";
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\models\GoodsCats::findAll(['CategoryParentID' => 0]),'CategoryName', 'CategoryName'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '-请选择-'],
            ],
            centerFormat('subCate'),
            centerFormat('vendor1'),
            centerFormat('origin1'),
            centerFormat('devNum'),
            centerFormat('developer'),
            centerFormat('introducer'),
            centerFormat('checkStatus'),
            [
                'attribute' => 'createDate',
                'format' => 'raw',
                //'format' => ['date', "php:Y-m-d"],
                'value' => function ($model) {
                    return "<span class='cell'>" . substr(strval($model->createDate), 0, 10) . "</span>";
                },
                'width' => '200px',
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'value' => Yii::$app->request->get('OaGoodsSearch')['createDate'],
                        'convertFormat' => true,
                        'useWithAddon' => true,
                        'format' => 'php:Y-m-d',
                        'todayHighlight' => true,
                        'locale'=>[
                            'format' => 'YYYY-MM-DD',
                            'separator'=>'/',
                            'applyLabel' => '确定',
                            'cancelLabel' => '取消',
                            'daysOfWeek'=>false,
                        ],
                        'opens'=>'left',
                        //起止时间的最大间隔
                        /*'dateLimit' =>[
                            'days' => 300
                        ]*/
                    ]
                ]
            ],
            [
                'attribute' => 'updateDate',
                'label' => '更新时间',
                'format' => "raw",
                'value' => function ($model) {
                    return "<span class='cell'>" . substr(strval($model->updateDate), 0, 10) . "</span>";
                },
                'width' => '200px',
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'value' => Yii::$app->request->get('OaGoodsSearch')['updateDate'],
                        'convertFormat' => true,
                        'todayHighlight' => true,
                        'locale'=>[
                            'format' => 'YYYY-MM-DD',
                            'separator'=>'/',
                            'applyLabel' => '确定',
                            'cancelLabel' => '取消',
                            'daysOfWeek'=>false,
                        ],
                        'opens'=>'left',
                        //起止时间的最大间隔
                        /*'dateLimit' =>[
                            'days' => 300
                        ]*/
                    ]
                ]
            ],
            centerFormat('salePrice'),
            centerFormat('hopeWeight'),
            centerFormat('hopeCost'),
            centerFormat('hopeRate'),
            centerFormat('hopeSale'),
            centerFormat('hopeMonthProfit'),
            centerFormat('stockUp'),
        ],
    ]); ?>
</div>

