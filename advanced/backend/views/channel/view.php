<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Channel */

$this->title = $model->GoodsCode.'-'.$model->GoodsName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '平台信息'), 'url' => ['index']];
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
            ['attribute'=>'oa_goods.vendor1','format'=>['url',['target'=>'_blank']]],
            ['attribute'=>'oa_goods.vendor2','format'=>['url',['target'=>'_blank']]],
            ['attribute'=>'oa_goods.vendor3','format'=>['url',['target'=>'_blank']]],
            ['attribute'=>'oa_goods.origin1','format'=>['url',['target'=>'_blank']]],
            ['attribute'=>'oa_goods.origin2','format'=>['url',['target'=>'_blank']]],
            ['attribute'=>'oa_goods.origin3','format'=>['url',['target'=>'_blank']]],
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

</div>
