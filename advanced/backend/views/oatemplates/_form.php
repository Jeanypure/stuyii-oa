<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OaTemplates */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oa-templates-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'goodsid')->textInput() ?>

    <?= $form->field($model, 'location')->textInput() ?>

    <?= $form->field($model, 'country')->textInput() ?>

    <?= $form->field($model, 'postCode')->textInput() ?>

    <?= $form->field($model, 'prepareDay')->textInput() ?>

    <?= $form->field($model, 'site')->textInput() ?>

    <?= $form->field($model, 'listedCate')->textInput() ?>

    <?= $form->field($model, 'listedSubcate')->textInput() ?>

    <?= $form->field($model, 'title')->textInput() ?>

    <?= $form->field($model, 'subTitle')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'nowPrice')->textInput() ?>

    <?= $form->field($model, 'UPC')->textInput() ?>

    <?= $form->field($model, 'EAN')->textInput() ?>

    <?= $form->field($model, 'Brand')->textInput() ?>

    <?= $form->field($model, 'MPN')->textInput() ?>

    <?= $form->field($model, 'Color')->textInput() ?>

    <?= $form->field($model, 'Type')->textInput() ?>

    <?= $form->field($model, 'Material')->textInput() ?>

    <?= $form->field($model, 'IntendedUse')->textInput() ?>

    <?= $form->field($model, 'unit')->textInput() ?>

    <?= $form->field($model, 'bundleListing')->textInput() ?>

    <?= $form->field($model, 'shape')->textInput() ?>

    <?= $form->field($model, 'features')->textInput() ?>

    <?= $form->field($model, 'regionManufacture')->textInput() ?>

    <?= $form->field($model, 'reserveField')->textInput() ?>

    <?= $form->field($model, 'InshippingMethod1')->textInput() ?>

    <?= $form->field($model, 'InFirstCost1')->textInput() ?>

    <?= $form->field($model, 'InSuccessorCost1')->textInput() ?>

    <?= $form->field($model, 'InshippingMethod2')->textInput() ?>

    <?= $form->field($model, 'InFirstCost2')->textInput() ?>

    <?= $form->field($model, 'InSuccessorCost2')->textInput() ?>

    <?= $form->field($model, 'OutshippingMethod1')->textInput() ?>

    <?= $form->field($model, 'OutFirstCost1')->textInput() ?>

    <?= $form->field($model, 'OutSuccessorCost1')->textInput() ?>

    <?= $form->field($model, 'OutShiptoCountry1')->textInput() ?>

    <?= $form->field($model, 'OutshippingMethod2')->textInput() ?>

    <?= $form->field($model, 'OutFirstCost2')->textInput() ?>

    <?= $form->field($model, 'OutSuccessorCost2')->textInput() ?>

    <?= $form->field($model, 'OutShiptoCountry2')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
