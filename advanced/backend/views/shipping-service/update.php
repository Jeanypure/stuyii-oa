<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OaShippingService */

//$this->title = 'Update Oa Shipping Service: ' . $model->nid;
//$this->params['breadcrumbs'][] = ['label' => 'Oa Shipping Services', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->nid, 'url' => ['view', 'id' => $model->nid]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="oa-shipping-service-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
