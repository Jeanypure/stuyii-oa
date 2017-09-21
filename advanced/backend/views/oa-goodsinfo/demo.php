<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $skuinfo backend\models\Goodssku */

$this->title = $skuinfo->sid;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Goodsskus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goodssku-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $skuinfo->sid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $skuinfo->sid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $skuinfo,
        'attributes' => [
            'sid',
            'pid',
            'sku',
            'property1',
            'property2',
            'property3',
            'CostPrice',
            'Weight',
            'RetailPrice',
            'memo1',
            'memo2',
            'memo3',
            'memo4',
        ],
    ]) ?>

</div>
