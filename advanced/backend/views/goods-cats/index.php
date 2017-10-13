<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\GoodsCatsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Goods Cats');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-cats-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Goods Cats'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'NID',
            'CategoryLevel',
            'CategoryName',
            'CategoryParentID',
            'CategoryParentName',
            // 'CategoryOrder',
            // 'CategoryCode',
            // 'GoodsCount',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
