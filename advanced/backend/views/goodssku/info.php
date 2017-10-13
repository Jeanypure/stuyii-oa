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
$this->title = '更新产品: ' . $info->pid;
$this->params['breadcrumbs'][] = ['label' => '更新产品', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $info->pid, 'url' => ['view', 'id' => $info->pid]];
$this->params['breadcrumbs'][] = '更新数据';
?>
<?php $form = ActiveForm::begin();?>



<?php
echo Html::label("<legend><small>SKU信息</small></legend>");
?>
<?php
echo "<br>";

echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'id' => 'sku-table',
    'form'=>$form,
    'actionColumn'=>[
        'class' => '\kartik\grid\ActionColumn',
        'template' =>'{view} {delete}',
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

        'sku'=>['label'=>'sku', 'type'=>TabularForm::INPUT_TEXT],
        'property1'=>['label'=>'property1','type'=>TabularForm::INPUT_TEXT],
        'property2'=>['label'=>'property1', 'type'=>TabularForm::INPUT_TEXT],
        'property3'=>['label'=>'property1', 'type'=>TabularForm::INPUT_TEXT],
        'CostPrice'=>['label'=>'CostPrice', 'type'=>TabularForm::INPUT_TEXT],
        'Weight'=>['label'=>'Weight', 'type'=>TabularForm::INPUT_TEXT],
        'RetailPrice'=>['label'=>'RetailPrice', 'type'=>TabularForm::INPUT_TEXT],
    ],

    // configure other gridview settings
    'gridSettings'=>[
        'panel'=>[
//            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> 管理SKU</h3>',
            'type'=>GridView::TYPE_PRIMARY,
            'before'=>false,
            'footer'=>true,
            'after'=>Html::button('新增行', ['id'=>'add-row','type'=>'button', 'class'=>'btn btn-success kv-batch-create']) . ' ' .
                Html::button('删除行', ['id'=>'delete-row','type'=>'button', 'class'=>'btn btn-danger kv-batch-delete']) . ' ' .
//                        Html::button('保存当前数据', ['type'=>'button', 'class'=>'btn btn-primary kv-batch-save']).
                Html::submitButton('保存当前数据', ['class'=>'btn btn-info']).
//                        Html::button('保存并完善', ['type'=>'button', 'class'=>'btn btn-info kv-batch-save'])
                Html::submitButton('保存并完善', ['class'=>'btn btn-primary'])
        ]
    ]

]);

?>


<?php
echo Html::a('+新增SKU', '#', [
    'id' => 'create',
    'data-toggle' => 'modal',
    'data-target' => '#create-modal',//关联下面Model的id属性
    'class' => 'btn btn-success',
]);
?>



<?php
Modal::begin([
    'id' => 'create-modal',

    'class' => 'add-sku',
    'header' => '<h4 class="modal-title">新增SKU</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
    'size'=>Modal::SIZE_LARGE,
    'options'=>[
        'data-backdrop'=>'static',//点击空白处不关闭弹窗
        'data-keyboard'=>false,
    ],
]);


Modal::end();

?>



<?php
Modal::begin([
    'id' => 'edit-sku',
    'header' => '<h4 class="modal-title">编辑SKU</h4>',

    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
    'size'=>Modal::SIZE_LARGE,
    'options'=>[
        'data-backdrop'=>'static',//点击空白处不关闭弹窗
        'data-keyboard'=>false,
    ],
]);


$requestUrl = Url::toRoute(['/goodssku/create','id'=>$info->pid]);//弹窗的html内容，下面的js会调用获得该页面的Html内容，直接填充在弹框中
$requestUrl2 = Url::toRoute(['/goodssku/update']);//弹窗的html内容，下面的js会调用获得该页面的Html内容，直接填充在弹框中
$js2 = <<<JS


//删除行
//     $('#delete-row').on('click',function(){
//         var ids = $("#sku-table").yiiGridView("getSelectedRows");
//         var key = "data-key='"+ids + "'";
//         $("["+ key + "]").remove();
//         alert(ids);  
//     });
 

//能删除新增空行的删除行
    $('#delete-row').on('click', function() {
        $("input[name='selection[]']:checkbox:checked").each(function(){
            // alert($(this).val());
            // 如果是新增行,就直接删除
            if($(this).val()=='on'){
                $(this).closest('tr').remove();
            }
            else{
                var pid = $(this).val();
                $(this).closest('tr').remove();
                $.ajax({
                    url:'/goodssku/delete',
                    type:'post',
                    data: {id:pid},
                    success:function(res) {
                    
                 
                      
                    }
                });
            }
            
})
    });
//增加行
    var row_count = 0;
    $('#add-row').on('click',function() {
        var skuTable = $('#sku-table').find('table'); 
        var firstTr = skuTable.find('tbody>tr:first'); 
        var row = $("<tr></tr>"); 
        var seriralTd = $('<td class="kv-align-center kv-align-middle" style="width:50px;" data-col-seq="0">New-'+ row_count+'</td>'); 
        row.append(seriralTd);
        var actionTd = $('<td class="skip-export kv-align-center kv-align-middle" style="width:80px;" data-col-seq="1"><a class="data-view" href="goodssku/delete" title="查看" aria-label="查看" data-toggle="modal" data-target="#view-modal" ><span  class="glyphicon glyphicon-eye-open"></span></a><a> <span  class="glyphicon glyphicon-trash"></span></a></td>');
        row.append(actionTd);
        var checkBoxTd =$('<td class="skip-export kv-align-center kv-align-middle kv-row-select" style="width:50px;" data-col-seq="2"><input type="checkbox" class="kv-row-checkbox" name="selection[]" ></td>');
        row.append(checkBoxTd);
        var skuTd = $('<td class="kv-align-top" data-col-seq="3" ><div class="form-group"><input type="text"  class="form-control"><div class="help-block"></div></div></td>');
        row.append(skuTd);
        
        //循环添加循环框
        for (var i=3; i<9;i++){
            var td = $('<td class="kv-align-top" data-col-seq="'+ i +'" ><div class="form-group"><input type="text"  class="form-control"><div class="help-block"></div></div></td>');
            row.append(td);
        }
        
        //添加行内容到行元素
        skuTable.append(row); 
        row_count++; 
    });
 
    $('.data-edit').on('click', function() {
       $.get('{$requestUrl2}', { id:$(this).closest('tr').data('key')},

        function (data) {
         $('#edit-sku').find('.modal-body').html(data);
        });

    }); 

$('#create').on('click', function () {
    $.get('{$requestUrl}', {},
        function (data) {
            $('#create-modal').find('.modal-body').html(data);

        }  
    );
});   
   

JS;
$this->registerJs($js2);
Modal::end();
?>






















