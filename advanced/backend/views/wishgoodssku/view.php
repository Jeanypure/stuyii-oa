<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Wishgoodssku */

$this->title = $model->itemid;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wishgoodsskus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wishgoodssku-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->itemid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->itemid], [
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
            'itemid',
            'pid',
            'sid',
            'sku',
            'pSKU',
            'color',
            'size',
            'inventory',
            'price',
            'shipping',
            'msrp',
            'shipping_time',
            'linkurl:url',
            'goodsskuid',
        ],
    ]) ?>

</div>
