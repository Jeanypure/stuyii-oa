<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-18
 * Time: 11:56
 */
//use yii\bootstrap\Tabs;
//use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use yii\grid\GridView;

use yii\bootstrap\Modal;
use yii\helpers\Url;
$this->title = '更新产品: ' . $info->pid;
$this->params['breadcrumbs'][] = ['label' => '更新产品id', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $info->pid, 'url' => ['view', 'id' => $info->pid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?php
//$items[] = [
//    'label' => '更新产品',
//    'content' => 122,
//    'active' => true,
//];
//
//$items[] = [
//    'label' => '更新SKU',
//    'content' => 666
//
//];
//echo Tabs::widget([
//    'items' => $items,
//]);
//?>
    <?php $form = ActiveForm::begin();?>
    <?php
    $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
        echo FormGrid::widget([ // continuation fields to row above without labels
            'model'=> $info,
            'form'=>$form,
//            'autoGenerateColumns'=>true,
            'rows' =>[
                [
                    'contentBefore'=>'<legend class="text-info"><small>基本信息</small></legend>',
                    'attributes'=>[
                        'IsLiquid'=>['label'=>'是否液体','items'=>[ 1=>'Group 2'],'type'=>Form::INPUT_CHECKBOX],
                        'IsPowder'=>['label'=>'是否粉末','items'=>[ 1=>'Group 2'],'type'=>Form::INPUT_CHECKBOX],
                        'isMagnetism'=>['label'=>'是否带磁', 'items'=>[ 1=>'Group 2'], 'type'=>Form::INPUT_CHECKBOX],
                        'IsCharged'=>['label'=>'是否带电', 'items'=>[0=>'Group 1'], 'type'=>Form::INPUT_CHECKBOX],
                    ],
                ],
                [
                    'attributes' =>[
                        'description' =>[
                                        'label'=>'描述',
                                        'items'=>[ 1=>'Group 2'],
                                        'type'=>Form::INPUT_TEXTAREA,
                                         'options'=>['rows'=>'6']
                        ],
                    ],
                ],
            ],

        ]);
        foreach($skuinfo as $index=>$sku){
//            echo FormGrid::widget([
//                'model'=> $skuinfo,
//                'form'=>$sku,
//                'rows' =>[
//                    'attributes' =>[
//                        'sku' =>['label'=>'SKU','type'=>Form::INPUT_TEXT ],
//                        'property1' =>['label'=>'款式1','type'=>Form::INPUT_TEXT ],
//                        'property2' =>['label'=>'款式2','type'=>Form::INPUT_TEXT ],
//                        'CostPrice' =>['label'=>'成本价','type'=>Form::INPUT_TEXT ],
//                    ],
//
//                ],
//            ]);
            echo Html::encode($sku->sku).':'.$form->field($sku,"property1");

        }

     ?>


    <div class="form-group">
        <?= Html::submitButton($info->isNewRecord ? 'Create' : 'Update', ['class' => $info->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>






<?php
echo Html::a('编辑SKU信息', '#', [
    'id' => 'create',
    'data-toggle' => 'modal',
    'data-target' => '#create-modal',//关联下面Model的id属性
    'class' => 'btn btn-success',
]);
?>

<?php
Modal::begin([
    'id' => 'create-modal',
    'header' => '<h4 class="modal-title">弹框</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
    'size'=>Modal::SIZE_LARGE,
    'options'=>[
        'data-backdrop'=>'static',//点击空白处不关闭弹窗
        'data-keyboard'=>false,
    ],
]);
$requestUrl = Url::toRoute('/goodssku/demo');//弹窗的html内容，下面的js会调用获得该页面的Html内容，直接填充在弹框中
$js = <<<JS
    $.get('{$requestUrl}', {},
        function (data) {        
         $('.modal-body').html(data);
        }  
    );

JS;
$this->registerJs($js);
Modal::end();
?>











