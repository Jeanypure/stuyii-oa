<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Goodssku */

$this->title = Yii::t('app', 'Create Goodssku');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Goodsskus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goodssku-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>





