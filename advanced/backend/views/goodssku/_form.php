<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Goodssku */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="goodssku-form">

    <?php $form = ActiveForm::begin([
            'action' => ['/goodssku/create'], //指定action
    ]); ?>


    <?= $form->field($model, 'pid')->textInput() ?>

    <?= $form->field($model, 'sku')->textInput() ?>

    <?= $form->field($model, 'property1')->textInput() ?>

    <?= $form->field($model, 'property2')->textInput() ?>

    <?= $form->field($model, 'property3')->textInput() ?>

    <?= $form->field($model, 'CostPrice')->textInput() ?>

    <?= $form->field($model, 'Weight')->textInput() ?>

    <?= $form->field($model, 'RetailPrice')->textInput() ?>

    <?= $form->field($model, 'memo1')->textInput() ?>

    <?= $form->field($model, 'memo2')->textInput() ?>

    <?= $form->field($model, 'memo3')->textInput() ?>

    <?= $form->field($model, 'memo4')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>



    <?php ActiveForm::end(); ?>

</div>






