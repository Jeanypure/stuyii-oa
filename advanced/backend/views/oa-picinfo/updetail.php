<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-18
 * Time: 11:56
 */

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\grid\GridView;
use kartik\widgets\Select2;

use kartik\builder\TabularForm;

use yii\bootstrap\Modal;
use yii\helpers\Url;
$this->title = '完善图片';
$this->params['breadcrumbs'][] = ['label' => '更新产品', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $info->GoodsCode, 'url' => ['view', 'id' => $info->pid]];
$this->params['breadcrumbs'][] = '更新数据';
?>




<?php $skuForm = ActiveForm::begin(['id'=>'sku-info','method'=>'post',]);
?>
<h3><?php echo  Html::encode($this->title) ?></h3>
<?php
echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'id' => 'sku-table',
    'form'=>$skuForm,
    'actionColumn'=>[
        'class' => '\kartik\grid\ActionColumn',
        'template' =>'{view}',
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
                return Html::a('<span  class="glyphicon glyphicon-eye-open"></span>', 'goodssku/delete', $options);
            },
            'delete' => function ($url, $model, $key) {
                $url ='/goodssku/delete?id='.$key;
                $options = [
                    'title' => '作废',
                    'aria-label' => '作废',
                    'data-id' => $key,
                ];
                return Html::a('<span  class="glyphicon glyphicon-trash"></span>',$url, $options);
            },
            'width' => '60px'
        ],
    ],
    'attributes'=>[

        'sku'=>['label'=>'SKU', 'type'=>TabularForm::INPUT_TEXT,
            'options'=>['readonly'=>true]
               ],
        'linkurl'=>['label'=>'图片库地址', 'type'=>TabularForm::INPUT_TEXT,
        ],
        'property1'=>['label'=>'款式1','type'=>TabularForm::INPUT_TEXT, 'readonly'=>true,
            'options'=>['readonly'=>true]
        ],
        'property2'=>['label'=>'款式2', 'type'=>TabularForm::INPUT_TEXT,
            'options'=>['readonly'=>true]
        ],
        'property3'=>['label'=>'款式3', 'type'=>TabularForm::INPUT_TEXT,
            'options'=>['readonly'=>true]
        ],


    ],

    // configure other gridview settings
    'gridSettings'=>[
        'panel'=>[
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> 管理SKU</h3>',
            'type'=>GridView::TYPE_PRIMARY,

            'footer'=>false,
            'after'=>
                Html::button('保存当前数据', ['id'=>'save-only','type'=>'button','class'=>'btn btn-info']).' '.
                Html::button('保存并完善', ['id'=>'save-complete','type'=>'button','class'=>'btn btn-primary']).' '
        ]
    ]

]);

ActiveForm::end();
?>


<?php

$requestUrl = Url::toRoute(['/goodssku/create','id'=>$info->pid]);//弹窗的html内容，下面的js会调用获得该页面的Html内容，直接填充在弹框中
$requestUrl2 = Url::toRoute(['/goodssku/update']);//弹窗的html内容，下面的js会调用获得该页面的Html内容，直接填充在弹框中

$js2 = <<<JS

    
// 保存数据的提交按钮
    $('#save-only').on('click',function() {
        var form = $('#sku-info');
        form.attr('action', '/goodssku/save-only?pid={$pid}&type=pic-info');
        form.submit();
    }); 
 
// 保存并完善的提交按钮
    $('#save-complete').on('click',function() {
        var form = $('#sku-info');
        form.attr('action', '/goodssku/save-complete?pid={$pid}&type=pic-info');
        form.submit();
    }); 
JS;
$this->registerJs($js2);
?>
