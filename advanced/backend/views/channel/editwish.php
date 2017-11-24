<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-11-07
 * Time: 11:09
 */
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Tabs;
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
<div class="channel-update-form">

    <?php
        $form = ActiveForm::begin([
                'action'=>['/channel/update'],
            'method'=>'post',
//            'type'=>ActiveForm::TYPE_HORIZONTAL,
            'options' => ['class'=>'form-horizontal'],
            'id'=>'all-info',
//            'enableAjaxValidation'=>false,
            'formConfig'=>[
                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
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
    <div class="blockTitle">
        <p >基本信息</p>

    </div>
    <?php

    echo $form->field($sku,'SKU')->textInput()->label('SKU');
    echo '<div class="form-group field-oatemplates-mainpage">
    <label class="col-lg-1 control-label">主图</label>
    <div class="col-lg-3"><input type="text" class="form-control" value="https://www.tupianku.com/view/full/10023/'.$sku->SKU.'-_0_.jpg"></div>
    <div class="col-lg=1"> 
    <a target="_blank" href="https://www.tupianku.com/view/full/10023/'.$sku->SKU.'-_0_.jpg">
    <img src="https://www.tupianku.com/view/full/10023/'.$sku->SKU.'-_0_.jpg" width="80" height="80">
    </a>
    </div>
</div>';

    ?>
    <?= $form->field($sku,'extra_image')->textarea(['style'=>'display:none']); ?>

    <?php
    for($i=1;$i<=20;$i++){
        echo '<div class="form-group">
    <label class="col-lg-1"></label>
    <div class="col-lg-3"><input  type="text" class="form-control extra-images" value="https://www.tupianku.com/view/full/10023/'.$sku->SKU.'-_'.$i.'_.jpg"></div>
    <div class="col-lg=1">
    <button  class="btn btn-error remove-image">删除</button>
    <button class="btn btn-error">移动</button>
    <a target="_blank" href="https://www.tupianku.com/view/full/10023/'.$sku->SKU.'-_'.$i.'_.jpg">
    <img src="https://www.tupianku.com/view/full/10023/'.$sku->SKU.'-_'.$i.'_.jpg" width="50" height="50">
    </a>
    </div>
</div>';
    }
    ?>

    <div class="blockTitle">
        <p > 主信息 </p>
    </div>
    </br>
    <?= $form->field($sku,'title')->textInput(); ?>
    <?= $form->field($sku,'description')->textarea(['rows'=>6]); ?>
    <?= $form->field($sku,'inventory')->textInput(); ?>
    <?= $form->field($sku,'price')->textInput(); ?>
    <?= $form->field($sku,'msrp')->textInput(); ?>
    <?= $form->field($sku,'shipping')->textInput(); ?>
    <?= $form->field($sku,'shippingtime')->textInput(); ?>
    <?= $form->field($sku,'tags')->textInput(['class'=>'tags-input']); ?>

    <div class="blockTitle">
        <p> 多属性(Varations)设置</p>
    </div>

    <div class="form-group">
        <a  data-toggle="modal" data-target="#edit-sku" class=" var-btn btn btn-default varations-set">设置多属性</a>
    </div>
    <div class="form-group">

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

</div>



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
    .align-center {
        clear: both;
        display: block;
        margin:auto;
    }
    .blockTitle {
        font-size: 16px;
        background-color: #f7f7f7;
        border-top: 0.5px solid #eee;
        border-bottom: 0.5px solid #eee;
        padding: 2px 12px;
        margin-left: -5px;
    }
</style>




<?php
$js  = <<< JS
    //多属性内容写到模态框
    $('.varations-set').on('click',function(){
        $.get('{$requestUrlsku}',{},function(data){
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
//update-info 提交表单数据更新wishgoods
    $('.update-info').on('click',function(){
        $.ajax({
            type:'POST',
            url:'/channel/update?id='+$info->pid,
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
            url:'/channel/export?id='+$info->pid,
            // data:,
            success: function(){
              // window.open('http://localhost:8076/channel/update?id=86','_blank' );
                window.location = '/channel/export?id='+$info->pid;
              //  window.location.href = response.url;  

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

