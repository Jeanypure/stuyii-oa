<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\OaShippingService */

//$this->title = 'Create Oa Shipping Service';
//$this->params['breadcrumbs'][] = ['label' => 'Oa Shipping Services', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-shipping-service-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
