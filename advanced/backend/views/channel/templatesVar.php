<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-11-16
 * Time: 11:32
 */
use kartik\widgets\ActiveForm;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\helpers\Html;
?>

<div class="">
        <?php
        $varForm = ActiveForm::begin(['id'=>'var-form','method'=>'post',]);
        echo TabularForm::widget([
            'dataProvider' => $templatesVar,
            'id' => 'var-table',
            'form' => $varForm,
            'actionColumn' =>
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{delete}',
                    'buttons' =>
                        [
                            'delete' => function($url,$model,$key) {
                                $options = [
                                    'title' => '删除',
                                    'data-id' => $key,
                                ];
                                return Html::a('<span class="delete-icon glyphicon glyphicon-trash"</span>','#',$options);
                            }
                        ]
                ],
            'attributes' =>
                [
                    'sku'=>
                        [
                            'label'=>'SKU', 'type'=>TabularForm::INPUT_TEXT,
                            'options'=>['class'=>'sku'],
                        ],
                    'quantity'=>
                        [
                            'type'=>TabularForm::INPUT_TEXT,
                            'options'=>['class'=>'quantity'],
                        ],
                    'retailPrice'=>
                        [
                            'type'=>TabularForm::INPUT_TEXT,
                            'options'=>['class'=>'retailPrice'],
                        ],
                    'imageUrl' =>
                        [
                            'type' => TabularForm::INPUT_TEXT,
                            'options' => ['class' =>'imageUrl']
                        ],
                    'image'=>
                        [
                            'type'=>TabularForm::INPUT_RAW,
                            'options' => ['class' => 'image'],
                            'value'=>function($data){return "<img weight='50' height='50' src='".$data->imageUrl."'>";}
                        ],

                    'color'=>
                        [
                            'type'=>TabularForm::INPUT_TEXT,
                            'options'=>['class'=>'color'],
                        ],
                    'UPC'=>
                        [
                            'type'=>TabularForm::INPUT_TEXT,
                            'options'=>['class'=>'UPC','value' => 'Does not apply'],

                        ],
                    'EAN'=>
                        [
                            'type'=>TabularForm::INPUT_TEXT,
                            'options'=>['class'=>'EAN','value' => 'Does not apply'],

                        ],
                ],
            'gridSettings'=>[
            'panel'=>[
                'heading'=>'<h3 class="panel-title">多属性设置</h3>',
                'type'=>GridView::TYPE_PRIMARY,
                'after'=>
                    Html::input('text','rowNum','',['class' => 'x-row','placeholder'=>'行数']).' '.
                    Html::button('新增行', ['id'=>'add-row','type'=>'button', 'class'=>'btn kv-batch-create']) . ' ' .
                    Html::input('text','number','',['class' => 'number-replace','placeholder'=>'数量']).' '.
                    Html::button('数量确定', ['id'=>'number','type'=>'button','class'=>'btn']).' '.
                    Html::input('text','RetailPrice','',['class' => 'RetailPrice-replace','placeholder'=>'零售价$']).' '.
                    Html::button('价格确定', ['id'=>'RetailPrice-set','type'=>'button','class'=>'btn']).''.
                    Html::input('text','EAN','',['class' => 'ean-replace','placeholder'=>'Does not apply']).' '.
                    Html::button('EAN确定', ['id'=>'ean-set','type'=>'button','class'=>'btn']).' '.
                    Html::button('保存', ['id'=>'save-only','type'=>'button','class'=>'btn btn-info']).' '.
                    Html::button('删除行', ['id'=>'delete-row','type'=>'button', 'class'=>'btn btn-danger kv-batch-delete'])
            ]
        ]

        ]);

        ActiveForm::end();
        ?>
</div>

<?php
$js = <<< JS
//删除行
$('#delete-row').click(function() {
    $("[name='selection[]']:checkbox:checked").each(function() {
        $(this).closest('tr').remove();  
    })
});

//新增行
var row_count = 0; //全局变量,记录当前新增行数

