<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-11-07
 * Time: 11:09
 */
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use yii\bootstrap\Tabs;
use kartik\grid\GridView;
use kartik\builder\TabularForm;
use yii\bootstrap\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\Channel */
$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Channel',
    ]) . $info->pid;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Channels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $info->pid, 'url' => ['view', 'id' => $info->pid]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="channel-update">

    <?php
        $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL, 'formConfig'=>['labelSpan'=>4]]);

        $items[] = [
        'label' => '产品平台',
        'active' => false,
    ];
        $items[] = [
            'label' => 'eBay',
            'active' => false,
        ];
        $items[] = [
            'label' => 'Wish',
            'active' => true,
        ];


        echo Tabs::widget([
            'items' => $items,
        ]);
    echo '</br>';



    ?>

    <?php $skuForm = ActiveForm::begin(['id'=>'sku-info','method'=>'post',]);

    ?>

    </br>

    <?php $form = ActiveForm::begin([
        'id' => 'msg-form',
        'options' => ['class'=>'form-horizontal'],
        'enableAjaxValidation'=>false,
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ]
    ]); ?>
    <div class="blockTitle">
        <p >基本信息</p>

    </div>
    </br>
    <?php

    echo $form->field($info,'GoodsCode')->textInput();
    echo '</br>';
    echo "<div><a href= '$info->picUrl'  target='_blank' ><img  src='$info->picUrl' width='120px' height='120px'></a></div></br>";

    ?>

    <div class="blockTitle">
        <p > 站点组</p>
    </div>
    </br>
    <?= $form->field($info,'GoodsCode')->textInput(); ?>

    <div class="blockTitle">
        </br>
        <p > 多属性</p>
    </div>
    </br>
    <?= $form->field($Goodssku,'linkurl')->textInput(); ?>
    <?= $form->field($Goodssku,'sku')->textInput(); ?>

    <?php ActiveForm::end() ?>


    <?php
    echo Html::label("<legend class='text-info'><small>主信息</small></legend>");
    ?>

    <?php
    $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
    echo FormGrid::widget([ // continuation fields to row above without labels
        'model'=> $info,
        'form'=>$form,
        'rows' =>[
            [
                'attributes' =>[
                    'picUrl' =>[
                        'label'=>"商品图片链接",
                        'options'=> ['class'=>'picUrl'],
                    ],

                ],

            ],
            [
                'attributes' =>[
                    'GoodsCode' =>[
                        'label'=>'商品编码',
                        'items'=>[ 1=>'Group 2'],
                        'type'=>Form::INPUT_TEXT,
                        'readonly'=>true,
                        'options'=> ['class'=>'GoodsCode'],
                    ],
                    'GoodsName' =>[
                        'label'=>"<span style = 'color:red'>*商品名称</span>",
                        'items'=>[ 1=>'Group 2'],
                        'type'=>Form::INPUT_TEXT,
                        'options'=> ['class'=>'GoodsName'],
                    ],



                ],
            ],

            [
                'attributes' =>[
                    'description' =>[
                        'label'=>"<span style = 'color:red'>*描述</span>",
                        'items'=>[ 1=>'Group 2'],
                        'type'=>Form::INPUT_TEXTAREA,
                        'options'=>['rows'=>'6']
                    ],
                ],
            ],



        ],

    ]);


    ?>


    <?php
    echo Html::submitButton($info->isNewRecord ? '创建' : '更新', ['class' => $info->isNewRecord ? 'btn btn-success' : 'btn btn-info']);
    ActiveForm::end();
    echo "<br>";?>

    <?php
    echo '</br>';
    echo Html::label("<legend class='text-info'><small>多属性（Varations）设置</small></legend>");
    ?>

    <?php
        echo TabularForm::widget([
            'dataProvider' => $dataProvider,
            'id' => 'sku-table',
            'form'=>$skuForm,
            'actionColumn'=>[
                'class' => '\kartik\grid\ActionColumn',
                'template' =>'{delete}',
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
                            'title' => '删除',
                            'aria-label' => '删除',
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
                'property1'=>['label'=>'颜色','type'=>TabularForm::INPUT_TEXT,
                    'options'=>['class'=>'property1'],
                ],
                'property2'=>['label'=>'尺寸', 'type'=>TabularForm::INPUT_TEXT,
                    'options'=>['class'=>'property2']
                ],
                'property3'=>['label'=>'数量', 'type'=>TabularForm::INPUT_TEXT,
                    'options'=>['class'=>'property3']
                ],
                'CostPrice'=>['label'=>'价格(USD)', 'type'=>TabularForm::INPUT_TEXT,
                    'options'=>['class'=>'CostPrice'],
                ],
                'Weight'=>['label'=>'运费(USD)', 'type'=>TabularForm::INPUT_TEXT,
                    'options'=>['class'=>'Weight']],
                'RetailPrice'=>['label'=>'建议零售价(USD)', 'type'=>TabularForm::INPUT_TEXT,
                    'options'=>['class'=>'RetailPrice'],
                ],
    //            'shippingTime'=>['label'=>'运输时间', 'type'=>TabularForm::INPUT_TEXT,
    //                'options'=>['class'=>'RetailPrice'],

                'linkurl'=>['label'=>'主图', 'type'=>TabularForm::INPUT_TEXT,
                    'options'=>['class'=>'RetailPrice'],
                ],

            ],

            // configure other gridview settings
            'gridSettings'=>[
                'panel'=>[
                    'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> 管理SKU</h3>',
                    'type'=>GridView::TYPE_PRIMARY,
                    'footer'=>true,
                    'after'=>
                        Html::input('text','rowNum','',['class' => 'x-row','placeholder'=>'行数']).' '.
                        Html::button('新增行', ['id'=>'add-row','type'=>'button', 'class'=>'btn kv-batch-create']) . ' ' .
                        Html::input('text','CostPrice','',['class' => 'CostPrice-replace','placeholder'=>'成本价￥']).' '.
                        Html::button('成本确定', ['id'=>'CostPrice-set','type'=>'button','class'=>'btn']).' '.
                        Html::input('text','Weight','',['class' => 'Weight-replace','placeholder'=>'重量g']).' '.
                        Html::button('重量确定', ['id'=>'Weight-set','type'=>'button','class'=>'btn']).' '.
                        Html::input('text','RetailPrice','',['class' => 'RetailPrice-replace','placeholder'=>'零售价$']).' '.
                        Html::button('价格确定', ['id'=>'RetailPrice-set','type'=>'button','class'=>'btn']).' '.
                        Html::button('一键生成SKU', ['id'=>'sku-set','type'=>'button','class'=>'btn btn-success']).' '.
                        Html::button('保存当前数据', ['id'=>'save-only','type'=>'button','class'=>'btn btn-info']).' '.
                        Html::button('保存并完善', ['id'=>'save-complete','type'=>'button','class'=>'btn btn-primary']).' '.
                        Html::button('导入普源', ['id'=>'data-input','type'=>'button','class'=>'btn btn-warning']).' '.
                        Html::button('删除行', ['id'=>'delete-row','type'=>'button', 'class'=>'btn btn-danger kv-batch-delete'])
                ]
            ]

        ]);
        echo Html::button('保存', ['id'=>'save-only','type'=>'button','class'=>'btn btn-info']).'   ';
        echo Html::button('保存并完善', ['id'=>'save-complete','type'=>'button','class'=>'btn btn-primary']).'   ';
        echo Html::button('导出ibay模板', ['id'=>'data-input','type'=>'button','class'=>'btn btn-warning']);
        ActiveForm::end();
    ?>


