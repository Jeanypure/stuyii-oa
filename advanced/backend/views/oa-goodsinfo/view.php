<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoodsinfo */

$this->title = $model->pid;
$this->params['breadcrumbs'][] = ['label' => 'Oa Goodsinfos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-goodsinfo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->pid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->pid], [
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
            'pid',
            'IsLiquid',
            'IsPowder',
            'isMagnetism',
            'IsCharged',
            'SupplierID',
            'description',
            'Notes',
            'SampleFlag',
            'SampleCount',
            'SampleMemo',
            'CreateDate',
            'GroupFlag',
            'SalerName',
            'SellCount',
            'SellDays',
            'PackFee',
            'PackName',
            'GoodsStatus',
            'DevDate',
            'SalerName2',
            'BatchPrice',
            'MaxSalePrice',
            'RetailPrice',
            'MarketPrice',
            'PackageCount',
            'ChangeStatusTime',
            'StockDays',
            'StoreID',
            'Purchaser',
            'LinkUrl:url',
            'LinkUrl2:url',
            'LinkUrl3:url',
        ],
    ]) ?>

</div>