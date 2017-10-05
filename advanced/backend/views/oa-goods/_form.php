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

    <?= $form->field($model, 'devNum')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'origin')->textInput() ?>

    <?= $form->field($model, 'hopeProfit')->textInput() ?>

    <?= $form->field($model, 'develpoer')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'introducer')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'devStatus')->textInput(['readonly'=>true])?>

    <?= $form->field($model, 'checkStatus')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'createDate')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'updateDate')->textInput(['readonly'=>true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
