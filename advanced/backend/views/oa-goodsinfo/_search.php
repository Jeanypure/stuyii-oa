<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoodsinfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oa-goodsinfo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'pid') ?>

    <?= $form->field($model, 'GoodsName') ?>

    <?php  echo $form->field($model, 'SupplierName') ?>

    <?= $form->field($model, 'AliasCnName') ?>

    <?= $form->field($model, 'AliasEnName') ?>

    <?= $form->field($model, 'PackName') ?>

    <?php  echo $form->field($model, 'description') ?>

    <?= $form->field($model, 'Season') ?>

    <?= $form->field($model, 'StoreName') ?>

    <?= $form->field($model, 'IsLiquid') ?>

    <?= $form->field($model, 'IsPowder') ?>

    <?= $form->field($model, 'isMagnetism') ?>

    <?= $form->field($model, 'IsCharged') ?>

    <?php  echo $form->field($model, 'DictionaryName') ?>



    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
