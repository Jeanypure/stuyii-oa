<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\WishSuffixDictionarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wish Suffix Dictionaries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wish-suffix-dictionary-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Wish Suffix Dictionary', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],

            'IbaySuffix',
            'Suffix',
            'Rate',
            'MainImg',

        ],
    ]); ?>
<?php Pjax::end(); ?></div>
