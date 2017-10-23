<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OaSysRules */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Oa Sys Rules',
]) . $model->nid;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Oa Sys Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nid, 'url' => ['view', 'id' => $model->nid]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="oa-sys-rules-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
