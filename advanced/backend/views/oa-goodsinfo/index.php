<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use kartik\grid\GridView;
//use yii\helpers\Helper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OaGoodsinfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '属性信息';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="oa-goodsinfo-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <p>
        <?= Html::a('创建产品信息', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([

        'dataProvider'=> $dataProvider,
        'filterModel' => $searchModel,
        'showPageSummary'=>true,
        'pjax'=>true,
        'striped'=>true,
//        'responsive'=>true,
        'hover'=>true,
        'panel'=>['type'=>'primary', 'heading'=>'Grid Grouping Example'],


        'columns' => [
            ['class'=>'kartik\grid\SerialColumn'],

//            'pid',
        [
            'attribute'=>'IsLiquid',
            'width'=>'310px',
            'value'=>function ($model, $key, $index, $widget) {
                return $model->IsLiquid;
            },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(\backend\models\OaGoodsinfo::find()->orderBy('pid')->asArray()->all(), 'pid', 'IsLiquid'),
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'是否是液体'],
            'group'=>true,  // enable grouping
        ],
            'IsPowder',
            'isMagnetism',
            'IsCharged',
            'SupplierID',

            [
             'attribute'=> 'description',
             'value'=> function($data){
                return "<a href=\"$data[description]\" >$data[description]</a>";
             },
             'headerOptions'=> ['width'=> '1'],
             'format' => 'raw',
             ],

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' =>'{view} {update} {delete} {active}',
                'buttons' => [
                    'active' => function ($url, $model, $key) {
                        $options = [
                            'title' => '审核',
                            'aria-label' => '审核',
                            'data-confirm' => '你确定通过这条审核吗?',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-check"></span>', $url, $options);
                    }
                ],


            ],
        ],




    ]); ?>
</div>


