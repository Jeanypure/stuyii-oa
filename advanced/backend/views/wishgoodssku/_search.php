<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\WishgoodsskuSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wishgoodssku-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'itemid') ?>

    <?= $form->field($model, 'pid') ?>

    <?= $form->field($model, 'sid') ?>

    <?= $form->field($model, 'sku') ?>

    <?= $form->field($model, 'pSKU') ?>

    <?php // echo $form->field($model, 'color') ?>

    <?php // echo $form->field($model, 'size') ?>

    <?php // echo $form->field($model, 'inventory') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'shipping') ?>

    <?php // echo $form->field($model, 'msrp') ?>

    <?php // echo $form->field($model, 'shipping_time') ?>

    <?php // echo $form->field($model, 'linkurl') ?>

    <?php // echo $form->field($model, 'goodsskuid') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
