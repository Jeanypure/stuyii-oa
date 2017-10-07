<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oa-goods-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'img')->textInput() ?>
    <?= $form->field($model, 'cate')->textInput() ?>

    <?= $form->field($model, 'devNum')->textInput() ?>

    <?= $form->field($model, 'origin')->textInput() ?>

    <?= $form->field($model, 'hopeProfit')->textInput() ?>

    <?= $form->field($model, 'developer')->textInput() ?>

    <?= $form->field($model, 'introducer')->textInput() ?>

    <?= $form->field($model, 'devStatus')->textInput()?>

    <?= $form->field($model, 'checkStatus')->textInput() ?>

    <?= $form->field($model, 'createDate')->textInput() ?>

    <?= $form->field($model, 'updateDate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
