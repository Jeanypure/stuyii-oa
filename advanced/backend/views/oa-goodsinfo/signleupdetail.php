<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-18
 * Time: 11:56
 */

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\grid\GridView;
use kartik\widgets\Select2;

use kartik\builder\TabularForm;

use yii\bootstrap\Modal;
use yii\helpers\Url;
$this->title = '更新产品: ' . $info->GoodsName;
$this->params['breadcrumbs'][] = ['label' => '更新产品', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $info->GoodsName, 'url' => ['view', 'id' => $info->pid]];
$this->params['breadcrumbs'][] = '更新数据';



?>
<?php $form = ActiveForm::begin();?>
<?php
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
echo FormGrid::widget([ // continuation fields to row above without labels
    'model'=> $info,
    'form'=>$form,
    'rows' =>[
        [
            'contentBefore'=>'<legend class="text-info"><small>基本信息</small></legend>',
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



            ],
        ],



    ],

]);?>
<?php
//Tagging support Multiple (maintain the order of selection)
echo '<label class="control-label">禁售平台</label>';
echo Select2::widget([
    'name' => 'DictionaryName',
    //'value' => ['red', 'green'], // initial value
    'data' => $lock,
    'maintainOrder' => true,
    'options' => ['placeholder' => '--可多选--', 'multiple' => true],
    'pluginOptions' => [
        'tags' => true,
        'maximumInputLength' => 5
    ],
]);

?>

<?php
echo Html::submitButton($info->isNewRecord ? '创建基本信息' : '更新基本信息', ['class' => $info->isNewRecord ? 'btn btn-success' : 'btn btn-info']);
echo Html::a('查看SKU信息','#', ['id'=>'sku-info', 'data-toggle' => 'modal','data-target' => '#sku-modal','class'=>'btn btn-primary']);
ActiveForm::end();

//创建模态框
Modal::begin([
    'id' => 'sku-modal',
    'size' => "modal-lg",
//    'header' => '<h4 class="modal-title">SKU信息</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
]);
Modal::end();


//生成URL

$requestUrl = Url::toRoute(['/goodssku/info','id'=>$info->pid]);

//JS代码

$js = <<<JS
//产看SKU信息
    $('#sku-info').on('click', function() {
        $.get('{$requestUrl}',function(data) {
            $('.modal-body').html(data);
        });
    });

JS;
$this->registerJs($js);

?>























