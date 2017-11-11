<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\OaTemplates */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Oa Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-templates-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->nid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->nid], [
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
            'goodsid',
            'location',
            'country',
            'postCode',
            'prepareDay',
            'site',
            'listedCate',
            'listedSubcate',
            'title',
            'subTitle',
            'description:ntext',
            'quantity',
            'nowPrice',
            'UPC',
            'EAN',
            'Brand',
            'MPN',
            'Color',
            'Type',
            'Material',
            'IntendedUse',
            'unit',
            'bundleListing',
            'shape',
            'features',
            'regionManufacture',
            'reserveField',
            'InshippingMethod1',
            'InFirstCost1',
            'InSuccessorCost1',
            'InshippingMethod2',
            'InFirstCost2',
            'InSuccessorCost2',
            'OutshippingMethod1',
            'OutFirstCost1',
            'OutSuccessorCost1',
            'OutShiptoCountry1',
            'OutshippingMethod2',
            'OutFirstCost2',
            'OutSuccessorCost2',
            'OutShiptoCountry2',
        ],
    ]) ?>

</div>
