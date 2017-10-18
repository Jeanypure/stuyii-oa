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
        <?= Html::a('添加产品信息', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([

        'dataProvider'=> $dataProvider,
        'filterModel' => $searchModel,
        'showPageSummary'=>true,
        'pjax'=>true,
        'striped'=>true,
        'responsive'=>true,
        'hover'=>true,
        'panel'=>['type'=>'primary', 'heading'=>'基本信息'],

        'columns' => [
            ['class'=>'kartik\grid\SerialColumn'],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' =>'{view} {update} {delete}',
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
            'GoodsName',
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
$js = <<<JS
// alert(123);
// 查看框
$('.index-view').on('click',  function () {
    $.get('{$viewUrl}',{ id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }
        );
    });
JS;
$this->registerJs($js);

?>
</div>


