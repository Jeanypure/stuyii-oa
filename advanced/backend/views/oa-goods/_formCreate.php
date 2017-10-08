<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oa-goods-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'img')->textInput(['placeholder' => '必填']) ?>

    <?= $form->field($model, 'cate')->textInput(['placeholder' => '必填']) ?>

    <?= $form->field($model, 'subCate')->textInput(['placeholder' => '必填']) ?>

    <?= $form->field($model, 'origin1')->textInput(['placeholder' => '必填']) ?>

    <?= $form->field($model, 'origin2')->textInput(['placeholder' => '选填']) ?>

    <?= $form->field($model, 'origin3')->textInput(['placeholder' => '选填']) ?>

    <?= $form->field($model, 'vendor1')->textInput(['placeholder' => '选填']) ?>

    <?= $form->field($model, 'vendor2')->textInput(['placeholder' => '选填']) ?>

    <?= $form->field($model, 'vendor3')->textInput(['placeholder' => '选填']) ?>

    <?= $form->field($model, 'salePrice')->textInput(['placeholder' => '必填']) ?>

    <?= $form->field($model, 'hopeWeight')->textInput(['placeholder' => '必填']) ?>

    <?= $form->field($model, 'hopeRate')->textInput(['placeholder' => '必填']) ?>

    <?= $form->field($model, 'hopeSale')->textInput(['placeholder' => '必填']) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
