<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ChannelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="channel-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'pid') ?>

    <?= $form->field($model, 'IsLiquid') ?>

    <?= $form->field($model, 'IsPowder') ?>

    <?= $form->field($model, 'isMagnetism') ?>

    <?= $form->field($model, 'IsCharged') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'GoodsName') ?>

    <?php // echo $form->field($model, 'AliasCnName') ?>

    <?php // echo $form->field($model, 'AliasEnName') ?>

    <?php // echo $form->field($model, 'PackName') ?>

    <?php // echo $form->field($model, 'Season') ?>

    <?php // echo $form->field($model, 'DictionaryName') ?>

    <?php // echo $form->field($model, 'SupplierName') ?>

    <?php // echo $form->field($model, 'StoreName') ?>

    <?php // echo $form->field($model, 'Purchaser') ?>

    <?php // echo $form->field($model, 'possessMan1') ?>

    <?php // echo $form->field($model, 'possessMan2') ?>

    <?php // echo $form->field($model, 'DeclaredValue') ?>

    <?php // echo $form->field($model, 'picUrl') ?>

    <?php // echo $form->field($model, 'goodsid') ?>

    <?php // echo $form->field($model, 'GoodsCode') ?>

    <?php // echo $form->field($model, 'achieveStatus') ?>

    <?php // echo $form->field($model, 'devDatetime') ?>

    <?php // echo $form->field($model, 'developer') ?>

    <?php // echo $form->field($model, 'updateTime') ?>

    <?php // echo $form->field($model, 'picStatus') ?>

    <?php // echo $form->field($model, 'SupplierID') ?>

    <?php // echo $form->field($model, 'StoreID') ?>

    <?php // echo $form->field($model, 'AttributeName') ?>

    <?php // echo $form->field($model, 'bgoodsid') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
