<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = '主页';
//$failLotsUrl = Url::toRoute('fail-lots');
$todevdata = Url::toRoute('dev-data');
$js = <<< JS
//设置背景色
$('body').css('background','#FFF');

//删除H1
$('h1').remove();
  $(function () {
            var titles = new Set();
            $.ajax({
                url:'{$todevdata}', 
                success:function (data) {
                    init_chart('main',data);
                }
            });
        });

JS;
$this->registerJs($js);
?>



<div class="site-index">
    <body>

    <!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->
    <div id="main" style="width: 1000px;height:600px;">
        <script src="https://cdn.bootcss.com/echarts/3.8.5/echarts.min.js"></script>
        <script type="text/javascript">



            function init_chart(id,row_data) {
                // 基于准备好的dom，初始化echarts实例
                var myChart = echarts.init(document.getElementById('main'),'macarons');
                var data = eval("("+row_data+")");
                var salername = data.salername;
                var l_AMT = data.l_AMT;
                var value = data.value;
                // 指定图表的配置项和数据
                option = {
                    title: {
                        x: 'center',
                        text: '30天销售额[1个月新品]',
                        subtext: 'Rainbow bar example',
                        link: 'http://echarts.baidu.com/doc/example.html'
                    },
                    tooltip: {
                        trigger: 'item'
                    },
                    toolbox: {
                        show: true,
                        feature: {
                            dataView: {show: true, readOnly: false},
                            restore: {show: true},
                            saveAsImage: {show: true}
                        }
                    },
                    calculable: true,
                    grid: {
                        borderWidth: 0,
                        y: 80,
                        y2: 60
                    },
                    xAxis: [
                        {
                            type: 'category',
                            show: false,
                            data: salername
                        }
                    ],
                    yAxis: [
                        {
                            type: 'value',
                            show: false
                        }
                    ],
                    series: [
                        {
                            name: '30天销售额[1个月新品]',
                            type: 'bar',
                            itemStyle: {
                                normal: {
                                    color: function(params) {
                                        // build a color map as your need.
                                        var colorList = [
                                            '#C1232B','#B5C334','#FCCE10','#E87C25','#27727B',
                                            '#FE8463','#9BCA63','#FAD860','#F3A43B','#60C0DD',
                                            '#D7504B','#C6E579','#F4E001','#F0805A','#26C0C0'
                                        ];
                                        return colorList[params.dataIndex]
                                    },
                                    label: {
                                        show: true,
                                        position: 'top',
                                        formatter: '{b}\n{c}'
                                    }
                                }
                            },
                            data: l_AMT,
                            markPoint: {
                                tooltip: {
                                    trigger: 'item',
                                    backgroundColor: 'rgba(0,0,0,0)',
                                    formatter: function(params){
                                        return '<img src="'
                                            + params.data.symbol.replace('image://', '')
                                            + '"/>';
                                    }
                                },
                                data: [
                                    {xAxis:0, y: 350, name:'Line', symbolSize:20, symbol: 'image://../asset/ico/折线图.png'},
                                    {xAxis:1, y: 350, name:'Bar', symbolSize:20, symbol: 'image://../asset/ico/柱状图.png'},
                                    {xAxis:2, y: 350, name:'Scatter', symbolSize:20, symbol: 'image://../asset/ico/散点图.png'},
                                    {xAxis:3, y: 350, name:'K', symbolSize:20, symbol: 'image://../asset/ico/K线图.png'},
                                    {xAxis:4, y: 350, name:'Pie', symbolSize:20, symbol: 'image://../asset/ico/饼状图.png'},
                                    {xAxis:5, y: 350, name:'Radar', symbolSize:20, symbol: 'image://../asset/ico/雷达图.png'},
                                    {xAxis:6, y: 350, name:'Chord', symbolSize:20, symbol: 'image://../asset/ico/和弦图.png'},
                                    {xAxis:7, y: 350, name:'Force', symbolSize:20, symbol: 'image://../asset/ico/力导向图.png'},
                                    {xAxis:8, y: 350, name:'Map', symbolSize:20, symbol: 'image://../asset/ico/地图.png'},
                                    {xAxis:9, y: 350, name:'Gauge', symbolSize:20, symbol: 'image://../asset/ico/仪表盘.png'},
                                    {xAxis:10, y: 350, name:'Funnel', symbolSize:20, symbol: 'image://../asset/ico/漏斗图.png'},
                                ]
                            }
                        }
                    ]
                };


                // 使用刚指定的配置项和数据显示图表。
                myChart.setOption(option);
            }

        </script>
    </div>
    </body>
</div>





