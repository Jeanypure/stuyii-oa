<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoods */
/* @var $form yii\widgets\ActiveForm */

$js = <<<JS

//创建提交审核事件
$('#create-to-check').on('click',function() {
    var form = $('#create-form');
        form.attr('action', form.data('href'));
        form.submit();
});




JS;
$this->registerJs($js);

$getSubCateUrl = Url::toRoute(['oa-goods/forward-create','typeid'=>1, ]);
?>

<div class="oa-goods-form">

    <?php $form = ActiveForm::begin(
        [
            'id' => 'create-form',
            'method' => 'post',
            'options' => ['data-href' => Url::to(['oa-goods/forward-create', 'type' => 'check'])],
        ]
    ); ?>

    <?php echo  $form->field($model, 'img',['template' => "<font color='red'>*{label}</font>\n<div >{input}</div>\n<div >{error}</div>",])->textInput(['placeholder' => '--必填--']) ?>


    <?= $form->field($model,'cate',['template' => "<font color='red'>*{label}</font>\n<div >{input}</div>\n<div >{error}</div>",])->dropDownList($model->getCatList(0),
        [
            'prompt'=>'--请选择父类--',
            'onchange'=>'
           
            $.get("'.$getSubCateUrl.'&pid="+$(this).val(),function(data){
                var str="";
              $("select#oaforwardgoods-subcate").children("option").remove();
              $.each(data,function(k,v){
                    str+="<option value="+v+">"+v+"</option>";
                    });
                $("select#oabackwardgoods-subcate").html(str);
            });',
        ]) ?>

    <?= $form->field($model,'subCate',['template' => "<font color='red'>*{label}</font>\n<div >{input}</div>\n<div >{error}</div>",])->dropDownList($model->getCatList($model->cate),
        [
            'prompt'=>'--请选择子类--',

        ]) ?>

    <?php echo  $form->field($model, 'origin1',['template' => "<font color='red'>*{label}</font>\n<div >{input}</div>\n<div >{error}</div>",])->textInput(['placeholder' => '--必填--']) ?>

    <?php echo  $form->field($model, 'vendor1')->textInput(['placeholder' => '--选填--']) ?>

    <?php echo  $form->field($model, 'vendor2')->textInput() ?>
    <?php echo  $form->field($model, 'vendor3')->textInput() ?>

    <?php echo  $form->field($model, 'origin2')->textInput(['placeholder' => '--选填--']) ?>
    <?php echo  $form->field($model, 'origin3')->textInput(['placeholder' => '--选填--']) ?>

    <?php echo  $form->field($model, 'salePrice')->textInput(['placeholder' => '--选填--']) ?>
    <?php echo  $form->field($model, 'hopeSale')->textInput(['placeholder' => '--选填--']) ?>
    <?php echo  $form->field($model, 'hopeRate')->textInput(['placeholder' => '--选填--']) ?>
    <?php echo  $form->field($model, 'hopeWeight')->textInput(['placeholder' => '--选填--']) ?>
    <?php echo  $form->field($model, 'hopeCost')->textInput(['placeholder' => '--选填--']) ?>
    <?php echo  $form->field($model, 'hopeMonthProfit')->textInput(['readonly'=> 'true','placeholder' => '--自动计算--']) ?>





    <div class="form-group">
        <?= Html::submitButton('创建', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::button('创建并提交审批', ['id' => 'create-to-check', 'class' => 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
