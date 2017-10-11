<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Channel */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Channel',
]) . $model->NID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Channels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NID, 'url' => ['view', 'id' => $model->NID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="channel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
