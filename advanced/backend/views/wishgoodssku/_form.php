<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Wishgoodssku */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wishgoodssku-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pid')->textInput() ?>

    <?= $form->field($model, 'sid')->textInput() ?>

    <?= $form->field($model, 'sku')->textInput() ?>

    <?= $form->field($model, 'pSKU')->textInput() ?>

    <?= $form->field($model, 'color')->textInput() ?>

    <?= $form->field($model, 'size')->textInput() ?>

    <?= $form->field($model, 'inventory')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'shipping')->textInput() ?>

    <?= $form->field($model, 'msrp')->textInput() ?>

    <?= $form->field($model, 'shipping_time')->textInput() ?>

    <?= $form->field($model, 'linkurl')->textInput() ?>

    <?= $form->field($model, 'goodsskuid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
