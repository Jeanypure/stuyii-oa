<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\WishSuffixDictionary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wish-suffix-dictionary-form">

    <?php
    $id = $model->isNewRecord ? 0 : $model->nid;
    $form = ActiveForm::begin([
        'id' => 'form-id',
        'enableAjaxValidation' => true,
        'validationUrl' => \yii\helpers\Url::to(['validate-form', 'id' => $id]),
    ]); ?>

    <?= $form->field($model, 'ebayName')->textInput() ?>

    <?= $form->field($model, 'ebaySuffix')->textInput() ?>

    <?= $form->field($model, 'nameCode')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
