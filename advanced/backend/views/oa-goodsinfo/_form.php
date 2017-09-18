<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoodsinfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oa-goodsinfo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'IsLiquid')->textInput() ?>

    <?= $form->field($model, 'IsPowder')->textInput() ?>

    <?= $form->field($model, 'isMagnetism')->textInput() ?>

    <?= $form->field($model, 'IsCharged')->textInput() ?>

    <?= $form->field($model, 'SupplierID')->textInput() ?>

    <?= $form->field($model, 'description')->textInput() ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>


    </div>
    <?php ActiveForm::end(); ?>

</div>
