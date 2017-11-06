<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoodsinfo */

$this->title = $model->GoodsCode.'基本信息';
$this->params['breadcrumbs'][] = ['label' => '属性信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <?= Html::img($model->picUrl,['width'=>100,'height'=>100])?>
</div>
<div class="oa-goodsinfo-view">
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'picUrl',
                'format' => 'raw',
                'label'=>'参考图片',
                'value' => Html::a("<a target='_blank' href=$model->picUrl>点我查看</a>",$model->picUrl),

            ],
            'GoodsCode',
            'GoodsName',
            'Purchaser',
            'developer',
            'possessMan1',
            'SupplierName',
            'AliasCnName',
            'AliasEnName',
            'PackName',
            [
                'attribute' => 'description',
                'format' => 'raw',
            ],
            'Season',
            'StoreName',
            'IsLiquid',
            'IsPowder',
            'isMagnetism',
            'IsCharged',

            ],

    ]) ?>

    <?php
        echo DetailView::widget([
            'model'=>$goodsitems,
            'attributes'=>[
                'cate',
                'subCate',
                    [
                        'attribute' => 'vendor1',
                        'format' => 'raw',
                        'label'=>'供应商链接1',
                        'value' => Html::a("<a target='_blank' href=$goodsitems->vendor1>$goodsitems->vendor1</a>",$goodsitems->vendor1),

                    ],[
                        'attribute' => 'vendor2',
                        'format' => 'raw',
                        'label'=>'供应商链接2',
                        'value' => Html::a("<a target='_blank' href=$goodsitems->vendor2>$goodsitems->vendor2</a>",$goodsitems->vendor2),

                    ],[
                        'attribute' => 'vendor3',
                        'format' => 'raw',
                        'label'=>'供应商链接3',
                        'value' => Html::a("<a target='_blank' href=$goodsitems->vendor3>$goodsitems->vendor3</a>",$goodsitems->vendor3),

                    ],
                    [
                        'attribute' => 'origin1',
                        'format' => 'raw',
                        'label'=>'平台链接1',
                        'value' => Html::a("<a target='_blank' href=$goodsitems->origin1>$goodsitems->origin1</a>",$goodsitems->origin1),

                    ],[
                        'attribute' => 'origin2',
                        'format' => 'raw',
                        'label'=>'平台链接2',
                        'value' => Html::a("<a target='_blank' href=$goodsitems->origin2>$goodsitems->origin2</a>",$goodsitems->origin1),

                    ],[
                        'attribute' => 'origin3',
                        'format' => 'raw',
                        'label'=>'平台链接3',
                        'value' => Html::a("<a target='_blank' href=$goodsitems->origin3>$goodsitems->origin3</a>",$goodsitems->origin1),

                    ],

            ],
        ])
        ?>

</div>
