<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-10-08
 * Time: 11:27
 */

use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'imageFile')->fileInput() ?>

    <button>Submit</button>

<?php ActiveForm::end() ?>