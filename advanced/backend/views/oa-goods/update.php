<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoods */

$this->title = 'Update Oa Goods: ' . $model->nid;
$this->params['breadcrumbs'][] = ['label' => 'Oa Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nid, 'url' => ['view', 'id' => $model->nid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="oa-goods-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
