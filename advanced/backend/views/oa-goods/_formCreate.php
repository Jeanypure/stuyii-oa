<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oa-goods-form">

    <?php $form = ActiveForm::begin(
    ); ?>

    <?php echo  $form->field($model, 'img',['template' => "<font color='red'>*{label}</font>\n<div >{input}</div>\n<div >{error}</div>",])->textInput(['placeholder' => '--必填--']) ?>

    <?php //echo $form->field($model, 'cate',['template' => "<font color='red'>*{label}</font>\n<div >{input}</div>\n<div>{error}</div>",])->textInput(['placeholder' => '--必填--']) ?>

    <?= $form->field($model,'cate',['template' => "<font color='red'>*{label}</font>\n<div >{input}</div>\n<div >{error}</div>",])->dropDownList($model->getCityList(0),
        [
            'prompt'=>'--请选择父类--',
            'onchange'=>'
           
            $.get("'.yii::$app->urlManager->createUrl('oa-goods/forward-create').'?typeid=1&pid="+$(this).val(),function(data){
                var str="";
              $("select#oaforwardgoods-subcate").children("option").remove();
              $.each(data,function(k,v){
                    str+="<option value="+v+">"+v+"</option>";
                    });
                $("select#oaforwardgoods-subcate").html(str);
            });',
        ]) ?>

    <?= $form->field($model,'subCate',['template' => "<font color='red'>*{label}</font>\n<div >{input}</div>\n<div >{error}</div>",])->dropDownList($model->getCityList($model->cate),
        [
            'prompt'=>'--请选择子类--',

        ]) ?>

    <?php echo  $form->field($model, 'vendor1')->textInput(['placeholder' => '--选填--']) ?>

    <?php echo  $form->field($model, 'origin1')->textInput(['placeholder' => '--选填--']) ?>
    <div class="form-group">
        <?= Html::submitButton('创建', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
