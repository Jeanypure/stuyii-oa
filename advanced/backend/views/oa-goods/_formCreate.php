<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oa-goods-form">

    <?php $form = ActiveForm::begin(
    ); ?>

    <?= $form->field($model, 'img',['template' => "<font color='red'>*{label}</font>\n<div >{input}</div>\n<div >{error}</div>",])->textInput(['placeholder' => '--必填--']) ?>

    <?= $form->field($model, 'cate',['template' => "<font color='red'>*{label}</font>\n<div >{input}</div>\n<div>{error}</div>",])->textInput(['placeholder' => '--必填--']) ?>

    <?= $form->field($model, 'subCate',['template' => "<font color='red'>*{label}</font>\n<div >{input}</div>\n<div>{error}</div>",])->textInput(['placeholder' => '--必填--']) ?>

    <?= $form->field($model, 'origin1')->textInput(['placeholder' => '--选填--']) ?>

    <?= $form->field($model, 'vendor1')->textInput(['placeholder' => '--选填--']) ?>

    <div class="form-group">
        <?= Html::submitButton('创建', ['class' => $model->isNewRecord ? 'btn btn-info' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
