<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ShippingServiceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oa-shipping-service-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'nid') ?>

    <?= $form->field($model, 'servicesName') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'siteId') ?>

    <?= $form->field($model, 'ibayShipping') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
