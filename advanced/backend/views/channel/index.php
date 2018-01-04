<?php
use yii\helpers\Html;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ChannelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '平台信息');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channel-index">
    <p>
        <?= Html::a(Yii::t('app', '标记已完善'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        //'pjax'=>true,
        'striped'=>true,
        'responsive'=>true,
        'hover'=>true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\ActionColumn'],

            [
                'attribute' => 'mainImage',
                'value' =>function($model,$key, $index, $widget) {
                    try{
                        $image = $model->oa_templates->mainPage;
                    }
                    catch (Exception $e){
                        $image = $model->picUrl;
                    }

                    return "<img src='{$image}' width='100' height='100'/>";
                },
                'label' => '主图',
                'format' => 'raw',
            ],
             'GoodsCode',
             'GoodsName',
            [
                'attribute' => 'cate',
                'value'=>'oa_goods.cate',
                'width' => '150px',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\models\GoodsCats::findAll(['CategoryParentID' => 0]),'CategoryName', 'CategoryName'),
                //'filter'=>ArrayHelper::map(\backend\models\OaGoodsinfo::find()->orderBy('pid')->asArray()->all(), 'pid', 'IsLiquid'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => '-请选择-'],
                //'group'=>true,  // enable grouping
            ],
            [
                'attribute'=> 'subCate',
                'value'=>'oa_goods.subCate'
            ],

             'SupplierName',
             'StoreName',
            [
                'attribute'=> 'introducer',
                'value'=>'oa_goods.introducer'
            ],
             'developer',
             'Purchaser',
             'possessMan1',
            [
                'attribute' => 'devDatetime',
                'label' => '开发时间',
                //'format' => ['date', "php:Y-m-d"],
                'value' => function ($model) {
                    return substr(strval($model->devDatetime),0,10);
                },
                'width' => '200px',
                //'headerOptions' => ['width' => '300px'],
                //'filterType' => GridView::FILTER_DATE,
                'filter' => \kartik\widgets\DatePicker::widget([
                    'name' => 'ChannelSearch[devDatetime]',
                    'value' => Yii::$app->request->get('ChannelSearch')['devDatetime'],
                    'convertFormat' => true,
                    'pluginOptions' => [
                        //'autoclose' => true,
                        'format' => 'php:Y-m-d',
                        'todayHighlight' => true,
                    ]
                ])
            ],
            'completeStatus',
            'DictionaryName',
            'isVar',

        ],
    ]); ?>
</div>
