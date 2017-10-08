<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DataCenterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Data Centers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-center-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Data Center'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'NID',
            'GoodsCategoryID',
            'CategoryCode',
            'GoodsCode',
            'GoodsName',
            // 'ShopTitle',
            // 'SKU',
            // 'BarCode',
            // 'FitCode',
            // 'MultiStyle',
            // 'Material',
            // 'Class',
            // 'Model',
            // 'Unit',
            // 'Style',
            // 'Brand',
            // 'LocationID',
            // 'Quantity',
            // 'SalePrice',
            // 'CostPrice',
            // 'AliasCnName',
            // 'AliasEnName',
            // 'Weight',
            // 'DeclaredValue',
            // 'OriginCountry',
            // 'OriginCountryCode',
            // 'ExpressID',
            // 'Used',
            // 'BmpFileName',
            // 'BmpUrl:url',
            // 'MaxNum',
            // 'MinNum',
            // 'GoodsCount',
            // 'SupplierID',
            // 'Notes',
            // 'SampleFlag',
            // 'SampleCount',
            // 'SampleMemo',
            // 'CreateDate',
            // 'GroupFlag',
            // 'SalerName',
            // 'SellCount',
            // 'SellDays',
            // 'PackFee',
            // 'PackName',
            // 'GoodsStatus',
            // 'DevDate',
            // 'SalerName2',
            // 'BatchPrice',
            // 'MaxSalePrice',
            // 'RetailPrice',
            // 'MarketPrice',
            // 'PackageCount',
            // 'ChangeStatusTime',
            // 'StockDays',
            // 'StoreID',
            // 'Purchaser',
            // 'LinkUrl:url',
            // 'LinkUrl2:url',
            // 'LinkUrl3:url',
            // 'StockMinAmount',
            // 'MinPrice',
            // 'HSCODE',
            // 'ViewUser',
            // 'InLong',
            // 'InWide',
            // 'InHigh',
            // 'InGrossweight',
            // 'InNetweight',
            // 'OutLong',
            // 'OutWide',
            // 'OutHigh',
            // 'OutGrossweight',
            // 'OutNetweight',
            // 'ShopCarryCost',
            // 'ExchangeRate',
            // 'WebCost',
            // 'PackWeight',
            // 'LogisticsCost',
            // 'GrossRate',
            // 'CalSalePrice',
            // 'CalYunFei',
            // 'CalSaleAllPrice',
            // 'PackMsg',
            // 'ItemUrl:url',
            // 'IsCharged',
            // 'DelInFile',
            // 'Season',
            // 'IsPowder',
            // 'IsLiquid',
            // 'possessMan1',
            // 'possessMan2',
            // 'LinkUrl4:url',
            // 'LinkUrl5:url',
            // 'LinkUrl6:url',
            // 'isMagnetism',
            // 'NoSalesDate',
            // 'NotUsedReason',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
