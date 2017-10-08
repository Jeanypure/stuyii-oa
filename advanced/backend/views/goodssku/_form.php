<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;

/* @var $this yii\web\View */
/* @var $model backend\models\Goodssku */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="goodssku-form">

    <?php $form = ActiveForm::begin([

        'id' => 'add-form',
        'enableAjaxValidation' => true,
        'validationUrl' =>['goodssku/validate'],     //数据异步校验

    ]);?>

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

<?php
$js = <<<JS
    //此处点击按钮提交数据的jquery
    $('.add-sku-btn').click(function () {
    $.ajax({
    url: "goodssku/create",
    type: "POST",
    dataType: "json",
    data: $('#add-form').serialize(),
    success: function(Data) {
        console.log(Data);
         alert(Data);
    // if(Data.status)
    // alert('保存成功');
    // else
    // alert('保存失败')
     },
    error: function() {
    alert('网络错误！'); 
    }
    });
    return false;
    });
JS;
?>






