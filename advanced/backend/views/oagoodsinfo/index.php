<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OaGoodsinfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Oa Goodsinfos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-goodsinfo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Oa Goodsinfo'), ['create'], ['class' => 'btn btn-success']) ?>
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
            // 'GoodsName',
            // 'AliasCnName',
            // 'AliasEnName',
            // 'PackName',
            // 'Season',
            // 'StoreID',
            // 'DictionaryName',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
