<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-18
 * Time: 11:56
 */

use yii\helpers\Html;
use kartik\form\ActiveForm;
//use yii\bootstrap\ActiveForm;
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

$bannedNames = explode(',', $info->DictionaryName);
$catNid = $goodsItem->catNid;
$subCate = $goodsItem->subCate;
$stock_flag = $info->stockUp?false:true;
if (empty($info->requiredKeywords)) {
    $required_kws = [];
    for ($i = 0; $i <= 5; $i++) {
        array_push($required_kws, '');
    }
} else {
    $required_kws = json_decode($info->requiredKeywords);
}

if (empty($info->randomKeywords)) {
    $random_kws = [];
    for ($i = 0; $i <= 9; $i++) {
        array_push($random_kws, '');
    }
} else {
    $random_kws = json_decode($info->randomKeywords);
}
$JS = <<<JS

//选中默认主类目
$("option[value={$catNid}]").attr("selected",true);
//选中默认子类目

$("option:contains({$subCate})").attr("selected",true);

JS;

$this->registerJs($JS);

echo Html::label("<legend class='text-info'><small>基本信息</small></legend>");

echo '</br>';

echo "<div style='margin-left: 8px'><a href= '$info->picUrl'  target='_blank' ><img  src='$info->picUrl' width='120px' height='120px'></a></div></br>";

?>

<?php
$stock = $info->stockUp?'是':'否';
$form = ActiveForm::begin([]);

echo FormGrid::widget([ // continuation fields to row above without labels
    'model' => $info,
    'form' => $form,
    //'options' => ['style' => 'margin-left: 25px'],
    'rows' => [
        [
            'attributes' => [
                'picUrl' => [
                    'label' => '商品图片链接',
                    'options' => ['class' => 'picUrl', 'style' => 'margin-left: 7px;'],
                ],
                'stockUp' => [
                    'label' => '是否备货',
                    'options' => [
                        'value' => $stock,
                        'readonly' => true,
                        'class' => 'stockUp',
                        'style' => 'margin-right: 7px;'
                    ],

                ],
            ],
        ],
        [
            'attributes' => [
                'GoodsCode' => [
                    'label' => '商品编码',
                    'items' => [1 => 'Group 2'],
                    'type' => Form::INPUT_TEXT,
                    'readonly' => true,
                    'options' => ['class' => 'GoodsCode col-sm-6', 'style' => "margin-left: 7px"],
                ],
                'GoodsName' => [
                    'label' => "<span style = 'color:red'>*商品名称</span>",
                    'items' => [1 => 'Group 2'],
                    'type' => Form::INPUT_TEXT,
                    'options' => ['class' => 'GoodsName'],
                ],
                'AliasCnName' => [
                    'label' => "<span style = 'color:red'>*中文申报名</span>",
                    'items' => [1 => 'Group 2'],
                    'type' => Form::INPUT_TEXT,
                ],
                'AliasEnName' => [
                    'label' => "<span style = 'color:red'>*英文申报名</span>",
                    'items' => [1 => 'Group 2'],
                    'type' => Form::INPUT_TEXT,
                ],
            ],
        ],
        [
            'attributes' => [
                'Purchaser' => [    //Purchaser   developer  possessMan1
                    'label' => Html::label('采购', ['style' => "margin-left: 10px"]),
                    'type' => Form::INPUT_TEXT,
                    'options' => ['style' => "margin-left: 7px"],
                ],
                'developer' => [
                    'label' => '业绩归属人1',
                    'type' => Form::INPUT_TEXT,
                ],
                'possessMan1' => [
                    'label' => '责任归属人1',
                    'type' => Form::INPUT_TEXT,
                ],
                'SupplierName' => [
                    'label' => "<span style = 'color:red'>*供应商名称</span>",
                    'type' => Form::INPUT_TEXT,
                ],
            ],
        ],
        [
            'attributes' => [
                'PackName' => [
                    'label' => '规格',
                    'items' => $packname,
                    'type' => Form::INPUT_DROPDOWN_LIST,
                    'options' => ['style' => "margin-left: 7px"],
                ],
                'AttributeName' => [
                    'label' => '特殊属性必填',
                    'items' => [ ''=>'','液体商品'=>'液体商品','带电商品'=>'带电商品','带磁商品'=>'带磁商品','粉末商品'=>'粉末商品'],
                    'type' => Form::INPUT_DROPDOWN_LIST,
                ],
                'StoreName' => [
                    'label' => "<span style = 'color:red'>*仓库</span>",
                    'items' => $result,
                    'type' => Form::INPUT_DROPDOWN_LIST,
                ],
                'Season' => [
                    'label' => '季节',
                    'items' => [  ''=>'','春季'=>'春季','夏季'=>'夏季','秋季'=>'秋季','冬季'=>'冬季','春秋'=>'春秋','秋冬'=>'秋冬'],
                    'type' => Form::INPUT_DROPDOWN_LIST,
                ],

            ],
        ],
        [
            'attributes' => [
                'description' => [
                    'label' => "<span style = 'color:red'>*描述</span>",
                    'items' => [1 => 'Group 2'],
                    'type' => Form::INPUT_TEXTAREA,
                    'options' => ['rows' => '12', 'style' => "margin-left: 7px"]
                ],
            ],
        ],
    ],

]);

