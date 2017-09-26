<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Goodssku */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="goodssku-form">

    <?php $form = ActiveForm::begin([
            'id' => 'add-form',

//        'action' => Url::to(['goodssku/create']),           //此处为请求地址 Url用法查看手册
        'enableAjaxValidation' => true,
        'validationUrl' =>['goodssku/validate'],     //数据异步校验
       // 'action' => ['/goodssku/create'], //指定action
    ]); ?>


    <?= $form->field($model, 'pid')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'sku')->textInput() ?>

    <?= $form->field($model, 'property1')->textInput() ?>

    <?= $form->field($model, 'property2')->textInput() ?>

    <?= $form->field($model, 'property3')->textInput() ?>

    <?= $form->field($model, 'CostPrice')->textInput() ?>

    <?= $form->field($model, 'Weight')->textInput() ?>

    <?= $form->field($model, 'RetailPrice')->textInput() ?>

    <?= $form->field($model, 'memo1')->textInput() ?>

    <?= $form->field($model, 'memo2')->textInput() ?>

    <?= $form->field($model, 'memo3')->textInput() ?>

    <?= $form->field($model, 'memo4')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>



    <?php ActiveForm::end(); ?>

</div>

<?php
$js = <<<JS
    //此处点击按钮提交数据的jquery
    $('.add-sku-btn').click(function () {
    $.ajax({
    url: "goodssku/create",
    type: "POST",
    dataType: "json",
    data: $('#add-form').serialize(),
    success: function(Data) {
        console.log(Data);
         alert(Data);
    // if(Data.status)
    // alert('保存成功');
    // else
    // alert('保存失败')
     },
    error: function() {
    alert('网络错误！');
    }
    });
    return false;
    });
JS;
?>






