<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OaSysRules */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oa-sys-rules-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ruleName')->textInput() ?>

    <?= $form->field($model, 'ruleKey')->textInput() ?>

    <?= $form->field($model, 'ruleValue')->textInput() ?>

    <?= $form->field($model, 'ruleType')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
