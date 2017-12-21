<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EbayPaypalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Oa Ebay Paypals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-ebay-paypal-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Oa Ebay Paypal', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nid',
            'ebayName',
            'palpayName',
            'mapType',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
