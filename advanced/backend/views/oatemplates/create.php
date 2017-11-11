<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\OaTemplates */

$this->title = 'Create Oa Templates';
$this->params['breadcrumbs'][] = ['label' => 'Oa Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-templates-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
