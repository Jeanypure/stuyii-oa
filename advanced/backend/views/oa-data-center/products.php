<?php
/**
 * @desc show products list.
 * @author: turpure
 * @since: 2017-12-20 10:50
 */
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ChannelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '产品中心');
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
        [
            'class' => 'yii\grid\ActionColumn',
            'template' =>'{view}{update}'
        ],

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
        [
            'attribute' => 'GoodsCode',
            'format' => 'raw',
            'value' => function ($model) {
                if($model->stockUp) {
                    return '<strong style="color:red">'. $model->GoodsCode.'</strong>';
                }
                return $model->GoodsCode;
            }
        ],
        [
            'attribute' => 'stockUp',
            'width' => '150px',
            'format' => 'raw',
            'value' => function ($data) {
                $value = $data->stockUp?'是':'否';
                return "<span class='cell'>" . $value . "</span>";
            },
        ],
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
            'format' => 'raw',
            //'format' => ['date', "php:Y-m-d"],
            'value' => function ($model) {
                return "<span class='cell'>" . substr(strval($model->devDatetime), 0, 10) . "</span>";
            },
            'width' => '200px',
            'filterType' => GridView::FILTER_DATE_RANGE,
            'filterWidgetOptions' => [
                'pluginOptions' => [
                    'value' => Yii::$app->request->get('ChannelSearch')['devDatetime'],
                    'convertFormat' => true,
                    'useWithAddon' => true,
                    'format' => 'php:Y-m-d',
                    'todayHighlight' => true,
                    'locale'=>[
                        'format' => 'YYYY-MM-DD',
                        'separator'=>'/',
                        'applyLabel' => '确定',
                        'cancelLabel' => '取消',
                        'daysOfWeek'=>false,
                    ],
                    'opens'=>'left',
                    //起止时间的最大间隔
                    /*'dateLimit' =>[
                        'days' => 300
                    ]*/
                ]
            ]
        ],
        'completeStatus',
        'DictionaryName',
        'isVar',

    ],
]); ?>
</div>