</div>

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
$inputUrl = Url::toRoute(['input']);



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
            var checkBoxTd =$('<td class="skip-export kv-align-center kv-align-middle kv-row-select" style="width:50px;" data-col-seq="1">' +
                                '<input type="checkbox" class="kv-row-checkbox" name="selection[]" >' +
                              '</td>');
            row.append(checkBoxTd);
            var actionTd = $(
             '<td class="skip-export kv-align-center kv-align-middle" style="width:80px;" data-col-seq="2">' +
              '<a href="javascript:void(0)" onclick="removeTd(this)"' +
               'class="new-delete" title="删除" aria-label="删除" >' +
               '<span class="glyphicon glyphicon-trash"></span></a></td>');
            row.append(actionTd);
            
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

// 保存并完善改为Ajax方式
    



JS;
$this->registerJs($js2);
Modal::end();
?>
<script>
    //新增行的删除事件
    function removeTd(ele) {
        ele.closest('tr').remove();
    };
</script>

<style>
    .align-center {
        clear: both;
        display: block;
        margin:auto;
    }
</style>


<style>
    .blockTitle {
        font-size: 16px;
        background-color: #f7f7f7;
        border-top: 0.5px solid #eee;
        border-bottom: 0.5px solid #eee;
        padding: 2px 12px;
        margin-left: -5px;
    }
</style>
