<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoodsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oa-goods-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'nid') ?>

    <?= $form->field($model, 'cate') ?>

    <?= $form->field($model, 'devNum') ?>

    <?= $form->field($model, 'origin') ?>

    <?= $form->field($model, 'hopeProfit') ?>

    <?php // echo $form->field($model, 'develpoer') ?>

    <?php // echo $form->field($model, 'introducer') ?>

    <?php // echo $form->field($model, 'devStatus') ?>

    <?php // echo $form->field($model, 'checkStatus') ?>

    <?php // echo $form->field($model, 'createDate') ?>

    <?php // echo $form->field($model, 'updateDate') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
