<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoods */

$this->title = $model->devNum;
$this->params['breadcrumbs'][] = ['label' => 'Oa Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-goods-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->nid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->nid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nid',
            'img',
            'cate',
            'devNum',
            'origin',
            'hopeProfit',
            'develpoer',
            'introducer',
            'devStatus',
            'checkStatus',
            'createDate',
            'updateDate',
        ],
    ]) ?>

</div>
