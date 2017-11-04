<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ChannelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '平台信息');
$this->params['breadcrumbs'][] = '平台信息';
?>
<div class="channel-index">

<!--    <h1>--><?php //echo  Html::encode($this->title) ?><!--</h1>-->

    <p>
        <?= Html::a(Yii::t('app', '添加平台'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],

            'NID',
            'CategoryID',
            'DictionaryName',
            'FitCode',
            'Used',
            // 'Memo',


        ],
    ]); ?>
</div>
