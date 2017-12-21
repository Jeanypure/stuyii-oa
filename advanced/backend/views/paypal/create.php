<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\OaEbayPaypal */

//$this->title = 'Create Oa Ebay Paypal';
//$this->params['breadcrumbs'][] = ['label' => 'Oa Ebay Paypals', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-ebay-paypal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
