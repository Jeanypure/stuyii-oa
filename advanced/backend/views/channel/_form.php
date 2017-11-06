<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Channel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="channel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'IsLiquid')->textInput() ?>

    <?= $form->field($model, 'IsPowder')->textInput() ?>

    <?= $form->field($model, 'isMagnetism')->textInput() ?>

    <?= $form->field($model, 'IsCharged')->textInput() ?>

    <?= $form->field($model, 'description')->textInput() ?>

    <?= $form->field($model, 'GoodsName')->textInput() ?>

    <?= $form->field($model, 'AliasCnName')->textInput() ?>

    <?= $form->field($model, 'AliasEnName')->textInput() ?>

    <?= $form->field($model, 'PackName')->textInput() ?>

    <?= $form->field($model, 'Season')->textInput() ?>

    <?= $form->field($model, 'DictionaryName')->textInput() ?>

    <?= $form->field($model, 'SupplierName')->textInput() ?>

    <?= $form->field($model, 'StoreName')->textInput() ?>

    <?= $form->field($model, 'Purchaser')->textInput() ?>

    <?= $form->field($model, 'possessMan1')->textInput() ?>

    <?= $form->field($model, 'possessMan2')->textInput() ?>

    <?= $form->field($model, 'DeclaredValue')->textInput() ?>

    <?= $form->field($model, 'picUrl')->textInput() ?>

    <?= $form->field($model, 'goodsid')->textInput() ?>

    <?= $form->field($model, 'GoodsCode')->textInput() ?>

    <?= $form->field($model, 'achieveStatus')->textInput() ?>

    <?= $form->field($model, 'devDatetime')->textInput() ?>

    <?= $form->field($model, 'developer')->textInput() ?>

    <?= $form->field($model, 'updateTime')->textInput() ?>

    <?= $form->field($model, 'picStatus')->textInput() ?>

    <?= $form->field($model, 'SupplierID')->textInput() ?>

    <?= $form->field($model, 'StoreID')->textInput() ?>

    <?= $form->field($model, 'AttributeName')->textInput() ?>

    <?= $form->field($model, 'bgoodsid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
