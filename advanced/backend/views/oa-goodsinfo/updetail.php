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
$this->title = '编辑: ' . $info->GoodsCode;
$this->params['breadcrumbs'][] = ['label' => '更新产品', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $info->GoodsCode, 'url' => ['view', 'id' => $info->pid]];
$this->params['breadcrumbs'][] = '更新数据';
?>
<?php
    $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
    echo Html::label("<legend class='text-info'><small>基本信息</small></legend>");
    echo FormGrid::widget([ // continuation fields to row above without labels
    'model'=> $info,
    'form'=>$form,
    'rows' =>[
        [
            //'contentBefore'=>'<legend class="text-info"><small>基本信息</small></legend>',
            'attributes' =>[
                'GoodsCode' =>[
                    'label'=>'商品编码',
                    'items'=>[ 1=>'Group 2'],
                    'type'=>Form::INPUT_TEXT,
                    'readonly'=>true,
                   'options'=> ['class'=>'GoodsCode'],
                ],
                'GoodsName' =>[
                    'label'=>'商品名称',
                    'items'=>[ 1=>'Group 2'],
                    'type'=>Form::INPUT_TEXT,
                    'options'=> ['class'=>'GoodsName'],
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
                'SupplierName' =>[
                    'label'=>'供应商名称',
                    'type'=>Form::INPUT_TEXT,
                ],
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
    echo Html::submitButton($info->isNewRecord ? '创建' : '更新', ['class' => $info->isNewRecord ? 'btn btn-success' : 'btn btn-info']);
ActiveForm::end();
echo "<br>";
?>




<?php $skuForm = ActiveForm::begin(['id'=>'sku-info','method'=>'post',]);
?>

<?php
echo Html::label("<legend class='text-info'><small>SKU信息</small></legend>");
?>


<?php

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

        'sku'=>['label'=>'SKU', 'type'=>TabularForm::INPUT_TEXT,
                'options'=>['class'=>'sku'],
               ],
        'property1'=>['label'=>'款式1','type'=>TabularForm::INPUT_TEXT,
            'options'=>['class'=>'property1'],
        ],
        'property2'=>['label'=>'款式2', 'type'=>TabularForm::INPUT_TEXT,
        'options'=>['class'=>'property2']
        ],
        'property3'=>['label'=>'款式3', 'type'=>TabularForm::INPUT_TEXT,
            'options'=>['class'=>'property3']
        ],
        'CostPrice'=>['label'=>'成本价', 'type'=>TabularForm::INPUT_TEXT,
            'options'=>['class'=>'CostPrice'],
        ],
        'Weight'=>['label'=>'重量', 'type'=>TabularForm::INPUT_TEXT,
        'options'=>['class'=>'Weight']],
        'RetailPrice'=>['label'=>'零售价', 'type'=>TabularForm::INPUT_TEXT,
            'options'=>['class'=>'RetailPrice'],
        ],

    ],

    // configure other gridview settings
    'gridSettings'=>[
        'panel'=>[
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> 管理SKU</h3>',
            'type'=>GridView::TYPE_PRIMARY,

            'footer'=>false,
            'after'=>
                '批量加'.
                Html::input('text','rowNum','',['class' => 'x-row','placeholder'=>'Rows']).' '.
                Html::button('新增行', ['id'=>'add-row','type'=>'button', 'class'=>'btn btn-success kv-batch-create']) . ' ' .

                Html::button('删除行', ['id'=>'delete-row','type'=>'button', 'class'=>'btn btn-danger kv-batch-delete']) . ' ' .

                Html::button('一键生成SKU', ['id'=>'sku-set','type'=>'button','class'=>'btn']).' '.
                '成本批量'.
                Html::input('text','CostPrice','',['class' => 'CostPrice-replace','placeholder'=>'CostPrice']).' '.
                Html::button('成本确定', ['id'=>'CostPrice-set','type'=>'button','class'=>'btn']).' '.
                '重量'.
                Html::input('text','Weight','',['class' => 'Weight-replace','placeholder'=>'Weight']).' '.
                Html::button('重量确定', ['id'=>'Weight-set','type'=>'button','class'=>'btn']).' '.
                '价格'.
                Html::input('text','RetailPrice','',['class' => 'RetailPrice-replace','placeholder'=>'RetailPrice']).' '.
                Html::button('价格确定', ['id'=>'RetailPrice-set','type'=>'button','class'=>'btn']).' '.
                Html::button('保存当前数据', ['id'=>'save-only','type'=>'button','class'=>'btn btn-info']).' '.
                Html::button('保存并完善', ['id'=>'save-complete','type'=>'button','class'=>'btn btn-primary']).' '.
                Html::button('导入普源', ['id'=>'data-input','type'=>'button','class'=>'btn btn-warning']).' '
        ]
    ]

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
        //加一行方法
        function  addOneRow(){             
            var skuTable = $('#sku-table').find('table'); 
            var firstTr = skuTable.find('tbody>tr:first'); 
            var row = $('<tr class="kv-tabform-row" ></tr>'); 
            var seriralTd = $('<td class="kv-align-center kv-align-middle" style="width:50px;" data-col-seq="0">New-'+ row_count+'</td>'); 
            row.append(seriralTd);
            var checkBoxTd =$('<td class="skip-export kv-align-center kv-align-middle kv-row-select" style="width:50px;" data-col-seq="2">' +
                                '<input type="checkbox" class="kv-row-checkbox" name="selection[]" >' +
                              '</td>');
            row.append(checkBoxTd);
            var actionTd = $('<td class="skip-export kv-align-center kv-align-middle" style="width:80px;" data-col-seq="1">' +
             '<a class="data-view" href="goodssku/delete" title="查看" aria-label="查看" data-toggle="modal" data-target="#view-modal" ><span  class="glyphicon glyphicon-eye-open"></span></a><a> <span  class="glyphicon glyphicon-trash"></span></a></td>');
            row.append(actionTd);
            
            // var skuTd = $('<td class="kv-align-top" data-col-seq="3" ><div class="form-group"><input type="text" name="Goodssku[][]" class="form-control"><div class="help-block"></div></div></td>');
            // row.append(skuTd);
            
            //循环添加循环框
            var inputNames= ['sku','property1','property2',
            'property3','CostPrice','Weight','RetailPrice']
            for (var i=3; i<inputNames.length + 3;i++){
                var td = $('<td class="kv-align-top" data-col-seq="'+ i +'" >' +
                             '<div class="form-group">' +
                                '<input type="text"  name="Goodssku[New-'+ row_count +']['+ inputNames[i-3] +']" class="form-control  '+ inputNames[i-3] +'">' +
                                 
                             '</div>' +
                           '</td>');
                row.append(td);
            }
            
            //添加行内容到行元素
            skuTable.append(row); 
            row_count++; 
        }        
        var rowNum = $('.x-row').val();        
        if (rowNum !== null || rowNum !== undefined ) { 
            if( rowNum == ''){
                  addOneRow();   
            }           
           for(var r=0;r<rowNum;r++){               
              addOneRow();               
           }
        }
    });
    
    
    //SKU自动生成 = 商品编码+颜色+尺寸
    $('#sku-set').on('click',function(){
        var properties = [];
        var properties2 = [];
        var properties3 = [];
        var GoodsCode = $('.GoodsCode').val();  
        $('.property1').each(function(index,ele) {
            var property =$(this).val(); 
            if($.inArray(property,properties)<0){
                properties.push(property);  
            }
        });
        
        $('.property2').each(function(index,ele) {
            var property =$(this).val();
            properties2.push(property);  
            
        });
        
        $('.property3').each(function(index,ele) {
            var property =$(this).val();
            properties3.push(property);
        });
        $('.sku').each(function(index,ele) {
            var that = this;
            // console.log($(that).closest("input").val());
            $('.property1').each(function(key,element) {
                if (key == index) {
                    var property = $(this).val();
                    var property_index = $.inArray(property,properties);
                    var property2 = properties2[key];
                    var property3 = properties3[key];
                    if(property2.replace(/(^s*)|(s*$)/g, "").length ==0){
                        property2 = ''
                    }
                    else {
                        property2 = '_' + property2; 
                    }
                    
                    if(property3.replace(/(^s*)|(s*$)/g, "").length ==0){
                        property3 = ''
                    }
                    else {
                        property3 = '_' + property3; 
                    }
                    
                    if(property_index>=0){
                        if(property_index + 1 <10) {
                            $(that).val(GoodsCode + '0' + 
                                        (property_index + 1) +
                                        property2 +  
                                        property3 
                                         );
                        }
                        else {
                            $(that).val(GoodsCode + 
                                       (property_index + 1) +
                                        property2 +  
                                        property3 
                                         );
                        }
                    }
                }
                
            })
            
        })    
           
           
           
    }); 
    
    //写入颜色 大小
    
    
    
    //批量设置成本价格 
    $('#CostPrice-set').on('click',function(){
       var newCost = $('.CostPrice-replace').val();
        $('.CostPrice').each(function(){
            $(this).val(newCost);
        });
        
    });
    //  重量
    $('#Weight-set').on('click',function(){
        var newWeight =$('.Weight-replace').val();
            $('.Weight').each(function(){
           $(this).val(newWeight);
       });
    });
    //零售价
    $('#RetailPrice-set').on('click',function(){
       var newRetailprice = $('.RetailPrice-replace').val(); 
       $('.RetailPrice').each(function(){
           $(this).val(newRetailprice);
           
       });
    });
    
    
    
    //批量编辑
    $('.data-edit').on('click', function() {        
       $.get('{$requestUrl2}', { id:$(this).closest('tr').data('key')},
        function (data) {
         $('#edit-sku').find('.modal-body').html(data);
        });
    });
    
    
// 保存数据的提交按钮
    $('#save-only').on('click',function() {
        var form = $('#sku-info');
        form.attr('action', '/goodssku/save-only?pid={$pid}&type=goods-info');
        form.submit();
    }); 
 
// 保存并完善的提交按钮
    $('#save-complete').on('click',function() {
        var form = $('#sku-info');
        form.attr('action', '/goodssku/save-complete?pid={$pid}&type=goods-info');
        form.submit();
    }); 

    $('#create').on('click', function () {
        $.get('{$requestUrl}', {},
            function (data) {
                $('#create-modal').find('.modal-body').html(data);
    
            }  
        );
    });   

   
// 导入普源事件
    $('#data-input').on('click', function() {
      alert('导入普源'); 
    })


JS;
$this->registerJs($js2);
Modal::end();
?>
