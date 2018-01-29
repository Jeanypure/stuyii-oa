<?php

use  yii\helpers\Html;
use \kartik\form\ActiveForm;
use kartik\daterange\DateRangePicker;

$this->title = '类别表现';

?>
<?php //echo $this->render('_search'); ?>
<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"
      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- ECharts单文件引入 标签式单文件引入-->
<script src="http://echarts.baidu.com/build/dist/echarts-all.js"></script>
<?php
echo Html::jsFile('@web/js/LRU.js');
echo Html::jsFile('@web/js/color.js');
?>

<div class="product-perform-index">

    <!--搜索框开始-->
    <div class="box-body row">
        <?php $form = ActiveForm::begin([
            'action' => ['dev-perform/index'],
            'method' => 'get',
            'options' => ['class' => 'form-inline drp-container form-group col-lg-12'],
            'fieldConfig' => [
                'template' => '{label}<div class="form-group text-right">{input}{error}</div>',
                //'labelOptions' => ['class' => 'col-lg-3 control-label'],
                'inputOptions' => ['class' => 'form-control'],
            ],
        ]); ?>

        <?= $form->field($model, 'type', [
            'template' => '{label}{input}',
            'options' => ['class' => 'col-lg-2']
        ])->dropDownList(['0' => '交易时间', '1' => '发货时间'], ['placeholder' => '交易类型'])->label('交易类型:'); ?>

        <?= $form->field($model, 'order_range', [
            'template' => '{label}{input}{error}',
            //'addon' => ['prepend' => ['content' => '<i class="glyphicon glyphicon-calendar"></i>']],
            'options' => ['class' => 'col-lg-3']
        ])->widget(DateRangePicker::classname(), [
            'pluginOptions' => [
                'autoUpdateOnInit' => true,
                'startDate' => date("Y-m-01"),
                'endDate' => date("Y-m-d"),
                //'autoclose'=>true,
                'format' => 'yyyy-mm-dd',
            ]
        ])->label("<span style = 'color:red'>* 时间必选:</span>"); ?>

        <?= $form->field($model, 'create_range', [
            'template' => '{label}{input}{error}',
            //'addon' => ['prepend' => ['content' => '<i class="glyphicon glyphicon-calendar"></i>']],
            'options' => ['class' => 'col-lg-3']
        ])->widget(DateRangePicker::classname(), [
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ])->label("开发时间:"); ?>

        <div class="">
            <?= Html::submitButton('<i class="glyphicon glyphicon-hand-up"></i> 确定', ['class' => 'btn btn-primary']); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <!--搜索框结束-->

    <!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->
    <div class="row">
        <div class="col-md-12">
            <div class="loading" style="display: none;">
                <center><img src="/img/loading.gif"></center>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 20px">
        <div id="devSaleNum" style="width: 800px;height:480px;" class="col-lg-6" data-lis="1"></div>
        <div id="devSale" style="width: 800px;height:480px;" class="col-lg-6"></div>
    </div>
</div>
<script>
    var colorList = [
        '#C1232B', '#B5C334', '#FCCE10', '#E87C25', '#27727B',
        '#FE8463', '#9BCA63', '#FAD860', '#F3A43B', '#60C0DD',
        '#D7504B', '#C6E579', '#F4E001', '#F0805A', '#26C0C0',
        '#ff7f50', '#87cefa', '#da70d6', '#32cd32', '#6495ed',
        '#ff69b4', '#ba55d3', '#cd5c5c', '#ffa500', '#40e0d0'
    ];
    var itemStyle = {
        normal: {
            color: function (params) {
                if (params.dataIndex < 0) {
                    // for legend
                    return lift(colorList[colorList.length - 1], params.seriesIndex * 0.1);
                }
                else {
                    // for bar
                    return lift(colorList[params.dataIndex], params.seriesIndex * 0.1);
                }
            },
            barBorderRadius: [5, 8, 8, 8]
        },
    };
</script>


<script type="text/javascript">
    //window.onload = function () {
        var list = '<?php echo json_encode($list);?>';
        var list1 = '<?php echo json_encode($list1);?>';
        init_chart('devSaleNum', list);
        init_chart('devSale', list1);
        function init_chart(id, row_data) {
            // 基于准备好的dom，初始化echarts实例
            var myChart = echarts.init(document.getElementById(id));
            var data = eval("(" + row_data + ")");
            var catNumber, catName, maxValue, role;
            if (id == 'devSaleNum') {
                role = '销量(款数)';
                maxValue = '';
                catNumber = data.data;
                catName = data.name;
            } else if (id == 'devSale') {
                role = '销售额($)';
                maxValue = '';
                catNumber = data.data;
                catName = data.name;
            }
            // 使用刚指定的配置项和数据显示图表。
            option = {
                title: {
                    text: role,
                    subtext: '企划部',
                    x: 'center'
                },
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    orient: 'vertical',
                    x: 'left',
                    data: catName
                },
                toolbox: {
                    show: true,
                    feature: {
                        mark: {show: true},
                        dataView: {show: true, readOnly: false},
                        magicType: {
                            show: true,
                            type: ['pie', 'funnel'],
                            option: {
                                funnel: {
                                    x: '25%',
                                    width: '50%',
                                    funnelAlign: 'left',
                                    max: 1548
//                                    max: maxValue
                                }
                            }
                        },
                        restore: {show: true},
                        saveAsImage: {show: true}
                    }
                },
                calculable: true,
                series: [
                    {
                        name: '访问来源',
                        type: 'pie',
                        radius: '55%',
                        center: ['50%', '60%'],
                        data: catNumber
                    }
                ]
            };
            myChart.setOption(option);
        }

    //}
</script>
