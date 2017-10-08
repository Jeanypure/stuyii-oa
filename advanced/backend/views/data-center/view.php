<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\DataCenter */

$this->title = $model->NID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Data Centers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-center-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->NID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->NID], [
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
            'NID',
            'GoodsCategoryID',
            'CategoryCode',
            'GoodsCode',
            'GoodsName',
            'ShopTitle',
            'SKU',
            'BarCode',
            'FitCode',
            'MultiStyle',
            'Material',
            'Class',
            'Model',
            'Unit',
            'Style',
            'Brand',
            'LocationID',
            'Quantity',
            'SalePrice',
            'CostPrice',
            'AliasCnName',
            'AliasEnName',
            'Weight',
            'DeclaredValue',
            'OriginCountry',
            'OriginCountryCode',
            'ExpressID',
            'Used',
            'BmpFileName',
            'BmpUrl:url',
            'MaxNum',
            'MinNum',
            'GoodsCount',
            'SupplierID',
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
            'StockMinAmount',
            'MinPrice',
            'HSCODE',
            'ViewUser',
            'InLong',
            'InWide',
            'InHigh',
            'InGrossweight',
            'InNetweight',
            'OutLong',
            'OutWide',
            'OutHigh',
            'OutGrossweight',
            'OutNetweight',
            'ShopCarryCost',
            'ExchangeRate',
            'WebCost',
            'PackWeight',
            'LogisticsCost',
            'GrossRate',
            'CalSalePrice',
            'CalYunFei',
            'CalSaleAllPrice',
            'PackMsg',
            'ItemUrl:url',
            'IsCharged',
            'DelInFile',
            'Season',
            'IsPowder',
            'IsLiquid',
            'possessMan1',
            'possessMan2',
            'LinkUrl4:url',
            'LinkUrl5:url',
            'LinkUrl6:url',
            'isMagnetism',
            'NoSalesDate',
            'NotUsedReason',
        ],
    ]) ?>

</div>
