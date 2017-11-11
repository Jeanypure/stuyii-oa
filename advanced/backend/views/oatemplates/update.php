<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OaTemplates */

$this->title = 'Update Oa Templates: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Oa Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->nid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="oa-templates-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
