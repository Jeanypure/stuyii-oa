<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;


/* @var $this yii\web\View */
/* @var $model backend\models\Goodssku */

//$this->title = Yii::t('app', 'Create Goodssku');
$this->title = '产品编码：'.$pid[0];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Goodsskus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goodssku-create">

    <h1><?= Html::encode($this->title) ?></h1>


    <!-- Render create form -->
    <?php //echo  $this->render('_form', ['model' => $model, ]) ?>
    <?php $form = ActiveForm::begin([
        'action' => ['create'], //指定action
    ]); ?>
    <?php
    $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
    echo FormGrid::widget([ // continuation fields to row above without labels
        'model'=> $model,
        'form'=>$form,
        'rows' =>[
            [
                'contentBefore'=>'<legend class="text-model"><small>SKU基本信息</small></legend>',
                'attributes' =>[
                    'pid' =>[
                        'label'=>'商品ID',
                        'type'=>Form::INPUT_TEXT,
                    ],
                    'sku' =>[
                        'label'=>'SKU',
                        'type'=>Form::INPUT_TEXT,
                    ],
                ],
            ],


            [
                'attributes' =>[
                    'property1' =>[
                        'label'=>'款式1',
                        'type'=>Form::INPUT_TEXT,
                    ],
                    'property2' =>[
                        'label'=>'款式2',
                        'type'=>Form::INPUT_TEXT,
                    ],
                    'property3' =>[
                        'label'=>'款式3',
                        'type'=>Form::INPUT_TEXT,
                    ],
                ],
            ],
            [
                'attributes' =>[
                    'CostPrice' =>[
                        'label'=>'商品成本',
                        'type'=>Form::INPUT_TEXT,

                    ],
                    'Weight' =>[
                        'label'=>'重量',
                        'type'=>Form::INPUT_TEXT,

                    ],
                    'RetailPrice' =>[
                        'label'=>'零售价格',
                        'type'=>Form::INPUT_TEXT,

                    ],
                ],
            ],[
                'attributes' =>[
                    'memo1' =>[
                        'label'=>'备注1',
                        'type'=>Form::INPUT_TEXT,

                    ],
                    'memo2' =>[
                        'label'=>'备注2',
                        'type'=>Form::INPUT_TEXT,

                    ],
                    'memo3' =>[
                        'label'=>'备注3',
                        'type'=>Form::INPUT_TEXT,

                    ],
                    'memo4' =>[
                        'label'=>'备注4',
                        'type'=>Form::INPUT_TEXT,

                    ],
                ],
            ],
        ],

    ]);?>

    <?php
    echo Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>

</div>








