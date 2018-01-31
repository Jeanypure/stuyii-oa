<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-01-17
 * Time: 11:44
 */

use yii\helpers\Url;
use  yii\helpers\Html;
use \kartik\form\ActiveForm;
//use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\daterange\DateRangePicker;
use \kartik\date\DatePicker;


$this->title = '销售走势';
?>
<div class="cat-perform-index">
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- ECharts单文件引入 标签式单文件引入-->
    <script src="http://echarts.baidu.com/build/dist/echarts-all.js"></script>
    <?php
    echo Html::jsFile('@web/js/LRU.js');
    echo Html::jsFile('@web/js/color.js');
    ?>
    <!--搜索框开始-->
    <div class="box-body row">
        <?php $form = ActiveForm::begin([
            'action' => ['sales-trend/index'],
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
        ])->dropDownList(['0' => '按天', '1' => '按月'], ['placeholder' => '类型'])->label('类型:'); ?>

        <?= $form->field($model, 'cat', ['template' => '{label}{input}', 'options' => ['class' => 'col-lg-3']])->label('商品编码:') ?>

        <?= $form->field($model, 'order_range', [
            'template' => '{label}{input}{error}',
            //'addon' => ['prepend' => ['content' => '<i class="glyphicon glyphicon-calendar"></i>']],
            'options' => ['class' => 'col-lg-3']
        ])->widget(DatePicker::classname(), [
            'pluginOptions' => [
                //'autoclose'=>true,
                'format' => 'yyyy-mm-dd',
            ]
        ])->label("<span style = 'color:red'>* 交易开始时间:</span>"); ?>

        <?= $form->field($model, 'create_range', [
            'template' => '{label}{input}{error}',
            //'addon' => ['prepend' => ['content' => '<i class="glyphicon glyphicon-calendar"></i>']],
            'options' => ['class' => 'col-lg-3']
        ])->widget(DatePicker::classname(), [
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ])->label("<span style = 'color:red'>* 交易结束时间:</span>"); ?>


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
    <div class="row">
        <div id="sales" style="width: 1600px;height:480px;" class="col-lg-12"></div>
        <div id="sales-volume" style="width: 1600px;height:480px;" class="col-lg-12"></div>
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
                } else {
                    // for bar
                    return lift(colorList[params.dataIndex], params.seriesIndex * 0.1);
                }
            },
            barBorderRadius: [5, 8, 8, 8]
        },
    };
</script>
<script type="text/javascript">
    var salesData = '<?php echo json_encode($salesData);?>';
    var salesVolumeData = '<?php echo json_encode($salesVolumeData);?>';
    char_line('sales', salesData);
    char_line('sales-volume', salesVolumeData);
    function char_line(id, row_data) {
        var myChart1 = echarts.init(document.getElementById(id));
        var data = eval("(" + row_data + ")");
        var salername, value, CreateDate,role;
        if(id == 'sales'){
            role = '销量(款数)';
        }else if(id == 'sales-volume'){
            role = '销售额($)';
        }
        CreateDate = data.date;
        salername = data.name;
        value = data.value;

        var line = new Array();
        for (var index in value) {
            var single_line = {
                name: salername[index],
                type: 'line',
                stack: '产品款数',
                data: value[index],
                itemStyle: {normal: {areaStyle: {type: 'default'}}},
            };
            line.push(single_line);
        }
        option1 = {
            title: {
                text: role,
                subtext: '数据来源企划部'
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data: salername,
                selectedMode: 'single'
            },
            toolbox: {
                show: true,
                orient: 'vertical',
                y: 'center',
                feature: {
                    mark: {show: true},
                    dataView: {show: true, readOnly: false},
                    magicType: {show: true, type: ['line', 'bar']},
                    restore: {show: true},
                    saveAsImage: {show: true}
                }
            },
            calculable: true,
            xAxis: [
                {
                    type: 'category',
                    data: CreateDate
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    axisLabel: {
                        formatter: '{value}'
                    }
                }
            ],
            series: line
        };
        myChart1.setOption(option1);
    }
</script>





