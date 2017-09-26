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
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

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

        ]);?>
<?php ActiveForm::end(); ?>

    <?php
    echo Html::label("<legend><small>SKU信息</small></legend>");
    echo "<br>";

    echo GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'sku',
                'format' => 'text'
            ],
            [
                'attribute' => 'property1',
                'format' => 'text',
            ],
            [
                'attribute' => 'property2',
                'format' => 'text',
            ],
            [
                'attribute' => 'CostPrice',
                'format' => 'text',
            ],
            [
                'attribute' => 'Weight',
                'format' => 'text',
            ],
            [
                'attribute' => 'RetailPrice',
                'format' => 'text',
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                // you may configure additional properties here
                'template' =>'{update} {delete}',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        $options = [
                            'title' => '删除',
                            'aria-label' => '删除',
                            'data-confirm' => '你确定删除此SKU?',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    }
                ],
            ],
        ],
    ]);

     ?>




<?php
echo Html::a('+新增SKU', '#', [
    'id' => 'create',
    'data-toggle' => 'modal',
    'data-target' => '#create-modal',//关联下面Model的id属性
    'class' => 'btn btn-success',
]);
?>

<?php
Modal::begin([
    'id' => 'create-modal',
    'header' => '<h4 class="modal-title">新增SKU</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
    'size'=>Modal::SIZE_LARGE,
    'options'=>[
        'data-backdrop'=>'static',//点击空白处不关闭弹窗
        'data-keyboard'=>false,
    ],
]);


$requestUrl = Url::toRoute(['/goodssku/create']);//弹窗的html内容，下面的js会调用获得该页面的Html内容，直接填充在弹框中
$js = <<<JS
    $.post('{$requestUrl}', {},
         
        function (data) {
         $('.modal-body').html(data);
        }  
    );

JS;
$this->registerJs($js);
Modal::end();
?>






















