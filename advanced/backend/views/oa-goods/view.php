<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoods */

$this->title = $model->devNum;
$this->params['breadcrumbs'][] = ['label' => '产品推荐', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-goods-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'img',
            'cate',
            'subCate',
            'vendor1',
            'vendor2',
            'vendor3',
            'origin1',
            'origin2',
            'origin3',
//            'devNum',
//            'developer',
//            'introducer',
//            'devStatus',
//            'checkStatus',
//            'createDate',
//            'updateDate',
            'salePrice',
            'hopeWeight',
            'hopeRate',
            'hopeSale',
            'hopeMonthProfit',
        ],
    ]) ?>

</div>
