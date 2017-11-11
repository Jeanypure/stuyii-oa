<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OaTemplatesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oa-templates-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'nid') ?>

    <?= $form->field($model, 'goodsid') ?>

    <?= $form->field($model, 'location') ?>

    <?= $form->field($model, 'country') ?>

    <?= $form->field($model, 'postCode') ?>

    <?php // echo $form->field($model, 'prepareDay') ?>

    <?php // echo $form->field($model, 'site') ?>

    <?php // echo $form->field($model, 'listedCate') ?>

    <?php // echo $form->field($model, 'listedSubcate') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'subTitle') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'quantity') ?>

    <?php // echo $form->field($model, 'nowPrice') ?>

    <?php // echo $form->field($model, 'UPC') ?>

    <?php // echo $form->field($model, 'EAN') ?>

    <?php // echo $form->field($model, 'Brand') ?>

    <?php // echo $form->field($model, 'MPN') ?>

    <?php // echo $form->field($model, 'Color') ?>

    <?php // echo $form->field($model, 'Type') ?>

    <?php // echo $form->field($model, 'Material') ?>

    <?php // echo $form->field($model, 'IntendedUse') ?>

    <?php // echo $form->field($model, 'unit') ?>

    <?php // echo $form->field($model, 'bundleListing') ?>

    <?php // echo $form->field($model, 'shape') ?>

    <?php // echo $form->field($model, 'features') ?>

    <?php // echo $form->field($model, 'regionManufacture') ?>

    <?php // echo $form->field($model, 'reserveField') ?>

    <?php // echo $form->field($model, 'InshippingMethod1') ?>

    <?php // echo $form->field($model, 'InFirstCost1') ?>

    <?php // echo $form->field($model, 'InSuccessorCost1') ?>

    <?php // echo $form->field($model, 'InshippingMethod2') ?>

    <?php // echo $form->field($model, 'InFirstCost2') ?>

    <?php // echo $form->field($model, 'InSuccessorCost2') ?>

    <?php // echo $form->field($model, 'OutshippingMethod1') ?>

    <?php // echo $form->field($model, 'OutFirstCost1') ?>

    <?php // echo $form->field($model, 'OutSuccessorCost1') ?>

    <?php // echo $form->field($model, 'OutShiptoCountry1') ?>

    <?php // echo $form->field($model, 'OutshippingMethod2') ?>

    <?php // echo $form->field($model, 'OutFirstCost2') ?>

    <?php // echo $form->field($model, 'OutSuccessorCost2') ?>

    <?php // echo $form->field($model, 'OutShiptoCountry2') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
