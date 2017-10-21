<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oa-tocheck-form">

    <?php $form = ActiveForm::begin([
        'action' => ['fail'],
    ]); ?>

    <?= $form->field($model, 'approvalNote')->textInput() ?>
    <?= $form->field($model, 'nid',['labelOptions' => ['hidden'=>"hidden"]])->hiddenInput() ?>

    <div class="form-group">
        <?= Html::submitButton('不通过审核', ['id'=>'pass-btn','class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
