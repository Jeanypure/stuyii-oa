<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\WishSuffixDictionary */

//$this->title = $model->nid;
//$this->params['breadcrumbs'][] = ['label' => 'Ebay账号字典', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wish-suffix-dictionary-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ebayName',
            'ebaySuffix',
            'nameCode',
            'mainImg',
            'highEbayPaypal',
            'highEbayPaypal'
        ],
    ]) ?>
