<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OaEbayPaypal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oa-ebay-paypal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ebayName')->textInput() ?>

    <?= $form->field($model, 'palpayName')->textInput() ?>

    <?= $form->field($model, 'mapType')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
