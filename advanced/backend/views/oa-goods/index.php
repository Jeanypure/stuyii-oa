<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\dialog\Dialog;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OaGoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '产品推荐';
$this->params['breadcrumbs'][] = $this->title;
//创建认领模态框

use yii\bootstrap\Modal;
Modal::begin([
    'id' => 'heart-modal',
    'header' => '<h4 class="modal-title">认领产品</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
]);
//echo
Modal::end();


//绑定模态框事件

$requestUrl = Url::toRoute('heart');
$js = <<<JS
    // 批量作废
    $('.fail-lots').on('click',function() {
    var ids = $("#oa-goods").yiiGridView("getSelectedRows");
    var self = $(this);
    if(ids.length == 0) return false;
     $.ajax({
           url:"/oa-goods/fail-lots",
           type:"post",
           data:{id:ids},
           success:function(res){
                console.log("yeah lots failed!");
           }
        });
    });
    
    //认领对话
    $('.data-heart').on('click',  function () {
        $.get('{$requestUrl}',  { id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }
        );
    });
    
    //图标剧中
        $('.glyphicon-eye-open').addClass('icon-cell');
        $('.wrapper').addClass('body-color');

    //文件导入事件

   
    

JS;
$this->registerJs($js);

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
        /*border:1px solid #666;*/
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
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增产品', ['create'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('批量导入', "javascript:void(0);", ['title' => 'upload', 'class' => 'upload btn btn-info']) ?>
        <?= Html::a('批量修改', ['editLots'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('批量作废',"javascript:void(0);",  ['title'=>'failLots','class' => 'fail-lots btn btn-danger']) ?>
        <?= Html::a('下载模板', ['template'], ['class' => 'btn btn-success']) ?>
        <input type="file" id="import" name="import" style="display: none">
    </p>

    <?= GridView::widget([
        'bootstrap' => true,
        'responsive'=>true,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'oa-goods',
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
                'template' =>'{view} {update} {delete} {heart}',
                'buttons' => [

                    'heart' => function ($url, $model, $key) {
                        /*
                        $options = [
                            'id'=> 'oa-goods-heart'.$model->nid,
                            'name'=> 'oa-goods-heart'.$model->nid,
                            'title' => '认领',
                            'aria-label' => '认领',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                            'onclick' => "heart(".$model->nid.")"

                        ];
                        return Html::a('<span  class="glyphicon glyphicon-heart"></span>',"javascript:void(0);", $options);
                        */
                        $options = [
                            'title' => '认领',
                            'aria-label' => '认领',
                            'data-toggle' => 'modal',
                            'data-target' => '#heart-modal',
                            'data-id' => $key,
                            'class' => 'data-heart',
//                            'onclick' => "heart(".$model->nid.")"

                        ];
                        return Html::a('<span  class="glyphicon glyphicon-heart"></span>', '#', $options);
                    }
                ],
            ],
        ],
    ]); ?>

    <script src="https://rawgit.com/evanplaice/jquery-csv/master/src/jquery.csv.js"></script>
    <script></script>
</div>

