<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\builder\TabularForm;
$skuForm = ActiveForm::begin([
    'id'=>'sku-info',
    'method'=>'post',]);

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
                'delete' => function ($url, $model, $key) {
                    $options = [
                        'title' => '删除',
                        'aria-label' => '删除',
                        'data-id' => $key,
                        'class' =>'delete-icon'
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
            'color'=>['label'=>'颜色','type'=>TabularForm::INPUT_TEXT,
                'options'=>['class'=>'color'],
            ],
            'size'=>['label'=>'尺寸', 'type'=>TabularForm::INPUT_TEXT,
                'options'=>['class'=>'size']
            ],
            'inventory'=>['label'=>'数量', 'type'=>TabularForm::INPUT_TEXT,
                'options'=>['class'=>'inventory']
            ],
            'price'=>['label'=>'价格(USD)', 'type'=>TabularForm::INPUT_TEXT,
                'options'=>['class'=>'price'],
            ],
            'shipping'=>['label'=>'运费(USD)', 'type'=>TabularForm::INPUT_TEXT,
                'options'=>['class'=>'shipping']
            ],
            'msrp'=>['label'=>'建议零售价(USD)', 'type'=>TabularForm::INPUT_TEXT,
                'options'=>['class'=>'msrp'],
            ],
            'shipping_time'=>['label'=>'运输时间', 'type'=>TabularForm::INPUT_TEXT,
                'options'=>['class'=>'shipping_time'],
            ],
            'linkurl'=>['label'=>'主图', 'type'=>TabularForm::INPUT_TEXT,
                'options'=>['class'=>'linkurl'],
            ],

            'image'=>
                [
                    'label'=>'图片',
                    'type'=>TabularForm::INPUT_RAW,
                    'options' => ['class' => 'image'],
                    'value'=>function($data){return "<img weight='50' height='50' src='".$data->linkurl."'>";}
                ],


        ],

        // configure other gridview settings
        'gridSettings'=>[
            'panel'=>[
                'type'=>GridView::TYPE_PRIMARY,
                'after'=>
                    Html::input('text','rowNum','',['class' => 'x-row','size'=>'9','placeholder'=>'行数']).' '.
                    Html::button('新增行', ['id'=>'add-row','type'=>'button', 'class'=>'btn kv-batch-create']) . ' ' .
                    Html::input('text','inventory','',['class' => 'inventory-replace','size'=>'9','placeholder'=>'数量']).' '.
                    Html::button('数量确定', ['id'=>'inventory-set','type'=>'button','class'=>'btn']).' '.
                    Html::input('text','price','',['class' => 'price-replace','size'=>'9','placeholder'=>'价格']).' '.
                    Html::button('价格确定', ['id'=>'price-set','type'=>'button','class'=>'btn']).' '.
                    Html::input('text','shipping','',['class' => 'shipping-replace','size'=>'9','placeholder'=>'运费']).' '.
                    Html::button('运费确定', ['id'=>'shipping-set','type'=>'button','class'=>'btn']).' '.
                    Html::input('text','msrp','',['class' => 'msrp-replace','size'=>'9','placeholder'=>'建议零售价']).' '.
                    Html::button('零售价确定', ['id'=>'msrp-set','type'=>'button','class'=>'btn']).' '.
                    Html::input('text','shipping_time','',['class' => 'shipping_time-replace','size'=>'9','placeholder'=>'运输时间']).' '.
                    Html::button('运输时间', ['id'=>'shipping_time-set','type'=>'button','class'=>'btn']).' '.
                    Html::button('删除行', ['id'=>'delete-row','type'=>'button', 'class'=>'btn btn-danger kv-batch-delete']).'  '.
                    Html::button('保存', ['id'=>'save-sku','type'=>'button','class'=>'btn btn-info'])
            ]
        ]

    ]);


    ActiveForm::end();


    ?>

<?php

$js2 = <<<JS


    //sku信息保存
    $('#save-sku').on('click',function(){
    var skudata = $('#sku-info').serialize();
        $.ajax({
        cache:true,
            type:"POST",
            url:'/wishgoodssku/savesku',
            data:skudata,
            success:function(data){
                alert(data);
            }
        });
    });

  //删除图标删除一行  class='delete-icon'
  $('.delete-icon').on('click',function() {
   var id = $(this).parents('tr').attr('data-key');
   $(this).parents('tr').remove();
   $.ajax({
       cache:true,
       url:'/wishgoodssku/delete',
       type:'post',
       data:{id:id},
       async: true, 
       success:function(res){
          return false;
       }
   });
  });
      
//能删除新增空行的删除行
    $('#delete-row').on('click', function() {
        
        $("input[name='selection[]']:checkbox:checked").each(function(){
            // alert($(this).val());
            // 如果是新增行,就直接删除
            if($(this).val()=='on'){
                $(this).closest('tr').remove();
            }
            else{
                var itermid = $(this).val();
                alert(itermid);
                $(this).closest('tr').remove();
                $.ajax({
                    url:'/wishgoodssku/delete',
                    type:'post',
                    data: {id:itermid},
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
            var inputNames= ['sku','color','size',
            'inventory','price','shipping','msrp','shipping_time','linkurl'];
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
    
    
    
    //批量设置成本价格 
    $('#price-set').on('click',function(){
       var newCost = $('.price-replace').val();
        $('.price').each(function(){
            $(this).val(newCost);
        });
        
    });
    // 库存数量 
    $('#inventory-set').on('click',function(){
        var newinvertory =$('.inventory-replace').val();
            $('.inventory').each(function(){
           $(this).val(newinvertory);
       });
    });
    //建议零售价
    $('#msrp-set').on('click',function(){
       var newRetailprice = $('.msrp-replace').val(); 
       $('.msrp').each(function(){
           $(this).val(newRetailprice);
           
       });
    });
    
    //运费
    $('#shipping-set').on('click',function(){
        var shippingfee = $('.shipping-replace').val();    
        $('.shipping').each(function(){
            $(this).val(shippingfee);
        })
    
    });
    
    //运输时间
    $('#shipping_time-set').on('click',function() {
     var shiptime = $('.shipping_time-replace').val();
     $('.shipping_time').each(function(){
         $(this).val(shiptime);
     });
    });
  
    
JS;
$this->registerJs($js2);
?>



<style>
    @media (min-width: 768px) {
        .modal-xl {
            width: 70%;
            /*max-width:1200px;*/
        }
    }

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
