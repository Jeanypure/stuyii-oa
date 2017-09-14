<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OaGoodsinfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Oa Goodsinfos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-goodsinfo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Oa Goodsinfo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'pid',
            'IsLiquid',
            'IsPowder',
            'isMagnetism',
            'IsCharged',
            // 'SupplierID',
            // 'description',
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
