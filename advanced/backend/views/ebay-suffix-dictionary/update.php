<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\WishSuffixDictionary */

//$this->title = '编辑Ebay账号字典: ' . $model->nid;
//$this->params['breadcrumbs'][] = ['label' => 'Wish Suffix Dictionaries', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->nid, 'url' => ['view', 'id' => $model->nid]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wish-suffix-dictionary-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
