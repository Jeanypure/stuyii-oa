<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Picinfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="picinfo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pid')->textInput() ?>

    <?= $form->field($model, 'sku')->textInput() ?>

    <?= $form->field($model, 'property1')->textInput() ?>

    <?= $form->field($model, 'property2')->textInput() ?>

    <?= $form->field($model, 'property3')->textInput() ?>

    <?= $form->field($model, 'CostPrice')->textInput() ?>

    <?= $form->field($model, 'Weight')->textInput() ?>

    <?= $form->field($model, 'RetailPrice')->textInput() ?>

    <?= $form->field($model, 'memo1')->textInput() ?>

    <?= $form->field($model, 'memo2')->textInput() ?>

    <?= $form->field($model, 'memo3')->textInput() ?>

    <?= $form->field($model, 'memo4')->textInput() ?>

    <?= $form->field($model, 'linkurl')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>