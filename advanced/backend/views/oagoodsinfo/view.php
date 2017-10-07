<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoodsinfo */

$this->title = $model->pid;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Oa Goodsinfos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-goodsinfo-view">

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
            'SupplierID',
            'description',
            'GoodsName',
            'AliasCnName',
            'AliasEnName',
            'PackName',
            'Season',
            'StoreID',
            'DictionaryName',
        ],
    ]) ?>

</div>
