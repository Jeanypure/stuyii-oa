<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
/* @var $this yii\web\View */
/* @var $model backend\models\Channel */

$this->title =  '更新平台信息';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '平台信息'), 'url' => ['index']];
?>
<div>
    <p>
        <?= Html::button('保存当前数据', ['id' => 'save-only','class' =>'btn btn-success']) ?>
        <?= Html::button('保存并完善', ['id' => 'save-complete','class' =>'btn btn-info']) ?>
        <?= Html::button('导出刊登模板', ['id' => 'import-templates','class' =>'btn btn-primary']) ?>
    </p>
</div>
<div class="channel-update">

    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">平台信息</a></li>
        <li role="presentation" ><a href="#">eBay</a></li>
        <li role="presentation"><a href="#">Wish</a></li>
    </ul>
</div>
</br>

<?php $form = ActiveForm::begin([
    'id' => 'msg-form',
    'options' => ['class'=>'form-horizontal'],
    'enableAjaxValidation'=>false,
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-1 control-label'],
    ]
]); ?>
<div class="blockTitle">
    <p >基本信息</p>
</div>
</br>
<?= $form->field($model,'GoodsCode')->textInput(); ?>

<div class="blockTitle">
    <p > 站点组</p>
</div>
</br>
<?= $form->field($model,'GoodsCode')->textInput(); ?>

<div class="blockTitle">
    <p > 多属性</p>
</div>
</br>
<?= $form->field($model,'GoodsCode')->textInput(); ?>

<?php ActiveForm::end() ?>

<style>
    .blockTitle {
        font-size: 16px;
        background-color: #f7f7f7;
        border-top: 0.5px solid #eee;
        border-bottom: 0.5px solid #eee;
        padding: 2px 12px;
        margin-left: -5px;
    }
</style>
