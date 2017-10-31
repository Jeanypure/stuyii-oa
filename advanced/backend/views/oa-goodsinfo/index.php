<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\OaGoodsinfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '属性信息';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="oa-goodsinfo-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('批量导入普源', ['id'=>'input-lots','class' => 'btn btn-success']) ?>
        <?= Html::button('重新生成商品编码', ['id'=>'generate-code','class' => 'btn btn-info']) ?>
    </p>
    <?= GridView::widget([

        'dataProvider'=> $dataProvider,
        'filterModel' => $searchModel,
        'showPageSummary'=>true,
        'id' => 'oa-goodsinfo',
        'pjax'=>true,
        'striped'=>true,
        'responsive'=>true,
        'hover'=>true,
//        'panel'=>['type'=>'primary', 'heading'=>'基本信息'],

        'columns' => [
            ['class' => 'kartik\grid\CheckboxColumn'],
            ['class'=>'kartik\grid\SerialColumn'],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' =>'{view} {update} {input} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        $options = [
                            'title' => '查看',
                            'aria-label' => '查看',
                            'data-toggle' => 'modal',
                            'data-target' => '#index-modal',
                            'data-id' => $key,
                            'class' => 'index-view',

                        ];
                        return Html::a('<span  class="glyphicon glyphicon-eye-open"></span>', '#', $options);
                    },
                    'input' => function ($url, $model, $key) {
                        $options = [
                            'title' => '导入普源',
                            'aria-label' => '导入普源',
                            'data-id' => $key,
                            'class' => 'index-input',

                        ];
                        return Html::a('<span  class="glyphicon glyphicon-send"></span>', '#', $options);
                    },

                ],

            ],
            [
                'attribute' => 'picUrl',
                'value' =>function($model,$key, $index, $widget) {
                    return "<img src='$model->picUrl' width='100' height='100'/>";
                },
                'format' => 'raw',
                'width' => '100px',
            ],

            'GoodsCode',
            [
            'attribute' => 'achieveStatus',
            'width' => '100px',
            ],
            'GoodsName',
            'developer',
            [
                'attribute' => 'devDatetime',
                'label'=>'更新时间',
                'value'=>
                    function($model){
                        return  substr($model->devDatetime,0,19);   //主要通过此种方式实现
                    },
            ],
            'AliasCnName',
            'AliasEnName',


            [
                'attribute'=>'IsLiquid',
                'width'=>'100px',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->IsLiquid;
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(\backend\models\OaGoodsinfo::find()->orderBy('pid')->asArray()->all(), 'pid', 'IsLiquid'),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'是否是液体'],
                'group'=>true,  // enable grouping
            ],

            [
                'attribute' => 'IsPowder',
                'width' => '100px',
             ],

            [
                'attribute' => 'isMagnetism',
                'width' => '100px',
            ],
            [
                'attribute' => 'IsCharged',
                'width' => '100px',
            ],


        ],




    ]); ?>

<?php
//创建模态框
use yii\bootstrap\Modal;
Modal::begin([
    'id' => 'index-modal',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
]);
//echo
Modal::end();

$viewUrl = Url::toRoute('view');
$inputUrl = Url::toRoute('input');
$inputLotsUrl = Url::toRoute('input-lots');
//$generateUrl = Url::toRoute('generate-code');

$js = <<<JS



// 查看框
$('.index-view').on('click',  function () {
    $.get('{$viewUrl}',{ id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }
        );
    });


//单个导入普源
$('.index-input').on('click', function() {
    id = $(this).closest('tr').data('key')
    $.ajax({
        url: '{$inputUrl}',
        type: "get",
        data: {id:id},
        success:function(res) {
            alert(res);
        }
    })
});

//批量导入普源
$('#input-lots').on('click', function() {
    ids = $('#oa-goodsinfo').yiiGridView('getSelectedRows');
    // alert(ids);
   $.ajax({
          url: '{$inputLotsUrl}',
          type:"post",
          data:{id:ids},
          success:function(res){
               alert(res);
          }
       });
});

//重新生成商品编码
$('#generate-code').on('click',function() {
    ids = $('#oa-goodsinfo').yiiGridView('getSelectedRows');
    console.log(ids);
    $.get('/oa-goodsinfo/generate-code',{ids:ids});
});

JS;
$this->registerJs($js);

?>
</div>


