<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\dialog\Dialog;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OaGoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '产品审批';
$this->params['breadcrumbs'][] = $this->title;

//注册JS

$js = <<<JS

//批量作废
$('.fail-lots').on('click',function() {
    var ids = $("#oa-check").yiiGridView("getSelectedRows");
    var self = $(this);
    if(ids.length == 0) return false;
    console.log(ids);
     $.ajax({
           url:"/oa-check/fail-lots",
           type:"post",
           data:{id:ids},
           success:function(res){
                console.log("oh no lots failed!");
           }
        });
    });
    
//批量审核
$('.pass-lots').on('click',function() {
    var ids = $("#oa-check").yiiGridView("getSelectedRows");
    var self = $(this);
    if(ids.length == 0) return false;
    console.log(ids);
     $.ajax({
           url:"/oa-check/pass-lots",
           type:"post",
           data:{id:ids},
           success:function(res){
                console.log("oh yeah lots passed!");
           }
        });
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
        if ($this->name === 'origin1') {
            return  [
                'attribute' => $this->name,
                'value' => function($data) {
                    return "<a class='cell' href='{$data['origin1']}' target='_blank'>=></a>";
        },
                'format' => 'raw',

        ];
        // 图片显示为图片
        }
        if ($this->name === 'img') {
            return [
                'attribute' => 'img',
                'value' => function($data) {
                    return "<img src='{$data['img']}' width='100' height='100'>";
                },
                'format' => 'raw',

            ];
        }
        return  [
            'attribute' => $this->name,
            'value' => function($data) {
                return "<span class='cell'>".$data[$this->name]."</span>";
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
        <?= Html::a('批量通过',"javascript:void(0);", ['title'=>'passLots','class' => 'pass-lots btn btn-info']) ?>
        <?= Html::a('批量作废', "javascript:void(0);", ['title'=>'failLots','class' => 'fail-lots btn btn-danger']) ?>
    </p>
    <?= GridView::widget([
        'bootstrap' => true,
        'responsive'=>true,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'oa-check',
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
            ],

            ['class' => 'kartik\grid\SerialColumn'],


            centerFormat('img'),
            centerFormat('cate'),
            centerFormat('subCate'),
            centerFormat('vendor1'),
            centerFormat('vendor2'),
            centerFormat('vendor3'),
            centerFormat('origin1'),
            centerFormat('origin2'),
            centerFormat('origin3'),
            centerFormat('devNum'),
            centerFormat('developer'),
            centerFormat('introducer'),
            centerFormat('devStatus'),
            centerFormat('checkStatus'),
            centerFormat('createDate'),
            centerFormat('updateDate'),
            centerFormat('salePrice'),
            centerFormat('hopeWeight'),
            centerFormat('hopeRate'),
            centerFormat('hopeSale'),
            centerFormat('hopeMonthProfit'),
            [ 'class' => 'kartik\grid\ActionColumn',
                'template' =>'{pass} {fail}',
                'buttons' => [

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
        ],
    ]); ?>
</div>

<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(function () {

        $('.glyphicon-eye-open').addClass('icon-cell');
        $('.wrapper').addClass('body-color');

        //通过对话框
        $('.data-pass').on('click', function () {
            var id = $(this).closest('tr').data('key');
            krajeeDialog.confirm("确定通过审核？", function(result) {
                if(result){
                    $.get('/oa-check/pass?id=' + id );
                }
            });

        });

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