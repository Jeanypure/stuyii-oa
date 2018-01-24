<?php
use kartik\daterange\DateRangePicker;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
?>
<?php
$form = ActiveForm::begin(['action' => ['cat-perform/cat'],'method'=>'post',]);
// DateRangePicker with ActiveForm and model. Check the `required` model validation for
// the attribute. This also features configuration of Bootstrap input group addon.

/*echo Select2::widget([
    'name' => 'type',
    'value' => '交易时间',
    'data' => ['0'=>'交易时间','1'=>'发货时间'],
    'options' => ['multiple' => false,'class'=>'form-group col-lg-1', 'placeholder' => '交易类型','maximumSelectionSize' => 1,]
]);*/

// Normal select with ActiveForm & model
echo $form->field($model, 'type')->widget(Select2::classname(), [
    'data' =>  ['0'=>'交易时间','1'=>'发货时间'],
    'language' => 'Zn',
    'options' => ['class'=>'form-group col-lg-1','placeholder' => '交易类型',],
    'pluginOptions' => [
        'allowClear' => true,

    ],
])->label(false);
echo $form->field($model, 'order_range', [
            'addon'=>['prepend'=>['content'=>'<i class="glyphicon glyphicon-calendar"></i>']],
            'options'=>['class'=>'drp-container form-group col-lg-3']
             ])->widget(DateRangePicker::classname(), [
            'useWithAddon'=>true
            ])->label("<span style = 'color:red'>*时间必填</span>");
echo $form->field($model, 'create_range', [
            'addon'=>['prepend'=>['content'=>'<i class="glyphicon glyphicon-calendar"></i>']],
            'options'=>['class'=>'drp-container form-group col-lg-3']
             ])->widget(DateRangePicker::classname(), [
            'useWithAddon'=>true
            ])->label('创建时间');
 echo Html::submitButton(
     '<i class="glyphicon glyphicon-hand-up"></i> 确定',
     ['class'=>'btn btn-primary']
 );
    ActiveForm::end();
?>

