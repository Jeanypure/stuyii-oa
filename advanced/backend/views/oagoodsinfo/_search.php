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

    <?= $form->field($model, 'IsLiquid') ?>

    <?= $form->field($model, 'IsPowder') ?>

    <?= $form->field($model, 'isMagnetism') ?>

    <?= $form->field($model, 'IsCharged') ?>

    <?php // echo $form->field($model, 'SupplierID') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'GoodsName') ?>

    <?php // echo $form->field($model, 'AliasCnName') ?>

    <?php // echo $form->field($model, 'AliasEnName') ?>

    <?php // echo $form->field($model, 'PackName') ?>

    <?php // echo $form->field($model, 'Season') ?>

    <?php // echo $form->field($model, 'StoreID') ?>

    <?php // echo $form->field($model, 'DictionaryName') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
