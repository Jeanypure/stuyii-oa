<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OaEbayPaypal */

//$this->title = 'Update Oa Ebay Paypal: ' . $model->nid;
//$this->params['breadcrumbs'][] = ['label' => 'Oa Ebay Paypals', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->nid, 'url' => ['view', 'id' => $model->nid]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="oa-ebay-paypal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
