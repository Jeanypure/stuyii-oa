<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\OaTemplatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Oa Templates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-templates-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Oa Templates', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nid',
            'goodsid',
            'location',
            'country',
            'postCode',
            // 'prepareDay',
            // 'site',
            // 'listedCate',
            // 'listedSubcate',
            // 'title',
            // 'subTitle',
            // 'description:ntext',
            // 'quantity',
            // 'nowPrice',
            // 'UPC',
            // 'EAN',
            // 'Brand',
            // 'MPN',
            // 'Color',
            // 'Type',
            // 'Material',
            // 'IntendedUse',
            // 'unit',
            // 'bundleListing',
            // 'shape',
            // 'features',
            // 'regionManufacture',
            // 'reserveField',
            // 'InshippingMethod1',
            // 'InFirstCost1',
            // 'InSuccessorCost1',
            // 'InshippingMethod2',
            // 'InFirstCost2',
            // 'InSuccessorCost2',
            // 'OutshippingMethod1',
            // 'OutFirstCost1',
            // 'OutSuccessorCost1',
            // 'OutShiptoCountry1',
            // 'OutshippingMethod2',
            // 'OutFirstCost2',
            // 'OutSuccessorCost2',
            // 'OutShiptoCountry2',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
