<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GoodsskuSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goodssku-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'sid') ?>

    <?= $form->field($model, 'pid') ?>

    <?= $form->field($model, 'sku') ?>

    <?= $form->field($model, 'property1') ?>

    <?= $form->field($model, 'property2') ?>

    <?php // echo $form->field($model, 'property3') ?>

    <?php // echo $form->field($model, 'CostPrice') ?>

    <?php // echo $form->field($model, 'Weight') ?>

    <?php // echo $form->field($model, 'RetailPrice') ?>

    <?php // echo $form->field($model, 'memo1') ?>

    <?php // echo $form->field($model, 'memo2') ?>

    <?php // echo $form->field($model, 'memo3') ?>

    <?php // echo $form->field($model, 'memo4') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
