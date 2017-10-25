<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = '登录注册';
$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => ' <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    {input}
                </div>'
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => '<div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    {input}
                </div>'
];
$checkOption = [
    'options' => ['class' => 'form-group'],
    'inputTemplate' => '<Span class="check-text">{input}</Span>'
];
$js = <<< JS
//设置背景色
$('body').css('background','#FFF');
//checkbox 汉化
var check_text = $('[for="loginform-rememberme"]').html();
var new_text = check_text.replace('Remember Me','记住密码');
$('[for="loginform-rememberme"]').html(new_text);
JS;
$this->registerJs($js);
?>

<div class="login-box">
    <!-- /.login-logo -->
    <div class="login-box-body">
        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'username',$fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('用户名')]) ?>

        <?= $form
            ->field($model, 'password',$fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('密码')]) ?>

        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe',$checkOption)->checkbox() ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-block ', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>


    <!-- /.login-box-body -->
</div><!-- /.login-box -->


