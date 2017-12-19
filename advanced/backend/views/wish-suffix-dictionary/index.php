<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\WishSuffixDictionarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wish账号字典';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wish-suffix-dictionary-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- Render create form -->
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


    <?php Pjax::begin(['id' => 'suffix']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],
            'IbaySuffix',
            'ShortName'


        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
