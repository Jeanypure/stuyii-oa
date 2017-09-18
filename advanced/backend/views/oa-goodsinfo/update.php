<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoodsinfo */

$this->title = '更新产品信息: ' . $model->pid;
$this->params['breadcrumbs'][] = ['label' => '更新产品id', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pid, 'url' => ['view', 'id' => $model->pid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="oa-goodsinfo-update">

    <h1><?php //echo  Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
