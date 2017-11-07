<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-11-07
 * Time: 11:09
 */
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\Channel */
$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Channel',
    ]) . $model->pid;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Channels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pid, 'url' => ['view', 'id' => $model->pid]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="channel-update">

    <?php
    $form =ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
    echo Html::label("<legend class='text-info'><small>基本信息</small></legend>");
  echo $form->field($model, 'GoodsCode')->textInput(['maxlength' => 20])
    ?>



</div>

