<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\OaGoods */

$this->title = 'Create Oa Goods';
$this->params['breadcrumbs'][] = ['label' => 'Oa Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-goods-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
