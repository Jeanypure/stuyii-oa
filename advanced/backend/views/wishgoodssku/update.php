<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Wishgoodssku */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Wishgoodssku',
]) . $model->itemid;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wishgoodsskus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->itemid, 'url' => ['view', 'id' => $model->itemid]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="wishgoodssku-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
