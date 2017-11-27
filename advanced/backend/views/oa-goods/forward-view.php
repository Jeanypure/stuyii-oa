<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoods */

$this->title = $model->devNum;
$this->params['breadcrumbs'][] = ['label' => '产品推荐', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="oa-goods-view">
    <div>
        <?= Html::img($model->img,['width'=>100,'height'=>100])?>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            [
                'attribute' => 'img',
                'format' => 'raw',
                'value' => Html::a("<a target='_blank' href=$model->img>$model->img</a>",$model->img),
            ],
            'cate',
            'subCate',
            [
                'attribute' => 'vendor1',
                'format' => 'raw',

                'value' => function($model){
                    $text = $model->vendor1;
                    if (strlen($text)>100){
                        $standard_text = substr($text,0,99) . '...';
                    }
                    else{
                        $standard_text = $text;
                    }
                    return Html::a("<a target='_blank' href=$text>$standard_text</a>",$text);

                }


            ],
            [
                'attribute' => 'vendor2',
                'format' => 'raw',

                'value' => function($model){
                    $text = $model->vendor2;
                    if (strlen($text)>100){
                        $standard_text = substr($text,0,99) . '...';
                    }
                    else{
                        $standard_text = $text;
                    }
                    return Html::a("<a target='_blank' href=$text>$standard_text</a>",$text);

                }


            ],
            [
                'attribute' => 'vendor3',
                'format' => 'raw',

                'value' => function($model){
                    $text = $model->vendor3;
                    if (strlen($text)>80){
                        $standard_text = substr($text,0,50) . '...';
                    }
                    else{
                        $standard_text = $text;
                    }
                    return "<a target='_blank'  href={$text}>{$standard_text}</a>";
                }
            ],
            [
                'attribute' => 'origin1',
                'format' => 'raw',

                'value' => function($model){
                    $text = $model->origin1;
                    if (strlen($text)>100){
                        $standard_text = substr($text,0,99) . '...';
                    }
                    else{
                        $standard_text = $text;
                    }
                    return "<a target='_blank'  href={$text}>{$standard_text}</a>";

                }


            ],
            [
                'attribute' => 'origin2',
                'format' => 'raw',
                'value' => function($model){
                    $text = $model->origin2;
                    if (strlen($text)>100){
                        $standard_text = substr($text,0,99) . '...';
                    }
                    else{
                        $standard_text = $text;
                    }
                    return Html::a("<a target='_blank' href=$text>$standard_text</a>",$text);

                }

            ],
            [
                'attribute' => 'origin3',
                'format' => 'raw',

                'value' => function($model){
                    $text = $model->origin3;
                    if (strlen($text)>100){
                        $standard_text = substr($text,0,99).'...';
                    }
                    else{
                        $standard_text = $text;
                    }
                    return "<a target='_blank'  href={$text}>{$standard_text}</a>";

                }


            ],



            'devNum',
            'developer',
            'introducer',
            'devStatus',
            'checkStatus',
            'createDate',
            'updateDate',
            'salePrice',
            'hopeWeight',
            'hopeRate',
            'hopeSale',
            'hopeMonthProfit',
        ],
    ]) ?>

</div>