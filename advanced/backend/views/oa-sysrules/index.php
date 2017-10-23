<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OaSysRulesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Oa Sys Rules');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-sys-rules-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Oa Sys Rules'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nid',
            'ruleName',
            'ruleKey',
            'ruleValue',
            'ruleType',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
