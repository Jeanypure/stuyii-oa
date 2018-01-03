<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\dialog\Dialog;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OaGoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '已审批';
$this->params['breadcrumbs'][] = $this->title;
$viewUrl = Url::toRoute('view');
use yii\bootstrap\Modal;
Modal::begin([
    'id' => 'view-modal',
//    'header' => '<h4 class="modal-title">认领产品</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
]);
//echo
Modal::end();

$js = <<<JS

// 查看框
$('.data-view').on('click',  function () {
        $.get('{$viewUrl}',  { id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }
        );
    });
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

      /*      [ 'class' => 'kartik\grid\ActionColumn',
                'template' =>'{view} {fail} {trash}',
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

                    'fail' => function ($url, $model, $key) {
                        $options = [
                            'title' => '不通过',
                            'aria-label' => '不通过',
                            'data-toggle' => 'modal',
                            'data-target' => '#fail-dialog',
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
                            'data-target' => '#fail-dialog',
                            'data-id' => $key,
                            'class' => 'data-fail',
                        ];
                        return Html::a('<span  class="glyphicon glyphicon-trash"></span>', '#', $options);
                    }
                ],
            ],*/
            centerFormat('img'),
            centerFormat('cate'),
            centerFormat('subCate'),
            centerFormat('vendor1'),
//            centerFormat('vendor2'),
//            centerFormat('vendor3'),
            centerFormat('origin1'),
//            centerFormat('origin2'),
//            centerFormat('origin3'),
            centerFormat('devNum'),
            centerFormat('developer'),
            centerFormat('introducer'),
//            centerFormat('devStatus'),
            centerFormat('checkStatus'),
            centerFormat('approvalNote'),

            centerFormat('createDate'),
            centerFormat('updateDate'),
            centerFormat('salePrice'),
            centerFormat('hopeWeight'),
            centerFormat('hopeCost'),
            centerFormat('hopeRate'),
            centerFormat('hopeSale'),
            centerFormat('hopeMonthProfit'),


        ],
    ]); ?>
</div>

<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(function () {

        $('.glyphicon-eye-open').addClass('icon-cell');
        $('.wrapper').addClass('body-color');

        //通过对话框
        $('.data-fail').on('click', function () {
            var id = $(this).closest('tr').data('key');
            krajeeDialog.confirm("确定不通过？", function(result) {
                if(result){
                    $.get('/oa-check/fail?id=' + id );
                }
            });

        })

        //失败对话框
        $('.data-fail').on('click', function () {
            var id = $(this).closest('tr').data('key');
            krajeeDialog.confirm("确定作废？", function(result) {
                if(result){
                    $.get('/oa-check/fail?id=' + id );
                }
            });

        })
        });
</script>