$('#add-row').click(function() {
   //增加一行
    function addOneRow() {
        var skuTable = $('#var-table').find('table');
        var row =$('<tr class="kv-tabform-row" ></tr>');
        
        var seriralTd = $('<td class="kv-align-center kv-align-middle" style="width:50px;" data-col-seq="0">New-'+ row_count+'</td>'); 
        row.append(seriralTd);
        
        var checkBoxTd =$(
            '<td class="skip-export kv-align-center kv-align-middle kv-row-select" style="width:50px;" data-col-seq="1">' +
            '<input type="checkbox" class="kv-row-checkbox" name="selection[]" >' +
             '</td>');
        row.append(checkBoxTd);
        
        var actionTd = $(
             '<td class="skip-export kv-align-center kv-align-middle" style="width:80px;" data-col-seq="2">' +
              '<a href="javascript:void(0)" onclick="removeTd(this)"' +
               'class="new-delete" title="删除" aria-label="删除" >' +
               '<span class="glyphicon glyphicon-trash"></span></a></td>');
        row.append(actionTd);
        
        
        //添加主字段
        var inputFields = ['sku','quantity','reailPrice','imageUrl','image','color','UPC','EAN'];
        for(var i=3; i< inputFields.length + 3; i++){
            if(i==6){
                var fun = " var new_image = $(this).val();;$(this).parents('tr').find('img').attr('src',new_image); ";
                var td = $('<td class="kv-align-top" data-col-seq="'+ i +'" >' +
                             '<div class="form-group">' +
                                '<input type="text"  name="Goodssku[New-'+ row_count +']['+ inputFields[i-3] +']" class="form-control  '+ inputFields[i-3] +
                                // '">' +
                                '" onchange=' + '"'+ fun+'">' +
                             '</div>' +
                           '</td>');
            }
            else if(i ==7){
                var td = $('<td class="kv-align-top" data-col-seq="'+ i +'" >' +
                             '<div class="form-group">' +
                                "<img weight='50' height='50' src=''>" +
                                 
                             '</div>' +
                           '</td>');
            }
            else {
                var td = $('<td class="kv-align-top" data-col-seq="'+ i +'" >' +
                             '<div class="form-group">' +
                                '<input type="text"  name="Goodssku[New-'+ row_count +']['+ inputFields[i-3] +']" class="form-control  '+ inputFields[i-3] +'">' +
                                 
                             '</div>' +
                           '</td>');
            }
                row.append(td);
        }
        
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


//批量设置零售价
    $('#RetailPrice-set').on('click',function(){
       var newRetailprice = $('.RetailPrice-replace').val(); 
       $('.retailPrice').each(function(){
           $(this).val(newRetailprice);
           });
       });

// 批量设置数量
    $("#number").on('click',function() {
        var newQuantity = $('.number-replace').val();
        $('.quantity').each(function() {
            $(this).val(newQuantity);
        })
    });


//批量设置EAN
    $('#ean-set').on('click',function() {
        var newEAN = $('.ean-replace').val();
        $('.EAN').each(function() {
            $(this).val(newEAN);
        });
    });

    //监听图片变化事件
    
    $('.imageUrl').change(function() {
        alert('It works!');
        var new_image = $(this).val();
        
        $(this).parents('tr').find('img').attr('src',new_image); 
    })

//每行的删除操作改为ajax方式
    $('.delete-icon').on('click',function() {
        id = $(this).parents('tr').attr('data-key');
        $(this).parents('tr').remove();//前端删除
        $.ajax({
            url:'',
            type:'post',
            data:{id:pid},
            success: function(res) {
            }
        });
    });
JS;




$this->registerJs($js);
?>
<style>
    .panel-primary > .panel-heading {
        color: black;
        background-color: whitesmoke;
        border-color: transparent;
    }
    .panel-primary {
        border-color: transparent;
    }

    .panel-footer {
        padding: 10px 15px;
        background-color: white;
        border-top: 1px solid #ddd;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
    }
</style>