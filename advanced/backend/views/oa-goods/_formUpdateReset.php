<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoods */
/* @var $form yii\widgets\ActiveForm */

// 生成URL

$reCheckUrl = Url::toRoute('recheck');
$trashUrl = Url::toRoute('trash');
$js = <<<JS
//重新提交审核事件
$('#recheck-btn').on('click',function() {
    $.get('{$reCheckUrl}', {id: '{$model->nid}'});
})

//作废事件
$('#trash-btn').on('click', function() {
    $.get('{$trashUrl}',{id:'{$model->nid}'});
})
JS;
$this->registerJs($js);





?>

<div class="oa-goods-form">

    <?php $form = ActiveForm::begin([
        'fieldConfig'=>[
            'template'=> "{label}\n<div >{input}</div>\n{error}",
        ]
    ]); ?>


    <?= $form->field($model, 'img')->textInput() ?>

    <?= $form->field($model, 'cate')->textInput() ?>

    <?= $form->field($model, 'subCate')->textInput() ?>

    <?= $form->field($model, 'vendor1')->textInput() ?>

    <?= $form->field($model, 'origin1')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
        <?= Html::button('重新提交审核', ['id'=>'recheck-btn','class' => 'btn btn-info']) ?>
        <?= Html::button('作废', ['id'=>'trash-btn','class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
