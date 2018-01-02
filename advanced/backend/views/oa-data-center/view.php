<?php
/**
 * @desc show products completed.
 * @author: turpure
 * @since: 2018-01-02 13:38
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Channel */

$this->title = $model->pid;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Channels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channel-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->pid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->pid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
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
            'description',
            'GoodsName',
            'AliasCnName',
            'AliasEnName',
            'PackName',
            'Season',
            'DictionaryName',
            'SupplierName',
            'StoreName',
            'Purchaser',
            'possessMan1',
            'possessMan2',
            'DeclaredValue',
            'picUrl:url',
            'goodsid',
            'GoodsCode',
            'achieveStatus',
            'devDatetime',
            'developer',
            'updateTime',
            'picStatus',
            'SupplierID',
            'StoreID',
            'AttributeName',
            'bgoodsid',
        ],
    ]) ?>
</div