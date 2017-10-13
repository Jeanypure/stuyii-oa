<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GoodsCatsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-cats-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'NID') ?>

    <?= $form->field($model, 'CategoryLevel') ?>

    <?= $form->field($model, 'CategoryName') ?>

    <?= $form->field($model, 'CategoryParentID') ?>

    <?= $form->field($model, 'CategoryParentName') ?>

    <?php // echo $form->field($model, 'CategoryOrder') ?>

    <?php // echo $form->field($model, 'CategoryCode') ?>

    <?php // echo $form->field($model, 'GoodsCount') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
