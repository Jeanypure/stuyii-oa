<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oa-tocheck-form">

    <?php $form = ActiveForm::begin([
        'id' => 'pass-form',
        'action' => ['pass'],
    ]); ?>

    <?= $form->field($model, 'approvalNote')->textInput() ?>
    <?= $form->field($model, 'nid',['labelOptions' => ['hidden'=>"hidden"]])->hiddenInput() ?>

    <div class="form-group">
        <?= Html::button('通过审核', ['id'=>'pass-btn','class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
    $js = <<<JS
        $('#pass-btn').on('click',function () {
            $.post($('#pass-form').attr('action'), $('form').serialize(), function(msg){
                krajeeDialog.alert(msg, function(res) {
                    location.reload();
                });
            });
        });
JS;
    $this->registerJs($js);
    ?>

</div>

