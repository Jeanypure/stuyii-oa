<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Goodssku */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Goodssku',
]) . $model->sid;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Goodsskus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sid, 'url' => ['view', 'id' => $model->sid]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="goodssku-update">

    <h1><?php echo  Html::encode($this->title) ?></h1>

    <?php echo  $this->render('_form', ['model' => $model,]) ?>


</div>
