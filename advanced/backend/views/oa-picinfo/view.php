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
                    'value' => Html::a("<a target='_blank' href=$model->picUrl>$model->picUrl</a>",$model->picUrl),

                ],
            'GoodsName',
            [
                'attribute' => 'GoodsCode',
                'format' => 'raw',
                'value' => function ($data) {
                    $value = $data->stockUp?'<strong style="color:red;">'.$data->GoodsCode.'</strong>':$data->GoodsCode;
                    return $value;
                },
            ],
            [
                'attribute' => 'stockUp',
                'format' => 'raw',
                'value' => function ($data) {
                    $value = $data->stockUp?'是':'否';
                    return $value;
                },
            ],
            'SupplierName',
            'AliasCnName',
            'AliasEnName',
            'PackName',
            'Season',
            'StoreName',
            'IsLiquid',
            'IsPowder',
            'isMagnetism',
            'IsCharged',
            ],

    ]) ?>

</div>
