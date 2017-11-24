<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Wishgoodssku */

$this->title = Yii::t('app', 'Create Wishgoodssku');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wishgoodsskus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wishgoodssku-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
