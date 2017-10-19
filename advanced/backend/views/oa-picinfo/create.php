<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
//use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model backend\models\OaGoodsmodel */

$this->title = '添加产品信息';
$this->params['breadcrumbs'][] = ['label' => 'Oa Goodsmodels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oa-goodsmodel-create">

    <h1><?php //echo  Html::encode($this->title) ?></h1>

    <?php //echo  $this->render('_form', ['model' => $model,]) ?>
    <?php $form = ActiveForm::begin();?>
    <?php
    $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
    echo FormGrid::widget([ // continuation fields to row above without labels
        'model'=> $model,
        'form'=>$form,
        'rows' =>[
            [
                'contentBefore'=>'<legend class="text-model"><small>基本信息</small></legend>',
                'attributes' =>[
                    'GoodsName' =>[
                        'label'=>'商品名称',
                        'items'=>[ 1=>'Group 2'],
                        'type'=>Form::INPUT_TEXT,
                    ],
                    'SupplierName' =>[
                        'label'=>'供应商名称',
                        'type'=>Form::INPUT_TEXT,
                    ],
                ],
            ],


            [
                'attributes' =>[
                    'AliasCnName' =>[
                        'label'=>'中文申报名',
                        'items'=>[ 1=>'Group 2'],
                        'type'=>Form::INPUT_TEXT,
                    ],
                    'AliasEnName' =>[
                        'label'=>'英文申报名',
                        'items'=>[ 1=>'Group 2'],
                        'type'=>Form::INPUT_TEXT,
                    ],
                ],
            ],
            [
                'attributes' =>[
                    'PackName' =>[
                        'label'=>'规格',
                        'items'=>[''=>NUll,'A01'=>'A01','A02'=>'A02','A03'=>'A03','A04'=>'A04','B01'=>'B01','B02'=>'B02','stamp'=>'stamp',],
                        'type'=>Form::INPUT_DROPDOWN_LIST,

                    ],
                ],
            ],[
                'attributes' =>[
                    'description' =>[
                        'label'=>'描述',
                        'items'=>[ 1=>'Group 2'],
                        'type'=>Form::INPUT_TEXTAREA,
                        'options'=>['rows'=>'6']
                    ],
                ],
            ],
            [
                'attributes'=>[
                    'IsLiquid'=>['label'=>'是否液体','items'=>[ 1=>'Group 2'],'type'=>Form::INPUT_CHECKBOX],
                    'IsPowder'=>['label'=>'是否粉末','items'=>[ 1=>'Group 2'],'type'=>Form::INPUT_CHECKBOX],
                    'isMagnetism'=>['label'=>'是否带磁', 'items'=>[ 1=>'Group 2'], 'type'=>Form::INPUT_CHECKBOX],
                    'IsCharged'=>['label'=>'是否带电', 'items'=>[0=>'Group 1'], 'type'=>Form::INPUT_CHECKBOX],
                ],
            ],
            [
                'attributes' =>[
                    'StoreName' =>[
                        'label'=>'仓库',
                        'items'=>$result,
                        'type'=>Form::INPUT_DROPDOWN_LIST,
                    ],
                    'Season' =>[
                        'label'=>'季节',
                        'items'=>[ ''=>'','春季'=>'春季','夏季'=>'夏季','秋季'=>'秋季','冬季'=>'冬季'],
                        'type'=>Form::INPUT_DROPDOWN_LIST,
                    ],

                    'DictionaryName' =>[
                        'label'=>'禁售平台',
                        'items'=>$lock,
                        'type'=>Form::INPUT_DROPDOWN_LIST,
                    ],

                ],
            ],
            



        ],

    ]);?>

    <?php
    echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
