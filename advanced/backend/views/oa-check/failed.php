<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\dialog\Dialog;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OaGoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '未通过';
$this->params['breadcrumbs'][] = $this->title;

//创建模态框
use yii\bootstrap\Modal;
Modal::begin([
    'id' => 'view-modal',
//    'header' => '<h4 class="modal-title">认领产品</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
]);
//echo
Modal::end();


$viewUrl = Url::toRoute('view');
$passUrl = Url::toRoute(['pass']);
$deleteUrl = Url::toRoute(['delete']);

$js = <<<JS
// 查看框
$('.data-view').on('click',  function () {
        $.get('{$viewUrl}',  { id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }
        );
    });

//删除1条
   $('.data-fail').on('click', function () {
            var id = $(this).closest('tr').data('key');
            krajeeDialog.confirm("确定作废？", function(result) {
                if(result){
                    $.post('{$deleteUrl}?id=' + id );
                }
            });

        });
       
   $('.glyphicon-eye-open').addClass('icon-cell');
        $('.wrapper').addClass('body-color');

        //通过对话框
        $('.data-pass').on('click', function () {
            var id = $(this).closest('tr').data('key');
            krajeeDialog.confirm("确定通过审批？", function(result) {
                if(result){
                    $.post('{$passUrl}',{'OaGoods[nid]':id},
                    function(msg) {
                        //krajeeDialog.alert(msg, function(res) {
                            location.reload();
                        //});
                    });
                }
            });
        })

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
    <?= GridView::widget([
        'bootstrap' => true,
        'responsive'=>true,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
            ],


            ['class' => 'kartik\grid\SerialColumn'],

            [ 'class' => 'kartik\grid\ActionColumn',
                'template' =>'{view} {pass} {fail}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $options = [
                            'title' => '查看',
                            'aria-label' => '查看',
                            'data-toggle' => 'modal',
                            'data-target' => '#view-modal',
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
                            'data-target' => '#pass-dialog',
                            'data-id' => $key,
                            'class' => 'data-pass',
                        ];
                        return Html::a('<span  class="glyphicon glyphicon-thumbs-up"></span>', '#', $options);
                    },
                    'fail' => function ($url, $model, $key) {
                        $options = [
                            'title' => '作废',
                            'aria-label' => '作废',
                            'data-toggle' => 'modal',
                            'data-target' => '#fail-dialog',
                            'data-id' => $key,
                            'class' => 'data-fail',
                        ];
                        return Html::a('<span  class="glyphicon glyphicon-trash"></span>', '#', $options);
                    }
                ],
            ],
            centerFormat('img'),
            //centerFormat('cate'),
            [
                'attribute' => 'cate',
                'width' => '150px',
                'format' => 'raw',
                'value' => function ($data) {
                    return "<span class='cell'>" . $data->cate . "</span>";
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\models\GoodsCats::findAll(['CategoryParentID' => 0]),'CategoryName', 'CategoryName'),
                //'filter'=>ArrayHelper::map(\backend\models\OaGoodsinfo::find()->orderBy('pid')->asArray()->all(), 'pid', 'IsLiquid'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '-请选择-'],
                //'group'=>true,  // enable grouping
            ],
            centerFormat('subCate'),
            centerFormat('vendor1'),
            centerFormat('origin1'),
            centerFormat('devNum'),
            centerFormat('developer'),
            centerFormat('introducer'),
            centerFormat('checkStatus'),
            centerFormat('approvalNote'),
            //centerFormat('createDate'),
            //centerFormat('updateDate'),
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

<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script>
//    function heart(id) {
//        krajeeDialog.prompt({label:'认领到：', dropdown:'正向/逆向'}, function (result) {
//            if(result){
//                $.get('/oa-goods/heart?id=' + id);
//            }
//
//        });
//        return false;
//    }
    $(function () {




        });
</script>