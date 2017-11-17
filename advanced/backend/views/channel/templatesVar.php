<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-11-16
 * Time: 11:32
 */
use kartik\widgets\ActiveForm;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\helpers\Html;
?>

<div class="">
        <?php
        $varForm = ActiveForm::begin(['id'=>'var-form','method'=>'post',]);
        echo TabularForm::widget([
            'dataProvider' => $templatesVar,
            'id' => 'var-table',
            'form' => $varForm,
            'actionColumn' =>
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{delete}',
                ],
            'attributes' =>
                [
                    'sku'=>
                        [
                            'label'=>'SKU', 'type'=>TabularForm::INPUT_TEXT,
                            'options'=>['class'=>'sku'],
                        ],
                    'quantity'=>
                        [
                            'type'=>TabularForm::INPUT_TEXT,
                            'options'=>['class'=>'quantity'],
                        ],
                    'retailPrice'=>
                        [
                            'type'=>TabularForm::INPUT_TEXT,
                            'options'=>['class'=>'retailPrice'],
                        ],
                    'imageUrl'=>
                        [
                            'type'=>TabularForm::INPUT_RAW,
                            'options'=>
                                [
                                    'class'=>'imageUrl',

                                ],
                            'value'=>function($data){return "<img weight='50' height='50' src='".$data->imageUrl."'>";}
                        ],

                    'color'=>
                        [
                            'type'=>TabularForm::INPUT_TEXT,
                            'options'=>['class'=>'color'],
                        ],
                    'UPC'=>
                        [
                            'type'=>TabularForm::INPUT_TEXT,
                            'options'=>['class'=>'UPC','value' => 'Does not apply'],

                        ],
                    'EAN'=>
                        [
                            'type'=>TabularForm::INPUT_TEXT,
                            'options'=>['class'=>'EAN','value' => 'Does not apply'],

                        ],
                ],
            'gridSettings'=>[
            'panel'=>[
                'heading'=>'<h3 class="panel-title">多属性设置</h3>',
                'type'=>GridView::TYPE_PRIMARY,
                'after'=>
                    Html::input('text','rowNum','',['class' => 'x-row','placeholder'=>'行数']).' '.
                    Html::button('新增行', ['id'=>'add-row','type'=>'button', 'class'=>'btn kv-batch-create']) . ' ' .
                    Html::input('text','number','',['class' => 'number-replace','placeholder'=>'数量']).' '.
                    Html::button('数量确定', ['id'=>'number','type'=>'button','class'=>'btn']).' '.
                    Html::input('text','RetailPrice','',['class' => 'RetailPrice-replace','placeholder'=>'零售价$']).' '.
                    Html::button('价格确定', ['id'=>'RetailPrice-set','type'=>'button','class'=>'btn']).''.
                    Html::input('text','EAN','',['class' => 'ean-replace','placeholder'=>'Does not apply']).' '.
                    Html::button('EAN确定', ['id'=>'ean-set','type'=>'button','class'=>'btn']).' '.
                    Html::button('保存', ['id'=>'save-only','type'=>'button','class'=>'btn btn-info']).' '.
                    Html::button('删除行', ['id'=>'delete-row','type'=>'button', 'class'=>'btn btn-danger kv-batch-delete'])
            ]
        ]

        ]);

        ActiveForm::end();
        ?>
</div>

<?php
$js = <<< JS
//新增加行
$('#add-row').click(function() {
      
});

JS;

$this->registerJs($js);
?>
<style>
    .panel-primary > .panel-heading {
        color: black;
        background-color: whitesmoke;
        border-color: transparent;
    }
    .panel-primary {
        border-color: transparent;
    }

    .panel-footer {
        padding: 10px 15px;
        background-color: white;
        border-top: 1px solid #ddd;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
    }
</style>