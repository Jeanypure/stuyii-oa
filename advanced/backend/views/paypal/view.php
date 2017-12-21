<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\OaEbayPaypal */

//$this->title = $model->nid;
//$this->params['breadcrumbs'][] = ['label' => 'Oa Ebay Paypals', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-ebay-paypal-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'paypalName',
        ],
    ]) ?>

</div>
