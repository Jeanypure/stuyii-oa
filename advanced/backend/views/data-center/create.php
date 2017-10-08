<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\DataCenter */

$this->title = Yii::t('app', 'Create Data Center');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Data Centers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-center-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
