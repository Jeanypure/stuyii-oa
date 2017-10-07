<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoodsinfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oa-goodsinfo-form">

    <?php $form = ActiveForm::begin(); ?>

<!--    'GoodsName',-->
<!--    'AliasCnName',-->
<!--    'AliasEnName',-->
<!--    //            'PackName',-->
<!--    //            'Season',-->
<!--    //            'StoreID',-->

    <?= $form->field($model, 'GoodsName')->textInput() ?>
    <?= $form->field($model, 'SupplierName')->textInput() ?>
    <?= $form->field($model, 'AliasCnName')->textInput() ?>
    <?= $form->field($model, 'AliasEnName')->textInput() ?>

    <?= $form->field($model, 'PackName')->textInput()?>
    <?= $form->field($model, 'Season')->textInput() ?>
    <?= $form->field($model, 'StoreName')->textInput() ?>

    <?= $form->field($model, 'IsLiquid')->textInput() ?>

    <?= $form->field($model, 'IsPowder')->textInput() ?>

    <?= $form->field($model, 'isMagnetism')->textInput() ?>

    <?= $form->field($model, 'IsCharged')->textInput() ?>

    <?= $form->field($model, 'description')->textInput() ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
