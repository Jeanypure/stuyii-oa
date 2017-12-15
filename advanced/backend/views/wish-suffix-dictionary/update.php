<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\WishSuffixDictionary */

$this->title = 'Update Wish Suffix Dictionary: ' . $model->NID;
$this->params['breadcrumbs'][] = ['label' => 'Wish Suffix Dictionaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NID, 'url' => ['view', 'id' => $model->NID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wish-suffix-dictionary-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
