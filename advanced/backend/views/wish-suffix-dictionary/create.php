<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\WishSuffixDictionary */

$this->title = 'Create Wish Suffix Dictionary';
$this->params['breadcrumbs'][] = ['label' => 'Wish Suffix Dictionaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wish-suffix-dictionary-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
