<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OaSysRulesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oa-sys-rules-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'nid') ?>

    <?= $form->field($model, 'ruleName') ?>

    <?= $form->field($model, 'ruleKey') ?>

    <?= $form->field($model, 'ruleValue') ?>

    <?= $form->field($model, 'ruleType') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
