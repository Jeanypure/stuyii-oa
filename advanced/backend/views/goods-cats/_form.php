<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GoodsCats */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-cats-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CategoryLevel')->textInput() ?>

    <?= $form->field($model, 'CategoryName')->textInput() ?>

    <?= $form->field($model, 'CategoryParentID')->textInput() ?>

    <?= $form->field($model, 'CategoryParentName')->textInput() ?>

    <?= Html::activeDropDownList($model,'CategoryParentID', $model->getCityList(0),
        ['prompt'=>'--请选父类--',
            'onchange'=>'$.post("'.yii::$app->urlManager->createUrl('Goods-Cats/create').'&CategoryLevel=1&pid="+$(this).val(),function(data){var str="";$.each(data,function(k,v){str+="<option value="+v+">"+v+"</option>";});$("select#shop-city").html(str);})'
        ]);?>

    <?= Html::activeDropDownList($model,'CategoryParentID', $model->getCityList($model->CategoryParentID),

        ['prompt'=>'--请选择子类--',]);?>


    <?= $form->field($model, 'CategoryOrder')->textInput() ?>

    <?= $form->field($model, 'CategoryCode')->textInput() ?>

    <?= $form->field($model, 'GoodsCount')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
