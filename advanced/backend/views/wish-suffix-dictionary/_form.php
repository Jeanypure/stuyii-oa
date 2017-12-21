<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\WishSuffixDictionary */
/* @var $form yii\widgets\ActiveForm */
?>

<?php

$this->registerJs(
    '$("document").ready(function(){ 
        $("#new_country").on("pjax:end", function() {
            $.pjax.reload({container:"#suffix"});  //Reload GridView
        });
    });'
);
?>



<div class="wish-suffix-dictionary-form">

    <?php yii\widgets\Pjax::begin(['id' => 'new_country']) ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>

<div class="row">
    <div class="col-md-6"><?= $form->field($model, 'IbaySuffix')->textInput() ?></div>
    <div class="col-md-6"><?= $form->field($model, 'ShortName')->textInput() ?></div>
    <div class="col-md-6"><?= $form->field($model, 'Suffix')->textInput() ?></div>
    <div class="col-md-6"><?= $form->field($model, 'Rate')->textInput() ?></div>
    <div class="col-md-6"><?= $form->field($model, 'MainImg')->textInput() ?></div>

</div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '+新增Add' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php yii\widgets\Pjax::end() ?>

</div>
