<?php
/**
 * @desc PhpStorm.
 * @author: Administrator
 * @since: 2017-12-20 10:50
 */
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ChannelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '平台信息');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['class' => 'yii\grid\CheckboxColumn'],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update}',
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
        'GoodsCode',
        'GoodsName',
        [
            'attribute'=> 'cate',
            'value'=>'oa_goods.cate'
        ],
        [
            'attribute'=> 'subCate',
            'value'=>'oa_goods.subCate'
        ],

        'SupplierName',
        [
            'attribute'=> 'introducer',
            'value'=>'oa_goods.introducer',
            'label'=>'推荐人'
        ],
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
            'value' => function ($model) {
                return substr(strval($model->devDatetime),0,20);
            },
        ],
        'completeStatus',
        'DictionaryName',
        'isVar',

    ],
]); ?>
</div>
