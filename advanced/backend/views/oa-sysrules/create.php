<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\OaSysRules */

$this->title = Yii::t('app', 'Create Oa Sys Rules');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Oa Sys Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-sys-rules-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
