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

    <?php // echo $form->field($model, 'Notes') ?>

    <?php // echo $form->field($model, 'SampleFlag') ?>

    <?php // echo $form->field($model, 'SampleCount') ?>

    <?php // echo $form->field($model, 'SampleMemo') ?>

    <?php // echo $form->field($model, 'CreateDate') ?>

    <?php // echo $form->field($model, 'GroupFlag') ?>

    <?php // echo $form->field($model, 'SalerName') ?>

    <?php // echo $form->field($model, 'SellCount') ?>

    <?php // echo $form->field($model, 'SellDays') ?>

    <?php // echo $form->field($model, 'PackFee') ?>

    <?php // echo $form->field($model, 'PackName') ?>

    <?php // echo $form->field($model, 'GoodsStatus') ?>

    <?php // echo $form->field($model, 'DevDate') ?>

    <?php // echo $form->field($model, 'SalerName2') ?>

    <?php // echo $form->field($model, 'BatchPrice') ?>

    <?php // echo $form->field($model, 'MaxSalePrice') ?>

    <?php // echo $form->field($model, 'RetailPrice') ?>

    <?php // echo $form->field($model, 'MarketPrice') ?>

    <?php // echo $form->field($model, 'PackageCount') ?>

    <?php // echo $form->field($model, 'ChangeStatusTime') ?>

    <?php // echo $form->field($model, 'StockDays') ?>

    <?php // echo $form->field($model, 'StoreID') ?>

    <?php // echo $form->field($model, 'Purchaser') ?>

    <?php // echo $form->field($model, 'LinkUrl') ?>

    <?php // echo $form->field($model, 'LinkUrl2') ?>

    <?php // echo $form->field($model, 'LinkUrl3') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
