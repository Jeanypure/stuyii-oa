<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoodsinfo */

$this->title = 'Update Oa Goodsinfo: ' . $model->pid;
$this->params['breadcrumbs'][] = ['label' => 'Oa Goodsinfos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pid, 'url' => ['view', 'id' => $model->pid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="oa-goodsinfo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
