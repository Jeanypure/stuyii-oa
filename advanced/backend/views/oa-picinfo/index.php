<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OaGoodsinfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '图片信息';
$this->params['breadcrumbs'][] = $this->title;
//格式化超链接

?>
<?php echo '<br>'?>
<div class="oa-goodsinfo-index">
    <p>
        <?= Html::button('标记已完善', ['id'=>'complete-lots','class' => 'btn btn-success']); ?>
    </p>
    <?= GridView::widget([
        'dataProvider'=> $dataProvider,
        'filterModel' => $searchModel,
        'showPageSummary'=>true,
        'id' => 'picinfo',
        //'pjax'=>true,
        'striped'=>true,
        'responsive'=>true,
        'hover'=>true,
//        'panel'=>['type'=>'primary', 'heading'=>'基本信息'],
        'columns' => [
            ['class'=>'kartik\grid\SerialColumn'],
            ['class' => 'kartik\grid\CheckboxColumn'],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' =>'{view} {update} {complete}',
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
                    'complete' => function ($url, $model, $key) {
                        $options = [
                            'title' => '标记图片已完善',
                            'aria-label' => '标记图片已完善',
                            'data-id' => $key,
                            'class' => 'index-complete',
                        ];
                        return Html::a('<span  class="glyphicon glyphicon-check"></span>', '#', $options);
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
            [
                'attribute' => 'GoodsCode',
                'format' => 'raw',
                'value' => function ($model) {
                    if($model->stockUp) {
                        return '<strong style="color:red">'. $model->GoodsCode.'</strong>';
                    }
                    return $model->GoodsCode;
                }
            ],
            [
                'attribute' => 'stockUp',
                'width' => '150px',
                'format' => 'raw',
                'value' => function ($data) {
                    $value = $data->stockUp?'是':'否';
                    return "<span class='cell'>" . $value . "</span>";
                },
            ],
            'GoodsName',
            [
                'attribute' => 'vendor1',
                'format'=>'raw',
                'label' => '供应商链接1',
                'value' =>  function ($data) {
                    $fields = $data->oa_goods['vendor1'];
                if (!empty($fields)) {
                    try {
                        $hostName = parse_url($fields)['host'];
                    } catch (Exception $e) {
                        $hostName = "www.unknown.com";
                    }
                    return "<a class='cell' href='{$fields}' target='_blank'>{$hostName}</a>";
                } else {
                    return '';
                }
            },
            ],
            [
                'attribute' => 'vendor2',
                'format'=>'raw',
                'label' => '供应商链接2',
                'value' =>  function ($data) {
                    $fields = $data->oa_goods['vendor2'];
                    if (!empty($fields)) {
                        try {
                            $hostName = parse_url($fields)['host'];
                        } catch (Exception $e) {
                            $hostName = "www.unknown.com";
                        }
                        return "<a class='cell' href='{$fields}' target='_blank'>{$hostName}</a>";
                    } else {
                        return '';
                    }
                },
            ],
            [
                'attribute' => 'vendor3',
                'format'=>'raw',
                'label' => '供应商链接3',
                'value' =>  function ($data) {
                    $fields = $data->oa_goods['vendor3'];
                    if (!empty($fields)) {
                        try {
                            $hostName = parse_url($fields)['host'];
                        } catch (Exception $e) {
                            $hostName = "www.unknown.com";
                        }
                        return "<a class='cell' href='{$fields}' target='_blank'>{$hostName}</a>";
                    } else {
                        return '';
                    }
                },
            ],
            [
                'attribute' => 'origin1',
                'format'=>'raw',
                'label' => '平台链接1',
                'value' =>  function ($data) {
                    $fields = $data->oa_goods['origin1'];
                    if (!empty($fields)) {
                        try {
                            $hostName = parse_url($fields)['host'];
                        } catch (Exception $e) {
                            $hostName = "www.unknown.com";
                        }
                        return "<a class='cell' href='{$fields}' target='_blank'>{$hostName}</a>";
                    } else {
                        return '';
                    }
                },
            ],
            [
                'attribute' => 'origin2',
                'format'=>'raw',
                'label' => '平台链接2',
                'value' =>  function ($data) {
                    $fields = $data->oa_goods['origin2'];
                    if (!empty($fields)) {
                        try {
                            $hostName = parse_url($fields)['host'];
                        } catch (Exception $e) {
                            $hostName = "www.unknown.com";
                        }
                        return "<a class='cell' href='{$fields}' target='_blank'>{$hostName}</a>";
                    } else {
                        return '';
                    }
                },
            ],
            [
                'attribute' => 'originr3',
                'format'=>'raw',
                'label' => '平台链接3',
                'value' =>  function ($data) {
                    $fields = $data->oa_goods['origin3'];
                    if (!empty($fields)) {
                        try {
                            $hostName = parse_url($fields)['host'];
                        } catch (Exception $e) {
                            $hostName = "www.unknown.com";
                        }
                        return "<a class='cell' href='{$fields}' target='_blank'>{$hostName}</a>";
                    } else {
                        return '';
                    }
                },
            ],
            'picStatus',
            'developer',
            [
                'attribute' => 'devDatetime',
                'format' => 'raw',
                //'format' => ['date', "php:Y-m-d"],
                'value' => function ($model) {
                    return "<span class='cell'>" . substr(strval($model->devDatetime), 0, 10) . "</span>";
                },
                'width' => '200px',
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'value' => Yii::$app->request->get('OaGoodsinfoSearch')['devDatetime'],
                        'convertFormat' => true,
                        'useWithAddon' => true,
                        'format' => 'php:Y-m-d',
                        'todayHighlight' => true,
                        'locale'=>[
                            'format' => 'YYYY-MM-DD',
                            'separator'=>'/',
                            'applyLabel' => '确定',
                            'cancelLabel' => '取消',
                            'daysOfWeek'=>false,
                        ],
                        'opens'=>'left',
                        //起止时间的最大间隔
                        /*'dateLimit' =>[
                            'days' => 300
                        ]*/
                    ]
                ]
            ],
            'possessMan1',
            [
                'attribute' => 'isVar',
                'width' => '100px',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>['是' => '是', '否' => '否'],
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'是否多属性'],
            ],
        ],
    ]); ?>

    <?php
    //创建模态框
    use yii\bootstrap\Modal;
    Modal::begin([
        'id' => 'index-modal',
        'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
        'size' => "modal-lg"
    ]);
    //echo
    Modal::end();
    $viewUrl = Url::toRoute('view');

    $completeUrl = Url::toRoute('complete');           //标记图片单个已完善
    $completeLotsUrl = Url::toRoute('complete-lots'); //标记图片批量已完善
    $js = <<<JS
