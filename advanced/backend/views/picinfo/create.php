<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Picinfo */

$this->title = Yii::t('app', 'Create Picinfo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Picinfos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="picinfo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
