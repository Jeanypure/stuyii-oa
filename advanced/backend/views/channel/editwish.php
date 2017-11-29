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
$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Channel',
    ]) . $sku->infoid;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Channels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $sku->infoid, 'url' => ['view', 'id' => $sku->infoid]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="channel-update-form">

    <?php
        $form = ActiveForm::begin([

            'action'=>['/channel/update'],
            'method'=>'post',
            'id'=>'all-info',
            'options' => ['class'=>'form-horizontal'],
            'enableAjaxValidation'=>false,
            'fieldConfig'=>[
                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-9\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],

            ]]);

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

    ?>
    <div class="form-group blockTitle">

        <botton class="btn btn-info update-info">
            更新
        </botton>
        <botton class="btn btn-primary ">
            保存并完善
        </botton>
        <botton class="btn btn-success export">
            导出ibay模版
        </botton>
    </div>
    <div class="blockTitle">
        <p >基本信息</p>

    </div>
    <?=$form->field($sku,'SKU')->textInput();?>
    <?php

    echo '<div class="form-group field-oatemplates-mainpage">
         
         <label class="col-lg-1 control-label">主图</label>
            <div class="col-lg-3"><input name="main_image" type="text" class="form-control" value="https://www.tupianku.com/view/full/10023/'.$sku->SKU.'-_0_.jpg">
            </div>
            <div class="col-lg=1"> 
                <a target="_blank" href="https://www.tupianku.com/view/full/10023/'.$sku->SKU.'-_0_.jpg">
                <img src="https://www.tupianku.com/view/full/10023/'.$sku->SKU.'-_0_.jpg" width="80" height="80">
                </a>
            </div>
        </div>';

    ?>
    <?php
        echo '<div class="images">';

            foreach ($extra_images as $key=>$value){

            echo '<div class="form-group all-images">
                    <label class="col-lg-1"></label>
                    <strong class="serial">#'.($key+1).'</strong>
                    <div class="col-lg-3">
                        <input name="extra_images[]" type="text" class="form-control extra-images" value="'.$value.'">
                    </div>
                    <div class="col-lg=1">
                    <button  class="btn add-images">增加</button>
                    <button  class="btn btn-error remove-image">删除</button>
                    <button class="btn up-btn btn-error">上移动</button>
                    <button class="btn down-btn btn-error">下移动</button>
                    <a target="_blank" href="'.$value.'">
                    <img src="'.$value.'" width="50" height="50"/>
                    </a>
                    </div>
                 </div>';
        }
        echo '</div>';
    ?>

    <div class="blockTitle">
        <p > 主信息 </p>
    </div>
    </br>
    <?= $form->field($sku,'title')->textInput(); ?>
    <?= $form->field($sku,'tags')->textInput(['class'=>'tags-input']); ?>
    <?= $form->field($sku,'description')->textarea(['rows'=>6]); ?>
    <?= $form->field($sku,'inventory')->textInput(); ?>
    <?= $form->field($sku,'price')->textInput(); ?>
    <?= $form->field($sku,'msrp')->textInput(); ?>
    <?= $form->field($sku,'shipping')->textInput(); ?>
    <?= $form->field($sku,'shippingtime')->textInput(); ?>


    <div class="blockTitle">
        <p> 多属性(Varations)设置</p>
    </div>
</br>
    <div class="form-group">
        <a  data-toggle="modal" data-target="#edit-sku" class=" var-btn btn btn-default varations-set">设置多属性</a>
    </div>



</div>
<div class="form-group blockTitle">

    <botton class="btn btn-info update-info">
        更新
    </botton>
    <botton class="btn btn-primary ">
        保存并完善
    </botton>
    <botton class="btn btn-success export">
        导出ibay模版
    </botton>
</div>
<?php  ActiveForm::end();?>


<?php
Modal::begin([
    'id' => 'edit-sku',
    'header' => '<h4 class="modal-title">多属性</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
    'options'=>[
        'data-backdrop'=>'static',//点击空白处不关闭弹窗
        'data-keyboard'=>false,
    ],
    'size' => "modal-xl"
]);


$requestUrlsku = Url::toRoute(['varations']);//弹窗的html内容，下面的js会调用获得该页面的Html内容，直接填充在弹框中



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
$js  = <<< JS
    //多属性内容写到模态框
    $('.varations-set').on('click',function(){
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
            url:'/channel/update?id='+$sku->infoid,
            data:$('#all-info').serialize(),
            success: function(res){
                alert(res);
            }
        });
    });

  //导出数据到ibay 
    $('.export').on('click',function(){
        $.ajax({
            type:'POST',
            url:'/channel/export?id='+$sku->infoid,
            // data:,
            success: function(){
                window.location = '/channel/export?id='+$sku->infoid;

            },
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

