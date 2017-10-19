<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoodsinfo */

$this->title = $model->GoodsCode.'基本信息';
$this->params['breadcrumbs'][] = ['label' => '属性信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-goodsinfo-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?php //echo  Html::a('Update', ['update', 'id' => $model->pid], ['class' => 'btn btn-primary']) ?>
        <?php
//        echo Html::a('Delete', ['delete', 'id' => $model->pid], [
//            'class' => 'btn btn-danger',
//            'data' => [
//                'confirm' => 'Are you sure you want to delete this item?',
//                'method' => 'post',
//            ],
//        ])
        ?>
    </p>

        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'pid',
            ['label'=>'picUrl','value'=>$model->picUrl,],
            'GoodsName',
            'GoodsCode',
            'SupplierName',
            'AliasCnName',
            'AliasEnName',
            'PackName',
            'description',
            'Season',
            'StoreName',
            'IsLiquid',
            'IsPowder',
            'isMagnetism',
            'IsCharged',
            'DictionaryName',
            ],

    ]) ?>

</div>
