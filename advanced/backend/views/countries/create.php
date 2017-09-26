<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Countries */

$this->title = Yii::t('app', 'Create Countries');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Countries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="countries-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
