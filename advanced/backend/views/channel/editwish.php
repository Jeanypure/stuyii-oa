<?php
/**
 * Created by PhpStorm.
 * User: ljj
 * Date: 2017-11-07
 * Time: 11:09
 */

use kartik\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Channel */
$this->title = '编辑模板';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Channels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $sku->infoid, 'url' => ['view', 'id' => $sku->infoid]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

//$bannedNames = explode(',', $info->DictionaryName);
//$catNid = $goodsItem->catNid;
//$subCate = $goodsItem->subCate;
if (empty($sku->requiredKeywords)) {
    $required_kws = [];
    for ($i = 0; $i <= 5; $i++) {
        array_push($required_kws, '');
    }
} else {
    $required_kws = json_decode($sku->requiredKeywords);
}

if (empty($sku->randomKeywords)) {
    $random_kws = [];
    for ($i = 0; $i <= 9; $i++) {
        array_push($random_kws, '');
    }
} else {
    $random_kws = json_decode($sku->randomKeywords);
}
?>
<div class="channel-update-form">

    <?php
    $form = ActiveForm::begin([

        'action' => ['/channel/update'],
        'method' => 'post',
        'id' => 'all-info',
        'options' => ['class' => 'form-horizontal'],
        'enableAjaxValidation' => false,
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-9\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],

        ]
    ]);

    echo Tabs::widget([

        'items' => [
            [
                'label' => 'Wish',
                'url' => Url::to(['update', 'id' => $sku->infoid]),

                'headerOptions' => ["id" => 'tab1'],
                'options' => ['id' => 'article'],
                'active' => true,
            ],
            [
                'label' => 'eBay',
                'url' => Url::to(['update-ebay', 'id' => $sku->infoid]),
                'headerOptions' => ["id" => 'tab1'],
                'options' => ['id' => 'topic'],
            ],


        ],
    ]);

    ?>
    <div class="form-group blockTitle">

        <botton class="btn btn-info update-info">
            更新
        </botton>
        <botton class="btn btn-primary wish-sign">
            保存并完善
        </botton>
        <botton class="btn btn-success export">
            导出ibay模版
        </botton>
        <botton class="btn btn-warning joom-csv">
            导出joom(csv)
        </botton>
    </div>
    <div class="blockTitle">
        <span>基本信息</span>
    </div>
    <?= $form->field($sku, 'SKU')->textInput(); ?>
    <?php
    echo $form->field($sku, 'main_image')->hiddenInput(['class' => 'main-image']);
    //echo $form->field($sku,'main_image')->textInput(['class'=>'main-image','style'=>'display:none']);
    echo '<div class="form-group field-oatemplates-mainpage">
         
         <label class="col-lg-1 control-label"></label>
            <div class="col-lg-3"><input name="main_image" type="text" class="form-control tem-page" value="' . $sku->main_image . '">
            </div>
            <div class="col-lg=1"> 
                <a target="_blank" href="' . $sku->main_image . '">
                <img src="' . $sku->main_image . '" width="80" height="80">
                </a>
            </div>
        </div>';

    ?>

    <div class="form-group all-images">
        <label class="col-lg-1 control-label">附加图</label>
    </div>

    <?php
    $form->field($sku, 'extra_images')->hiddenInput();

    echo '<div class="images">';
        foreach ($extra_images as $key=>$value){
        echo '
        <div class="form-group all-images">
            <label class="col-lg-1"></label>
            <strong class="serial">#'.($key+1).'</strong>
            <div class="col-lg-3">
                <input name="extra_images[]" type="text" class="form-control extra-images" value="'.$value.'">
            </div>
            <div class="col-lg=1">
                <button class="btn add-images">增加</button>
                <button class="btn btn-error remove-image">删除</button>
                <button class="btn up-btn btn-error">上移动</button>
                <button class="btn down-btn btn-error">下移动</button>
                <a target="_blank" href="'.$value.'">
                    <img src="'.$value.'" width="50" height="50"/>
                </a>
            </div>
        </div>
        ';
        }
        echo '
    </div>
    ';
    ?>

    <div class="blockTitle">
        <span> 主信息 </span>
    </div>
    </br>
    <div>

    </div>

    <!--关键词-->
    <div class="keywords">
        <div class="cos-lg-8" style="float: inside">

            <?= $form->field($sku, 'tags')->textInput(['class' => 'tags-input','style'=>"width:780px;"])->label('关键词tags')->hint('键词不能超过10个'); ?>

            <div class="col-sm-1" style='margin-left:3%'><strong>标题关键词：</strong></div>
            <br>
            <?= $form->field($sku,'headKeywords',['labelOptions' => ['style' => 'margin-left:4%']])->textInput(['style'=>"width:200px;margin-left:40%",'placeholder' => '--一个关键词--'])->label('最前关键词<span style = "color:red">*</span>'); ?>
            <?= $form->field($sku,'requiredKeywords')->hiddenInput()->label(false); ?>
            <?= $form->field($sku,'randomKeywords')->hiddenInput()->label(false); ?>
        </div>
        <div class="cos-lg-6" style="float: right">
            <div class='all-required' hidden="hidden" style="margin-right:20%"><textarea id="all-required" style="width:200px;height:300px;">这里写内容</textarea></div>
            <div class='all-random' hidden="hidden" style="margin-right: 10%"><textarea id="all-random" style="width:200px;height:300px;">这里写关键词</textarea></div>
        </div>
        <br>
        <div style="margin-left:6%;margin-right: 50%">
            <div><label class="control-label">必选关键词<span style = "color:red">*</span></label><span style="margin-left:1%" class="required-kw"></span></div>
            <div style="font-size:6px">
                <span><label style = "color:red">说明：</label>物品名/材质/特征等。如T-Shirt(物品名)/V-neck(特征)/Cotton(材质)</span>
            </div>
            <table class="table table-bordered table-responsive">
                <tbody>
                <?php
                echo '<tr>
        <th scope="row">必填</th>
        <td><input value="'.$required_kws[0].'" name="required_kws[0]" class="required-kw-in" type="text" class=""></td>
        <td><input value="'.$required_kws[1].'" name="required_kws[1]" class="required-kw-in" type="text" class=""></td>
        <td><input value="'.$required_kws[2].'" name="required_kws[2]" class="required-kw-in" type="text" class=""></td>
    </tr>
    <tr>
        <th scope="row">选填</th>
        <td><input value="'.$required_kws[3].'" name="required_kws[3]" class="required-kw-in" type="text" class=""></td>
        <td><input value="'.$required_kws[4].'" name="required_kws[4]" class="required-kw-in" type="text" class=""></td>
        <td><input value="'.$required_kws[5].'" name="required_kws[5]" class="required-kw-in" type="text" class=""></td>
        <td><button type="button" class="required-paste">批量设置</button></td>
    </tr>'
                ?>
                </tbody>
            </table>
        </div>
        <br>

        <div style="margin-left:6%;margin-right: 20%">
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
                <td><input value="'.$random_kws[0].'" name="random_kws[0]" class="random-kw-in" type="text" class=""></td>
                <td><input value="'.$random_kws[1].'" name="random_kws[1]" class="random-kw-in" type="text" class=""></td>
                <td><input value="'.$random_kws[2].'" name="random_kws[2]" class="random-kw-in" type="text" class=""></td>
                <td><input value="'.$random_kws[3].'" name="random_kws[3]" class="random-kw-in" type="text" class=""></td>
                <td><input value="'.$random_kws[4].'" name="random_kws[4]" class="random-kw-in" type="text" class=""></td>
            </tr>
            <tr>
                <th scope="row">选填</th>
                <td><input value="'.$random_kws[5].'" name="random_kws[5]" class="random-kw-in" type="text" class=""></td>
                <td><input value="'.$random_kws[6].'" name="random_kws[6]" class="random-kw-in" type="text" class=""></td>
                <td><input value="'.$random_kws[7].'" name="random_kws[7]" class="random-kw-in" type="text" class=""></td>
                <td><input value="'.$random_kws[8].'" name="random_kws[8]" class="random-kw-in" type="text" class=""></td>
                <td><input value="'.$random_kws[9].'" name="random_kws[9]" class="random-kw-in" type="text" class=""></td>
                <td><button type="button" class="random-paste">批量设置</button></td>
            </tr>'
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <?= $form->field($sku,'tailKeywords',['labelOptions' => ['style' => 'margin-left:4%']])->textInput(['style'=>"width:200px;margin-left:40%",'placeholder' => '--最多一个关键词--'])->label('最后关键词<span style = "color:red">*</span>'); ?>
    <?= $form->field($sku, 'description', ['template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n<div class=\"col-lg-9\">{error}</div>"])->textarea(['rows' => 12, 'cols' => 4]); ?>
    <?= $form->field($sku, 'inventory')->textInput(); ?>
    <?= $form->field($sku, 'price')->textInput(); ?>
    <?= $form->field($sku, 'msrp')->textInput(); ?>
    <?= $form->field($sku, 'shipping')->textInput(); ?>
    <?= $form->field($sku, 'shippingtime')->textInput(); ?>


    <div class="blockTitle">
        <span> 多属性(Varations)设置</span>
    </div>
    </br>
    <div class="form-group">
        <a data-toggle="modal" data-target="#edit-sku" class=" var-btn btn btn-default variations-set">设置多属性</a>
    </div>


</div>
<div class="form-group blockTitle">

    <botton class="btn btn-info update-info">
        更新
    </botton>
    <botton class="btn btn-primary wish-sign">
        保存并完善
    </botton>
    <botton class="btn btn-success export">
        导出ibay模版
    </botton>
    <botton class="btn btn-warning joom-csv">
        导出joom(csv)
    </botton>
</div>
<?php ActiveForm::end(); ?>


<?php
Modal::begin([
    'id' => 'edit-sku',
    'header' => '<h4 class="modal-title">多属性</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
    'options' => [
        'data-backdrop' => 'static',//点击空白处不关闭弹窗
        'data-keyboard' => false,
    ],
    'size' => "modal-xl"
]);


$requestUrlsku = Url::toRoute(['variations']);//弹窗的html内容，下面的js会调用获得该页面的Html内容，直接填充在弹框中


Modal::end();
?>
<script>
    //新增行的删除事件
    function removeTd(ele) {
        ele.closest('tr').remove();
    };
</script>

<style>
    .blockTitle {
        font-size: 16px;
        background-color: #f7f7f7;
        border-top: 0.5px solid #eee;
        border-bottom: 0.5px solid #eee;
        padding: 2px 12px;
        margin-left: -20px;
    }
    .channel-update-form {
        margin-left: 20px;
    }
    .blockTitle span{
        margin-top: 20px;
        font-weight: bold;
    }
</style>

<style>
    @media (min-width: 768px) {
        .modal-xl {
            width: 78%;
            /*max-width:1200px;*/
        }
    }
</style>


<?php
$updateUrl = Url::to(['update', 'id' => $sku->infoid]);
$exportUrl = Url::to(['export', 'id' => $sku->infoid]);
$joomUrl = Url::to(['export-joom', 'id' => $sku->infoid]);
$wishUrl = Url::to(['wish-sign', 'id' => $sku->infoid]);
$js = <<< JS
//主图赋值
$('.main-image').val($('.tem-page').val());

//监听主图变化事件
$(".tem-page").on('change',function() {
    //图片切换
    new_image = $(this).val();
    $(this).parents('div .form-group').find('a').attr('href',new_image);
    $(this).parents('div .form-group').find('img').attr('src',new_image);
    //更新主图值
    $('.main-image').val(new_image);
})

    //多属性内容写到模态框
    $('.variations-set').on('click',function(){
        $.get('{$requestUrlsku}',{id:{$sku->infoid}},function(data){
            $('#edit-sku').find('.modal-body').html(data);
        });
    }); 

  //关键词 判断不超过10个
   $('.tags-input').change(function(){
    var tagsstr = $(this).val();
    var arr = new Array();
    arr = tagsstr.split(',');
    
      if(arr.length>=11){
          alert('关键词不能超过10个--请注意');
      }        
    });
   
   //增加图片
function addImages() {
       
  total = 0;//判断当前图片数量
  $(".serial").each(function() {
        total++;
    });

    if(total<20){
        row = '<div class="form-group all-images">' +
    '<label class="col-lg-1"></label>' +
    '<strong class="serial">#</strong>'+
    '<div class="col-lg-3"><input type="text" name="extra_images[]" class="form-control extra-images" ></div>'+
    '<div class="col-lg=1">'+
    '<button class="btn add-images">增加</button> '+
    '<button class="btn btn-error remove-image">删除</button> '+
    '<button class="btn up-btn btn-error">上移动</button> '+
    '<button class="btn down-btn btn-error">下移动</button> '+
    '<a target="_blank" href="">'+
    '<img src="" width="50" height="50">'+
    '</a>'+
    '</div>'+
    '</div>';
        $('.images').append(row);
        //重新计算序列
        // serialize();
    }
}
   //绑定增加按钮事件
$('body').on('click','.add-images',function() {
    
    addImages();
    return false;
    });

   //绑定上移事件
$('body').on('click','.up-btn',function() {
    var point = $(this).closest('div .form-group').find('strong').text().replace('#','');
    if(point > 1){
        var temp = $(this).closest('div .all-images').clone(true);
        $(this).closest('div .all-images').prev().before(temp);
        $(this).closest('div .all-images').remove();
       
    }
    return false;
});

//绑定下移事件
$('body').on('click','.down-btn',function() {
    var point = $(this).closest('div .form-group').find('strong').text().replace('#','');
    if(point <=20){
        var temp = $(this).closest('div .all-images').clone(true);
        $(this).closest('div .all-images').next().after(temp);
        $(this).closest('div .all-images').remove();
       
    }
    return false;
});
//update-info 提交表单数据更新wishgoods
    $('.update-info').on('click',function(){
        $.ajax({
            type:'POST',
            url: "{$updateUrl}",
            data:$('#all-info').serialize(),
            success: function(res){
                alert(res);
            }
        });
    });

  //导出数据到ibay 
    $('.export').on('click',function(){
          window.location = '{$exportUrl}';
    });
    
    //导出数据joom CSV
    $('.joom-csv').on('click',function(){
        alert('确定导出Joom模板?');
         window.location = '{$joomUrl}';
    });
    
    //标记wish已完成
    $('.wish-sign').on('click',function(){
        $.ajax({
            type:"POST",
            url:'{$wishUrl}',
            success:function(res) {
                alert(res);
              
            }
        });
      
    
    });

//删除附加图
$('.remove-image').on('click',function() {
    $(this).closest('div .form-group').remove();
});

//实时刷新图片

$('.extra-images').change(function() {
    
    new_image = $(this).val();
    $(this).parents('div .form-group').find('a').attr('href',new_image);
    $(this).parents('div .form-group').find('img').attr('src',new_image);
}
);

//批量设置关键词

    $(".required-paste").on('click',function() {
        $('.all-required').removeAttr('hidden');    
    });
    $(".random-paste").on('click',function() {
        $('.all-random').removeAttr('hidden');    
    });
    requird_ele = $("#all-required");
    random_ele = $("#all-random");
    listenOnTextInput(requird_ele,'required');
    requiredCount();
    listenOnTextInput(random_ele,'random');
    randomCount();
    
    $("#all-required").on('change',function(){
        kws = $(this).val();
        kw_list = kws.split('/n');
        console.log(kw_list);
    });
//样式处理开始

    $("label[for='oawishgoods-headkeywords']").after('<span style="margin-left:1%"class="head-kw"></span><div style="font-size:6px;margin-left:3%">'+
        '<span><label style = "color:red">说明：</label>性别定位/多个一卖等。如Women/Men/Girl/Baby/Kids/1PC/2PC/5PC/4 Colors/5Pcs Set…</span></div>');
    
    $("label[for='oawishgoods-tailkeywords']").after('<span style="margin-left:1%"class="tail-kw"></span><div style="font-size:6px;margin-left:3%">'+
        '<span><label style = "color:red">说明：</label>附加说明词。如Randomly/S-3XL/2ml/(Color: Nude)/Big Size…</span></div>');
//样式处理结束

//开始关键词处理过程
 
     headCount();
     requiredCount();
     randomCount();
     tailCount();
     
    //监听最前关键词的变化
  
    $('#oawishgoods-headkeywords').on('change',function() {
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
    $('#oawishgoods-tailkeywords').on('change',function() {
        tailCount();
   });
//结束关键词处理过程



JS;
$this->registerJs($js);
?>
<script>

    //页面初始化之后开始加载字符个数
    function headCount() {
        kw = $('#oawishgoods-headkeywords').val();
        if (!kw) {
            len_kw = 0;
        }
        else {
            len_kw = kw.length;
        }
        $(".head-kw").html('<span style = "color:red">' + String(len_kw) + '</span>个字符');

    }

    function tailCount() {
        kw = $('#oawishgoods-tailkeywords').val();
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
        $(".random-kw").html('<span style = "color:red;margin-left:1%">' + String(kw_count) + '</span>个单词；<span style = "color:red">' + String(kw_length) + '</span>个字符');
        $('#oawishgoods-randomkeywords').val(JSON.stringify(keywords));
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
        $(".required-kw").html('<span style = "color:red;margin-left:1%">' + String(kw_count) + '</span>个单词；<span style = "color:red">' + String(kw_length) + '</span>个字符');
        $('#oawishgoods-requiredkeywords').val(JSON.stringify(keywords));
    }

    function listenOnTextInput(ele, name) {
        ele.on('change', function () {
            kws = $(this).val();
            kw_list = kws.split('\n');
            if (name == 'required') {
                $.each(kw_list, function (index, value) {
                    $('.required-kw-in').each(function (pos) {
                        if (index == pos) {
                            $(this).val(value);
                        }
                    })
                });
                requiredCount();
                ele.attr('hidden', 'hidden');
            }
            if (name == 'random') {
                $.each(kw_list, function (index, value) {
                    $('.random-kw-in').each(function (pos) {
                        if (index == pos) {
                            $(this).val(value);
                        }
                    })
                });
                randomCount();
                ele.attr('hidden', 'hidden');
            }
        });
    }

</script>
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