?>

<div class="form-group">
    <div class="col-lg-1">
        <strong>关键词Tags：</strong>
    </div>
    <div class="col-lg-11">
        <?= $form->field($info, 'wishtags')->textInput(['class' => 'tags-input','style'=>"width:780px;margin-left:-2%;",'placeholder' => '--tags关键词不能超过10个,逗号分隔--'])->label(false); ?>
    </div>
</div>

<div class="keywords">
    <div class="form-group">
        <div class="col-sm-12">
            <strong>标题关键词：</strong>
        </div>
    </div>
    <?= $form->field($info,'headKeywords',['labelOptions' => ['style' => 'margin-left:3%']])->textInput(['style'=>"width:200px;margin-left:3%;",'placeholder' => '--一个关键词--']); ?>
    <?= $form->field($info,'requiredKeywords')->textInput(['style'=>"width:200px;display:none;",'placeholder' => ''])->label(false); ?>
    <?= $form->field($info,'randomKeywords')->textInput(['style'=>"width:200px;display:none;",'placeholder' => ''])->label(false); ?>
    <br>
    <div style="margin-left:3%;margin-right: 50%">
        <div><label class="control-label">必选关键词<span style = "color:red">*</span></label><span style="margin-left:1%" class="required-kw"></span></div>
        <div style="font-size:6px">
            <span><label style = "color:red">说明：</label>物品名/材质/特征等。如T-Shirt(物品名)/V-neck(特征)/Cotton(材质)</span>
        </div>
        <table class="table table-bordered table-responsive">
            <tbody>
            <?php
            echo '<tr>
        <th scope="row">必填</th>
        <td><input value="'.$required_kws[0].'" class="required-kw-in" type="text" class=""></td>
        <td><input value="'.$required_kws[1].'" class="required-kw-in" type="text" class=""></td>
        <td><input value="'.$required_kws[2].'" class="required-kw-in" type="text" class=""></td>
    </tr>
    <tr>
        <th scope="row">选填</th>
        <td><input value="'.$required_kws[3].'" class="required-kw-in" type="text" class=""></td>
        <td><input value="'.$required_kws[4].'" class="required-kw-in" type="text" class=""></td>
        <td><input value="'.$required_kws[5].'" class="required-kw-in" type="text" class=""></td>
        <td><button type="button" class = "required-paste btn btn-success" data-toggle="modal" data-target = "#required-modal">批量设置</button></td>
    </tr>'
            ?>
            </tbody>
        </table>
    </div>
    <br>
    <div style="margin-left:3%;margin-right: 25%">
        <label class="control-label">随机关键词<span style = "color:red">*</span></label><span style="margin-left:1%" class="random-kw"></span>

        <div style="font-size:6px">
            <span><label style = "color:red">说明：</label>形容词/品类热词等。如Fashion/Elegant/Hot/DIY/Casual…</span>
        </div>
        <table class="table table-bordered table-responsive">
            <tbody>
            <?php
            echo
                '<tr>
                <th scope="row">必填</th>
                <td><input value="'.$random_kws[0].'" class="random-kw-in" type="text" class=""></td>
                <td><input value="'.$random_kws[1].'" class="random-kw-in" type="text" class=""></td>
                <td><input value="'.$random_kws[2].'" class="random-kw-in" type="text" class=""></td>
                <td><input value="'.$random_kws[3].'" class="random-kw-in" type="text" class=""></td>
                <td><input value="'.$random_kws[4].'" class="random-kw-in" type="text" class=""></td>
            </tr>
            <tr>
                <th scope="row">选填</th>
                <td><input value="'.$random_kws[5].'"   class="random-kw-in" type="text" class=""></td>
                <td><input value="'.$random_kws[6].'" class="random-kw-in" type="text" class=""></td>
                <td><input value="'.$random_kws[7].'" class="random-kw-in" type="text" class=""></td>
                <td><input value="'.$random_kws[8].'"  class="random-kw-in" type="text" class=""></td>
                <td><input value="'.$random_kws[9].'" class="random-kw-in" type="text" class=""></td>
                <td><button type="button" class = "random-paste btn btn-success" data-toggle="modal" data-target = "#random-modal">批量设置</button></td>
            </tr>'
            ?>
            </tbody>
        </table>

    </div>
    <?= $form->field($info,'tailKeywords',['labelOptions' => ['style' => 'margin-left:3%']])->textInput(['style'=>"width:200px;margin-left:3%;",'placeholder' => '--最多一个关键词--'])->label('最后关键词<span style = "color:red">*</span>'); ?>

