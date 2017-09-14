<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoodsinfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oa-goodsinfo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'IsLiquid')->textInput() ?>

    <?= $form->field($model, 'IsPowder')->textInput() ?>

    <?= $form->field($model, 'isMagnetism')->textInput() ?>

    <?= $form->field($model, 'IsCharged')->textInput() ?>

    <?= $form->field($model, 'SupplierID')->textInput() ?>

    <?= $form->field($model, 'description')->textInput() ?>

    <?= $form->field($model, 'Notes')->textInput() ?>

    <?= $form->field($model, 'SampleFlag')->textInput() ?>

    <?= $form->field($model, 'SampleCount')->textInput() ?>

    <?= $form->field($model, 'SampleMemo')->textInput() ?>

    <?= $form->field($model, 'CreateDate')->textInput() ?>

    <?= $form->field($model, 'GroupFlag')->textInput() ?>

    <?= $form->field($model, 'SalerName')->textInput() ?>

    <?= $form->field($model, 'SellCount')->textInput() ?>

    <?= $form->field($model, 'SellDays')->textInput() ?>

    <?= $form->field($model, 'PackFee')->textInput() ?>

    <?= $form->field($model, 'PackName')->textInput() ?>

    <?= $form->field($model, 'GoodsStatus')->textInput() ?>

    <?= $form->field($model, 'DevDate')->textInput() ?>

    <?= $form->field($model, 'SalerName2')->textInput() ?>

    <?= $form->field($model, 'BatchPrice')->textInput() ?>

    <?= $form->field($model, 'MaxSalePrice')->textInput() ?>

    <?= $form->field($model, 'RetailPrice')->textInput() ?>

    <?= $form->field($model, 'MarketPrice')->textInput() ?>

    <?= $form->field($model, 'PackageCount')->textInput() ?>

    <?= $form->field($model, 'ChangeStatusTime')->textInput() ?>

    <?= $form->field($model, 'StockDays')->textInput() ?>

    <?= $form->field($model, 'StoreID')->textInput() ?>

    <?= $form->field($model, 'Purchaser')->textInput() ?>

    <?= $form->field($model, 'LinkUrl')->textInput() ?>

    <?= $form->field($model, 'LinkUrl2')->textInput() ?>

    <?= $form->field($model, 'LinkUrl3')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
