<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\OaGoodsinfo */

$this->title = 'Create Oa Goodsinfo';
$this->params['breadcrumbs'][] = ['label' => 'Oa Goodsinfos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-goodsinfo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
