<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DataCenter */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Data Center',
]) . $model->NID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Data Centers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NID, 'url' => ['view', 'id' => $model->NID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="data-center-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
