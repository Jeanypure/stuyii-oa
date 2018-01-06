<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oa-tocheck-form">

    <?php $form = ActiveForm::begin([
            'id' => 'fail-form',
        'action' => ['fail'],
    ]); ?>

    <?= $form->field($model, 'approvalNote')->textInput() ?>
    <?= $form->field($model, 'nid',['labelOptions' => ['hidden'=>"hidden"]])->hiddenInput() ?>

    <div class="form-group">
        <?= Html::button('不通过审核', ['id'=>'pass-btn','class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
    $js = <<<JS
        $('#pass-btn').on('click',function () {
            $.post($('#fail-form').attr('action'), $('form').serialize(), function(msg){
                krajeeDialog.alert(msg, function(res) {
                    location.reload();
                });
            });
        });
JS;
    $this->registerJs($js);
    ?>

</div>