</div>


<div class="row" style="margin-left: 8px">
    <div class="row">
        <div class="col-sm-4">
            <?php echo '<label class="control-label">禁售平台</label>';
            echo Select2::widget([
                'name' => 'DictionaryName',
                'id' => 'dictionary-name',
                'value' => $bannedNames,
                'data' => $lock,
                'maintainOrder' => true,
                'options' => ['placeholder' => '--可多选--', 'multiple' => true],
                'pluginOptions' => [
                    'tags' => true,
                    'maximumInputLength' => 5
                ],
            ]); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($goodsItem, 'cate')->dropDownList($goodsItem->getCatList(0),
                ['prompt' => '--请选择父类--', 'onchange' => '           
            $("select#oagoods-subcate").children("option").remove();
            $.get("' . Url::to(['oa-goodsinfo/category', 'typeid' => 1]) .
                    '&pid="+$(this).val(),function(data){
                var str=""; 
              $.each(data,function(k,v){
                    str+="<option value="+v+">"+v+"</option>";
                    });
                $("select#oagoods-subcate").html(str);
            });',
                ]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($goodsItem, 'subCate')->dropDownList($goodsItem->getCatList($goodsItem->catNid), ['prompt' => '--特殊属性--',]) ?>
        </div>
    </div>

    <?php
    echo FormGrid::widget([
        'model' => $goodsItem,
        'form' => $form,
        'rows' => [
            [
                'attributes' => [
                    'vendor1' => [
                        'label' => '供应商链接1',
                    ],
                    'vendor2' => [
                        'label' => '供应商链接2',
                        'type' => Form::INPUT_TEXT,
                    ],
                    'vendor3' => [
                        'label' => '供应商链接3',
                        'type' => Form::INPUT_TEXT,
                    ],
                ],
            ],
            [
                'attributes' => [
                    'origin1' => [
                        'label' => '平台链接1',
                        'type' => Form::INPUT_TEXT,
                        'inputTemplate' => '<a>{input}</a>',
                    ],
                    'origin2' => [
                        'label' => '平台链接2',
                        'type' => Form::INPUT_TEXT,
                    ],
                    'origin3' => [
                        'label' => '平台链接3',
                        'type' => Form::INPUT_TEXT,
                    ],
                ],
            ],
        ]
    ]);

    ?>

    <?php
    echo Html::submitButton( '保存基本信息', ['class' =>  'btn btn-danger','style' => 'margin-left:8%']);
    ActiveForm::end();
    echo "<br>";
    ?>

    <?php
    echo Html::label("<legend class='text-info'><small>SKU信息</small></legend>");
    ?>

    <?php $skuForm = ActiveForm::begin(['id' => 'sku-info', 'method' => 'post',]);
    ?>

    <?php

    echo TabularForm::widget([
        'dataProvider' => $dataProvider,
        'id' => 'sku-table',
        'form' => $skuForm,
        'actionColumn' => [
            'class' => '\kartik\grid\ActionColumn',
            'template' => '{delete}',
            'buttons' => [
                'delete' => function ($url, $model, $key) {
                    $delete_url = Url::to(['/goodssku/delete','id' => $key]);
                    $options = [
                        'title' => '删除',
                        'aria-label' => '删除',
                        'data-id' => $key,
                    ];
                    return Html::a('<span  class="glyphicon glyphicon-trash"></span>', $delete_url, $options);
                },
                'width' => '60px'
            ],
        ],
        'attributes' => [

            'sku' => ['label' => 'SKU', 'type' => TabularForm::INPUT_TEXT,
                'options' => ['class' => 'sku'],
            ],
            'property1' => ['label' => '款式1', 'type' => TabularForm::INPUT_TEXT,
                'options' => ['class' => 'property1'],
            ],
            'property2' => ['label' => '款式2', 'type' => TabularForm::INPUT_TEXT,
                'options' => ['class' => 'property2']
            ],
            'property3' => ['label' => '款式3', 'type' => TabularForm::INPUT_TEXT,
                'options' => ['class' => 'property3']
            ],
            'CostPrice' => ['label' => '成本价', 'type' => TabularForm::INPUT_TEXT,
                'options' => ['class' => 'CostPrice'],
            ],
            'Weight' => ['label' => '重量', 'type' => TabularForm::INPUT_TEXT,
                'options' => ['class' => 'Weight']],
            'RetailPrice' => ['label' => '零售价', 'type' => TabularForm::INPUT_TEXT,
                'options' => ['class' => 'RetailPrice'],
            ],
            'stockNum' => ['label' => '备货数量', 'type' => TabularForm::INPUT_TEXT,
                'options' => ['class' => 'stockNum', 'readonly' => $stock_flag ],
            ],

        ],

        // configure other gridview settings
        'gridSettings' => [
            'panel' => [
                'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> 管理SKU</h3>',
                'type' => GridView::TYPE_PRIMARY,

                'footer' => true,
                'after' =>
                    Html::input('text', 'rowNum', '', ['class' => 'x-row', 'placeholder' => '行数']) . ' ' .
                    Html::button('新增行', ['id' => 'add-row', 'type' => 'button', 'class' => 'btn kv-batch-create']) . ' ' .
                    Html::input('text', 'CostPrice', '', ['class' => 'CostPrice-replace', 'placeholder' => '成本价￥']) . ' ' .
                    Html::button('成本确定', ['id' => 'CostPrice-set', 'type' => 'button', 'class' => 'btn']) . ' ' .
                    Html::input('text', 'Weight', '', ['class' => 'Weight-replace', 'placeholder' => '重量g']) . ' ' .
                    Html::button('重量确定', ['id' => 'Weight-set', 'type' => 'button', 'class' => 'btn']) . ' ' .
                    Html::input('text', 'RetailPrice', '', ['class' => 'RetailPrice-replace', 'placeholder' => '零售价$']) . ' ' .
                    Html::button('价格确定', ['id' => 'RetailPrice-set', 'type' => 'button', 'class' => 'btn']) . ' ' .
                    Html::button('一键生成SKU', ['id' => 'sku-set', 'type' => 'button', 'class' => 'btn btn-success']) . ' ' .
                    Html::button('保存当前数据', ['id' => 'save-only', 'type' => 'button', 'class' => 'btn btn-info',
                        'data-href' => Url::to(['/goodssku/save-only', 'pid' => $pid, 'type'=> 'goods-info'])]) . ' ' .
                    Html::button('保存并完善', ['id' => 'save-complete', 'type' => 'button', 'class' => 'btn btn-primary',
                        'data-href' => Url::to(['/goodssku/save-complete', 'pid' => $pid, 'type'=> 'goods-info'])]) . ' ' .
                    Html::button('导入普源', ['id' => 'data-input', 'type' => 'button', 'class' => 'btn btn-warning']) . ' ' .
                    Html::button('生成采购单', ['id' => 'make-order', 'type' => 'button', 'class' => 'btn' ]) . ' ' .
                    Html::button('删除行', ['id' => 'delete-row', 'type' => 'button', 'class' => 'btn btn-danger kv-batch-delete'])
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
        'size' => Modal::SIZE_LARGE,
        'options' => [
            'data-backdrop' => 'static',//点击空白处不关闭弹窗
            'data-keyboard' => false,
        ],
    ]);
    Modal::end();

    ?>

    <?php
    Modal::begin([
        'id' => 'random-modal',
        'header' => '<h4 class="modal-title">批量增加关键词</h4>',
        'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
        'options' => [
            'data-backdrop' => 'static',//点击空白处不关闭弹窗
            'data-keyboard' => false,
        ],
    ]);
    Modal::end();

    Modal::begin([
        'id' => 'required-modal',
        'header' => '<h4 class="modal-title">批量增加关键词</h4>',
        'footer' => '<a href="#" class="required-close btn btn-primary" data-dismiss="modal">关闭</a>',
        'options' => [
            'data-backdrop' => 'static',//点击空白处不关闭弹窗
            'data-keyboard' => false,
        ],
    ]);
    Modal::end();
    Modal::begin([
        'id' => 'edit-sku',
        'header' => '<h4 class="modal-title">编辑SKU</h4>',
        'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
        'size' => Modal::SIZE_LARGE,
        'options' => [
            'data-backdrop' => 'static',//点击空白处不关闭弹窗
            'data-keyboard' => false,
        ],
    ]);
    Modal::end();
    $requestUrl = Url::toRoute(['/goodssku/create', 'id' => $info->pid]);//弹窗的html内容，下面的js会调用获得该页面的Html内容，直接填充在弹框中
    $requestUrl2 = Url::toRoute(['/goodssku/update']);//弹窗的html内容，下面的js会调用获得该页面的Html内容，直接填充在弹框中
    $inputUrl = Url::toRoute(['input']);
    $deleteUrl = Url::toRoute(['/goodssku/delete']);
    $makeOrdersUrl = Url::toRoute(['/goodssku/make-orders','goodsCode' => $info->GoodsCode]);
    $make_flag = $info->stockUp?$info->stockUp:0;
    $import_flag = $info->bgoodsid?$info->bgoodsid:0;

    $js2 = <<<JS
    
// 生成采购单
    $("#make-order").on('click',function() {
         $(this).attr('disabled','disabled');
         var button = $(this);
        if({$import_flag} > 0){
             if({$make_flag} == 1){
            var total = 0;
            $('.stockNum').each(function(index,ele) {
              var num = $(this).val();
              if(!num){
                num = '0';
              }
              console.log(typeof(parseInt(num)));
              total += parseInt(num);
            });
            if(total>50){
                alert("备货数量超过50，请调整备货数量！")
            }
            else{
            //生成采购单的动作！
            $.ajax(
                {
                type:"POST",
                url:'{$makeOrdersUrl}',
                success: function(data) {
                  alert(data);
                  button.attr('disabled',false);
                }
                }
            );
            }
        }
        else {
            alert('不是备货产品,不能生成采购单！');
    }
        }
        else{
            alert("还未导入普源，不能生成采购单！");
        }
       button.attr('disabled',false);
    });
    
    
//批量设置关键词
    $(".random-paste").on('click',function() {
            if($("#all-kws").length==0){
                $('#random-modal').find('.modal-body').html('<textarea placeholder="--多个随机关键词--" id="all-kws" style="margin-left:7%;border-style:none;width:500px;height:400px;"></textarea>');
            }
            //重新监听事件                                                                                        
            var random_ele = $("#all-random");
            listenOnTextInput(random_ele,'random');
        });
    $(".required-paste").on('click',function() {
        if($("#required-kws").length==0){
           $('#required-modal').find('.modal-body').html('<textarea placeholder="--多个必选关键词--" id="required-kws" style="margin-left:7%;border-style:none;width:500px;height:400px;"></textarea>'); 
        }
        requird_ele = $("#all-required");
        listenOnTextInput(requird_ele,'required');
    });
 
   
//样式处理开始
    $("label[for='oagoodsinfo-headkeywords']").after('<span style="margin-left:1%"class="head-kw"></span><div style="font-size:6px;margin-left:3%">'+
        '<span><label style = "color:red">说明：</label>性别定位/多个一卖等。如Women/Men/Girl/Baby/Kids/1PC/2PC/5PC/4 Colors/5Pcs Set…</span></div>');
    
    $("label[for='oagoodsinfo-tailkeywords']").after('<span style="margin-left:1%"class="tail-kw"></span><div style="font-size:6px;margin-left:3%">'+
        '<span><label style = "color:red">说明：</label>附加说明词。如Randomly/S-3XL/2ml/(Color: Nude)/Big Size…</span></div>');
//样式处理结束

//开始关键词处理过程
 
     headCount();
     requiredCount();
     randomCount();
     tailCount();
     
    //监听最前关键词的变化
  
    $('#oagoodsinfo-headkeywords').on('change',function() {
        headCount();
   });
    
    //监听必选关键词的变化过程
    $('.required-kw-in').on('change',function() {
        requiredCount();
    });
    //监听随机关键词的变化过程
    $('.random-kw-in').on('change',function() {
        randomCount()
    });
    
    //监听最后关键词的变化过程
    $('#oagoodsinfo-tailkeywords').on('change',function() {
        tailCount();
   });
//结束关键词处理过程


//能删除新增空行的删除行
    $('#delete-row').on('click', function() {
        var sid_list = [];
        $("input[name='selection[]']:checkbox:checked").each(function(){
            // alert($(this).val());
            // 如果是新增行,就直接删除
            if($(this).val()=='on'){
                $(this).closest('tr').remove();
            }
            else{
                var sid = $(this).val();
                sid_list.push(sid);
                $(this).closest('tr').remove();
            }           
        });
      
        $.ajax({
                   url:'{$deleteUrl}',
                   type:'post',
                   data: {id:sid_list},
                   success:function(res) {
                       alert(res);
                    }
               });
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
            'property3','CostPrice','Weight','RetailPrice','stockNum']
            for (var i=3; i<inputNames.length + 3;i++){
                if(inputNames[i-3] == 'stockNum'){
                    if ({$make_flag} == 0){
                    var td = $('<td class="kv-align-top" data-col-seq="'+ i +'" >' +
                             '<div class="form-group">' +
                                '<input type="text"  name="Goodssku[New-'+ row_count +']['+ inputNames[i-3] +']" readonly class="form-control  '+ inputNames[i-3] +'">' +
                                 
                             '</div>' +
                           '</td>');
                    }
                    else {
                        var td = $('<td class="kv-align-top" data-col-seq="'+ i +'" >' +
                             '<div class="form-group">' +
                                '<input type="text"  name="Goodssku[New-'+ row_count +']['+ inputNames[i-3] +']" class="form-control  '+ inputNames[i-3] +'">' +
                                 
                             '</div>' +
                           '</td>');
                    }
                    
                }
                else {
                    var td = $('<td class="kv-align-top" data-col-seq="'+ i +'" >' +
                             '<div class="form-group">' +
                                '<input type="text"  name="Goodssku[New-'+ row_count +']['+ inputNames[i-3] +']" class="form-control  '+ inputNames[i-3] +'">' +
                                 
                             '</div>' +
                           '</td>');
                }
                
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
    $('#save-only').on('click',function() {
        /*var form = $('#sku-info');
        form.attr('action', $('#save-only').data('href'));
        form.submit();*/
        $.ajax({
                cache: true,
                type: "POST",
                url: $('#save-only').data('href'),
                data:$('#sku-info').serialize(),
                // async: false, 
                success: function(data) {
                    alert(data);
                    location.reload();
                }
            });
    }); 
 

// 保存并完善改为Ajax方式
    $('#save-complete').on('click', function() {
        $.ajax({
                cache: true,
                type: "POST",
                url: $('#save-complete').data('href'),
                data:$('#sku-info').serialize(),
                // async: false,    
                success: function(data) {
                    alert(data);
                    location.reload();
                }
            });
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
        $.get('{$inputUrl}',{id:'{$pid}'},function(data){
                alert(data);
                });
    });

JS;
    $this->registerJs($js2);

    ?>

    <script>
        //新增行的删除事件
        function removeTd(ele) {
            ele.closest('tr').remove();
        };

        //页面初始化之后开始加载字符个数
        function headCount() {
            kw = $('#oagoodsinfo-headkeywords').val();
            if (!kw) {
                len_kw = 0;
            }
            else {
                len_kw = kw.length;
            }
            $(".head-kw").html('<span style = "color:red">' + String(len_kw) + '</span>个字符');

        }

        function tailCount() {
            kw = $('#oagoodsinfo-tailkeywords').val();
            if (!kw) {
                len_kw = 0;
            }
            else {
                len_kw = kw.length;
            }
            $(".tail-kw").html('<span style = "color:red">' + String(len_kw) + '</span>个字符');

        }


        function randomCount() {
            kw_count = 0;
            kw_length = 0;
            keywords = [];
            $('.random-kw-in').each(function () {
                kw = $(this).val();
                if (!kw) {
                    len_kw = 0;
                    keywords.push('');
                }
                else {
                    len_kw = kw.length;
                    kw_count += 1;
                    keywords.push(kw);
                }
                kw_length = kw_length + len_kw;
            });
            $(".random-kw").html('<span style = "color:red;margin-left:1%">' + String(kw_count) + '</span>个关键词；<span style = "color:red">' + String(kw_length) + '</span>个字符');
            $('#oagoodsinfo-randomkeywords').val(JSON.stringify(keywords));
        }

        function requiredCount() {
            kw_count = 0;
            kw_length = 0;
            keywords = [];
            $('.required-kw-in').each(function () {
                kw = $(this).val();
                if (!kw) {
                    len_kw = 0;
                    keywords.push('');

                }
                else {
                    len_kw = kw.length;
                    kw_count += 1;
                    keywords.push(kw);
                }
                kw_length = kw_length + len_kw;
            });
            $(".required-kw").html('<span style = "color:red;margin-left:1%">' + String(kw_count) + '</span>个关键词；<span style = "color:red">' + String(kw_length) + '</span>个字符');
            $('#oagoodsinfo-requiredkeywords').val(JSON.stringify(keywords));
        }

        function listenOnTextInput(ele, name) {
            $('body').on('change',ele,function () {

                if (name == 'required') {
                    var kws = $("#required-kws").val();
                    //alert(kws);return;
                    var  kw_list = kws.split('\n');
                    $.each(kw_list, function (index, value) {
                        $('.required-kw-in').each(function (pos) {
                            if (index == pos) {
                                $(this).val(value);
                            }
                        })
                    });
                    requiredCount();
                }
                if (name == 'random') {
                    kws = $("#all-kws").val();
                    kw_list = kws.split('\n');
                    $.each(kw_list, function (index, value) {
                        $('.random-kw-in').each(function (pos) {
                            if (index == pos) {
                                $(this).val(value);
                            }
                        })
                    });
                    randomCount();
                }

            });
        }

    </script>

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
            margin: auto;
        }



    </style>