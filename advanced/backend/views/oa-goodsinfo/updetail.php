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
$this->title = '更新产品: ' . $info->GoodsName;
$this->params['breadcrumbs'][] = ['label' => '更新产品', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $info->GoodsName, 'url' => ['view', 'id' => $info->pid]];
$this->params['breadcrumbs'][] = '更新数据';
?>
<?php $form = ActiveForm::begin();?>
<?php
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
echo FormGrid::widget([ // continuation fields to row above without labels
    'model'=> $info,
    'form'=>$form,
    'rows' =>[
        [
            'contentBefore'=>'<legend class="text-info"><small>基本信息</small></legend>',
            'attributes' =>[
                'GoodsName' =>[
                    'label'=>'商品名称',
                    'items'=>[ 1=>'Group 2'],
                    'type'=>Form::INPUT_TEXT,
                ],
                'SupplierName' =>[
                    'label'=>'供应商名称',
                    'type'=>Form::INPUT_TEXT,
                ],
            ],
        ],


        [
            'attributes' =>[
                'AliasCnName' =>[
                    'label'=>'中文申报名',
                    'items'=>[ 1=>'Group 2'],
                    'type'=>Form::INPUT_TEXT,
                ],
                'AliasEnName' =>[
                    'label'=>'英文申报名',
                    'items'=>[ 1=>'Group 2'],
                    'type'=>Form::INPUT_TEXT,
                ],
            ],
        ],
        [
            'attributes' =>[
                'PackName' =>[
                    'label'=>'规格',
                    'items'=>[''=>NUll,'A01'=>'A01','A02'=>'A02','A03'=>'A03','A04'=>'A04','B01'=>'B01','B02'=>'B02','stamp'=>'stamp',],
                    'type'=>Form::INPUT_DROPDOWN_LIST,

                ],
            ],
        ],[
            'attributes' =>[
                'description' =>[
                    'label'=>'描述',
                    'items'=>[ 1=>'Group 2'],
                    'type'=>Form::INPUT_TEXTAREA,
                    'options'=>['rows'=>'6']
                ],
            ],
        ],
        [
            'attributes'=>[
                'IsLiquid'=>['label'=>'是否液体','items'=>[ 1=>'Group 2'],'type'=>Form::INPUT_CHECKBOX],
                'IsPowder'=>['label'=>'是否粉末','items'=>[ 1=>'Group 2'],'type'=>Form::INPUT_CHECKBOX],
                'isMagnetism'=>['label'=>'是否带磁', 'items'=>[ 1=>'Group 2'], 'type'=>Form::INPUT_CHECKBOX],
                'IsCharged'=>['label'=>'是否带电', 'items'=>[0=>'Group 1'], 'type'=>Form::INPUT_CHECKBOX],
            ],
        ],

        [
            'attributes' =>[
                'StoreName' =>[
                    'label'=>'仓库',
                    'items'=>$result,
                    'type'=>Form::INPUT_DROPDOWN_LIST,
                ],
                'Season' =>[
                    'label'=>'季节',
                    'items'=>[ ''=>'','春季'=>'春季','夏季'=>'夏季','秋季'=>'秋季','冬季'=>'冬季'],
                    'type'=>Form::INPUT_DROPDOWN_LIST,
                ],



            ],
        ],



    ],

]);?>
<?php
//Tagging support Multiple (maintain the order of selection)
echo '<label class="control-label">禁售平台</label>';


echo Select2::widget([
    'name' => 'DictionaryName',
    //'value' => ['red', 'green'], // initial value
    'data' => $lock,
    'maintainOrder' => true,
    'options' => ['placeholder' => '--可多选--', 'multiple' => true],
    'pluginOptions' => [
        'tags' => true,
        'maximumInputLength' => 5
    ],
]);

?>
<?php
echo Html::submitButton($info->isNewRecord ? '创建基本信息' : '更新基本信息', ['class' => $info->isNewRecord ? 'btn btn-success' : 'btn btn-info']);
ActiveForm::end();
echo "<br>";
?>

<?php
echo Html::label("<legend><small>SKU信息</small></legend>");
?>

<?php $skuForm = ActiveForm::begin(['id'=>'sku-info','method'=>'post',]);

?>

<?php
echo "<br>";

echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'id' => 'sku-table',
    'form'=>$skuForm,
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
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> 管理SKU</h3>',
            'type'=>GridView::TYPE_PRIMARY,
            'before'=>false,
            'footer'=>true,
            'after'=>Html::button('新增行', ['id'=>'add-row','type'=>'button', 'class'=>'btn btn-success kv-batch-create']) . ' ' .
                Html::button('删除行', ['id'=>'delete-row','type'=>'button', 'class'=>'btn btn-danger kv-batch-delete']) . ' ' .
//                        Html::button('保存当前数据', ['type'=>'button', 'class'=>'btn btn-primary kv-batch-save']).
                Html::button('保存当前数据', ['id'=>'save-only','type'=>'button','class'=>'btn btn-info']).
//                        Html::button('保存并完善', ['type'=>'button', 'class'=>'btn btn-info kv-batch-save'])
                Html::button('保存并完善', ['id'=>'save-complete','type'=>'button','class'=>'btn btn-primary'])
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
ActiveForm::end();
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
        var row = $('<tr class="kv-tabform-row" ></tr>'); 
        var seriralTd = $('<td class="kv-align-center kv-align-middle" style="width:50px;" data-col-seq="0">New-'+ row_count+'</td>'); 
        row.append(seriralTd);
        var actionTd = $('<td class="skip-export kv-align-center kv-align-middle" style="width:80px;" data-col-seq="1"><a class="data-view" href="goodssku/delete" title="查看" aria-label="查看" data-toggle="modal" data-target="#view-modal" ><span  class="glyphicon glyphicon-eye-open"></span></a><a> <span  class="glyphicon glyphicon-trash"></span></a></td>');
        row.append(actionTd);
        var checkBoxTd =$('<td class="skip-export kv-align-center kv-align-middle kv-row-select" style="width:50px;" data-col-seq="2"><input type="checkbox" class="kv-row-checkbox" name="selection[]" ></td>');
        row.append(checkBoxTd);
        // var skuTd = $('<td class="kv-align-top" data-col-seq="3" ><div class="form-group"><input type="text" name="Goodssku[][]" class="form-control"><div class="help-block"></div></div></td>');
        // row.append(skuTd);
        
        //循环添加循环框
        var inputNames= ['sku','property1','property2',
        'property3','CostPrice','Weight','RetailPrice']
        for (var i=3; i<inputNames.length + 3;i++){
            var td = $('<td class="kv-align-top" data-col-seq="'+ i +'" ><div class="form-group"><input type="text"  name="Goodssku[New-'+ row_count +']['+ inputNames[i-3] +']" class="form-control"><div class="help-block"></div></div></td>');
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
// 保存数据的提交按钮
    $('#save-only').on('click',function() {
        var form = $('#sku-info');
        form.attr('action', '/goodssku/save-only?pid={$pid}');
        form.submit();
    }); 
 
// 保存并完善的提交按钮
    $('#save-complete').on('click',function() {
        var form = $('#sku-info');
        form.attr('action', '/goodssku/save-complete');
        form.submit();
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
