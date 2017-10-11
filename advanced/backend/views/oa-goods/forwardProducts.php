<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\OaGoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '正向产品';
$this->params['breadcrumbs'][] = $this->title;

//创建模态框

use yii\bootstrap\Modal;
Modal::begin([
    'id' => 'forward-modal',
//    'header' => '<h4 class="modal-title">保存</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
]);
//echo
Modal::end();

//模态框的方式查看和更改数据
$viewUrl = Url::toRoute('view');
$updateUrl = Url::toRoute('update');
$createUrl = Url::toRoute('create');
$js = <<<JS
// 查看框
$('.forward-view').on('click',  function () {
        $.get('{$viewUrl}',  { id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }
        );
    });

//更新框
$('.forward-update').on('click',  function () {
        $.get('{$updateUrl}',  { id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }
        );
    });


//创建框
$('.forward-create').on('click',  function () {
        $.get('{$createUrl}',
            function (data) {
                $('.modal-body').html(data);
            }
        );
    }); 
JS;
$this->registerJs($js);


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
                        return "<a class='cell' href='{$data[$this->name]}' target='_blank'>=></a>";
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
<div class="oa-goods-forward">
   <!-- 页面标题-->
    <p>
        <?= Html::a('新增产品',"javascript:void(0);",  ['title'=>'create','data-toggle' => 'modal','data-target' => '#forward-modal','class' => 'forward-create btn btn-primary']) ?>
        <?= Html::a('批量导入', "javascript:void(0);", ['title' => 'upload', 'class' => 'upload btn btn-info']) ?>
        <?= Html::a('批量删除',"javascript:void(0);",  ['title'=>'deleteLots','class' => 'delete-lots btn btn-danger']) ?>
        <?= Html::a('下载模板', ['template'], ['class' => 'btn btn-success']) ?>
        <input type="file" id="import" name="import" style="display: none" >
    </p>

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
                'template' =>'{view} {update} {delete}',
                'buttons' => [

                    'view' => function ($url, $model, $key) {
                        $options = [
                            'title' => '查看',
                            'aria-label' => '查看',
                            'data-toggle' => 'modal',
                            'data-target' => '#forward-modal',
                            'data-id' => $key,
                            'class' => 'forward-view',
                        ];
                        return Html::a('<span  class="glyphicon glyphicon-eye-open"></span>', '#', $options);
                    },
                    'update' => function ($url, $model, $key) {
                        $options = [
                            'title' => '更新',
                            'aria-label' => '更新',
                            'data-toggle' => 'modal',
                            'data-target' => '#forward-modal',
                            'data-id' => $key,
                            'class' => 'forward-update',
                        ];
                        return Html::a('<span  class="glyphicon glyphicon-pencil"></span>', '#', $options);
                    }
                ],
            ],

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
            centerFormat('createDate'),
            centerFormat('updateDate'),
            centerFormat('salePrice'),
            centerFormat('hopeWeight'),
            centerFormat('hopeRate'),
            centerFormat('hopeSale'),
            centerFormat('hopeMonthProfit'),


        ],
    ]); ?>
</div>

<!--<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>-->

<script src="https://cdn.bootcss.com/jquery/3.2.0/jquery.min.js"></script>

<script>
    $(function () {
        $('.glyphicon-eye-open').addClass('icon-cell');
        $('.wrapper').addClass('body-color');
        });
</script>