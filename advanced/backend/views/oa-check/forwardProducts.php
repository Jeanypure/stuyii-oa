<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OaGoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '正向产品';
$this->params['breadcrumbs'][] = $this->title;

//单元格居中类
class CenterFormatter {
    public function __construct($name) {
        $this->name = $name;
    }
    public  function format() {
        // 超链接显示为超链接
        if ($this->name === 'origin') {
            return  [
                'attribute' => $this->name,
                'value' => function($data) {
                    return "<a class='cell' href='{$data['origin']}' target='_blank'>=></a>";
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

    <p>
        <?= Html::a('新增产品', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'bootstrap' => true,
        'responsive'=>true,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
             centerFormat('img'),
             centerFormat('cate'),
             centerFormat('devNum'),
             centerFormat('origin'),
             centerFormat('hopeProfit'),
             centerFormat('develpoer'),
             centerFormat('introducer'),
             centerFormat('devStatus'),
             centerFormat('checkStatus'),
             centerFormat('createDate'),
             centerFormat('updateDate'),
            [ 'class' => 'kartik\grid\ActionColumn',
                'template' =>'{view} {update} {delete} {heart}',
                'buttons' => [

                    'heart' => function ($url, $model, $key) {
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
</div>

<!--<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>-->

<script src="https://cdn.bootcss.com/jquery/3.2.0/jquery.min.js"></script>

<script>
    $(function () {
        $('.glyphicon-eye-open').addClass('icon-cell');
        $('.wrapper').addClass('body-color');
        });
</script>