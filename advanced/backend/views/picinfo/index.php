<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PicinfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '图片信息');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="picinfo-index">

    <h1><?php //echo  Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', '添加图片信息'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'sid',
//            'pid',
            'sku',
//            'property1',
//            'property2',
            // 'property3',
            // 'CostPrice',
            // 'Weight',
            // 'RetailPrice',
            // 'memo1',
            // 'memo2',
            // 'memo3',
            // 'memo4',
             'linkurl:url',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
