<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\OaEbayCountry;

/* @var $this yii\web\View */
/* @var $model backend\models\OaShippingService */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oa-shipping-service-form">

    <?php //$countryList = ActiveForm::begin(); ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'servicesName')->textInput() ?>

    <?= $form->field($model, 'type')->dropDownList(Yii::$app->params['typeList'], ['prompt' => '--请选择--']) ?>

    <?= $form->field($model, 'siteId')->dropDownList(ArrayHelper::map(OaEbayCountry::find()->all(),'code', 'Name'), ['prompt' => '--请选择--']) ?>

    <?= $form->field($model, 'ibayShipping')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
