<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoods */

$this->title = $model->devNum;
$this->params['breadcrumbs'][] = ['label' => '产品推荐', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-goods-view">
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
            'img',
            'cate',
            'subCate',
            'vendor1',
            'vendor2',
            'vendor3',
            'origin1',
            'origin2',
            'origin3',
            'devNum',
            'developer',
            'introducer',
            'devStatus',
            'checkStatus',
            'createDate',
            'updateDate',
            'salePrice',
            'hopeWeight',
            'hopeRate',
            'hopeSale',
            'hopeMonthProfit',
        ],
    ]) ?>

</div>