// 查看框
$('.index-view').on('click',  function () {
    $('.modal-body').children('div').remove();
    $.get('{$viewUrl}',{ id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }
        );
    });

    //单个标记已完善
    $(".index-complete").on('click',function() {
        id = $(this).closest('tr').data('key');
        
        $.ajax({
        url:'{$completeUrl}',
        type:'get',
        data:{id:id},
        success:function(res) {
        alert(res);//传回结果信息
        }
        });
    });
    
    //批量标记完善
    $("#complete-lots").on('click',function() {
        ids = $("#picinfo").yiiGridView('getSelectedRows');
        
        $.ajax({
        url:'{$completeLotsUrl}',
        type:'get',
        data:{ids:ids},
        success:function(res) {
        alert(res);
        location.reload();
        }
        });
    });

    
    //关联表目前无法指定样式只能通过JS来实现
    function linkFormatter() {
        for(var i=6;i<=8;i++){
        $("[data-col-seq='"+ i + "']").each(function(index,ele) {
         var text  = $(ele).text();
         if(text.length>0 && text.indexOf('链接')<0){
         
         var url = '<a  target="_blank" href="'+ text+'">' + '=></a>';
         $(this).text('');
         
         $(this).append(url);
         $(this).attr('style','width: 6;')
         }
    });
    }
    
    }
    // linkFormatter();
   
JS;
    $this->registerJs($js); ?>
</div>







