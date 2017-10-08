<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Picinfo */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Picinfo',
]) . $model->sid;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Picinfos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sid, 'url' => ['view', 'id' => $model->sid]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="picinfo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
