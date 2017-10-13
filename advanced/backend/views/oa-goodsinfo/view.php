<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoodsinfo */

$this->title = $model->pid;
$this->params['breadcrumbs'][] = ['label' => '属性信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-goodsinfo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->pid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->pid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'pid',
            'picUrl:url',
            ['label'=>'picUrl','value'=>$model->picUrl,],
            'GoodsName',
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
//        'template' => '<tr><th>{label}</th><td><img src="{value}" width="50" height="50"/></td></tr>',
//        'options' => ['class' => 'table table-striped table-bordered detail-view'],
//            'formatter'=>'raw'
    ]) ?>

</div>
