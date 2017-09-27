<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-26
 * Time: 14:38
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\Goodssku */

//$this->title = Yii::t('app', 'Add one Goodssku');
$this->title = 'add sku: ' . $pid[0];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Goodsskus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="createsku-form">
        <?php $form = ActiveForm::begin([
//            'id' => 'add-form',
//            'enableAjaxValidation' => true,
//            'validationUrl' =>['validate'],     //数据异步校验
            'action' => ['createsku'], //指定action
        ]); ?>


        <?php echo $form->field($model, 'pid')->textInput(['readonly' => true, 'value' => $pid[0]]) ?>

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
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>











