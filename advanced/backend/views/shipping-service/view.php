<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\OaShippingService */

//$this->title = $model->nid;
//$this->params['breadcrumbs'][] = ['label' => 'Oa Shipping Services', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-shipping-service-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nid',
            'servicesName',
            'type',
            'siteId',
            'ibayShipping',
        ],
    ]) ?>

</div>
