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
        'pjax'=>true,
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
                'attribute'=> 'cate',
                'value'=>'oa_goods.cate'
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
                'value' => function ($model) {
                    return substr(strval($model->devDatetime),0,10);
                },
            ],
            'completeStatus',
            'DictionaryName',
            'isVar',

        ],
    ]); ?>
</div>
