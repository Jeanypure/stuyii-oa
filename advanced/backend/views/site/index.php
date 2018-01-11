<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use  yii\helpers\Html;

$this->title = '主页';
$todevdata = Url::toRoute('dev-data');
$js = <<< JS
//设置背景色
$('body').css('background','#FFF');
//删除H1
$('h1').remove();
  $(function () {
            $.ajax({
                url:'{$todevdata}', 
                success:function (data) {
                   // var da = JSON.parse(data);  //推荐方法
                    init_chart('introducer',data);
                    init_chart('salername',data);
                   
                }
            });

        }); 
JS;
$this->registerJs($js);
?>

<div class="site-index">
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- ECharts单文件引入 标签式单文件引入-->
    <script src="http://echarts.baidu.com/build/dist/echarts-all.js"></script>
    <?php
    echo Html::jsFile('@web/js/LRU.js');
    echo Html::jsFile('@web/js/color.js');
    ?>
    <script >
        var colorList = [
            '#C1232B','#B5C334','#FCCE10','#E87C25','#27727B',
            '#FE8463','#9BCA63','#FAD860','#F3A43B','#60C0DD',
            '#D7504B','#C6E579','#F4E001','#F0805A','#26C0C0',
            '#ff7f50','#87cefa','#da70d6','#32cd32','#6495ed',
            '#ff69b4','#ba55d3','#cd5c5c','#ffa500','#40e0d0'
        ];
        var itemStyle = {
            normal: {
                color: function(params) {
                    if (params.dataIndex < 0) {
                        // for legend
                        return lift(
                            colorList[colorList.length -1], params.seriesIndex * 0.1
                        );
                    }
                    else {
                        // for bar
                        return lift(
                            colorList[params.dataIndex], params.seriesIndex * 0.1
                        );
                    }
                },
                barBorderRadius:[5, 5, 5, 5]
            },

        };
    </script>
    <body>
    <!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->
    <div class="row">
        <div id="salername"  style="width: 800px;height:480px;" class="col-lg-6" >
        </div>
        <div id="introducer" style="width: 800px;height:480px;" class="col-lg-6">
        </div>
    </div>
    <script type="text/javascript">
        function init_chart(id,row_data) {
            // 基于准备好的dom，初始化echarts实例
            var myChart = echarts.init(document.getElementById(id));
            var data = eval("("+row_data+")");
            if(id == 'salername'){
                var role = '开发员';
               var nameType  = data.salername.salername;
                var OneMonth = data.salername.OneMonth;
                var ThreeMonth = data.salername.ThreeMonth;
                var SixMonth = data.salername.SixMonth;
            }
            else{
                var role = '推荐人';
               var nameType  = data.introducer.introducer;
                var OneMonth = data.introducer.OneMonth;
                var ThreeMonth = data.introducer.ThreeMonth;
                var SixMonth = data.introducer.SixMonth;
            }
            // 使用刚指定的配置项和数据显示图表。
            option = {
                title: {
                    x: 'center',
                    text: role +'-近30天销售额($)',
                    subtext: '数据来源企划部',
                    sublink: 'http://data.stats.gov.cn/search/keywordlist2?keyword=%E5%9F%8E%E9%95%87%E5%B1%85%E6%B0%91%E6%B6%88%E8%B4%B9'
                },
                tooltip: {
                    borderRadius:5,
                    trigger: 'axis',
                    backgroundColor: 'rgba(255,255,255,0.7)',
                    axisPointer: {
                        type: 'shadow'
                    },
                    formatter: function(params) {
                        // for text color
                        var color = colorList[params[0].dataIndex];
                        var res = '<div style="color:' + color + '">';
                        res += '<strong>' + params[0].name + '销售额（$）</strong>'
                        for (var i = 0, l = params.length; i < l; i++) {
                            res += '<br/>' + params[i].seriesName + ' : ' + params[i].value
                        }
                        res += '</div>';
                        return res;
                    }
                },
                legend: {
                    x: 'right',
                    data:['1个月新品','3个月新品','6个月新品'],
                    selected: {
                        '3个月新品' : false,
                        '6个月新品' : false
                    },
                    selectedMode : 'single'
                },
                toolbox: {
                    show: true,
                    orient: 'vertical',
                    y: 'center',
                    feature: {
                        mark: {show: true},
                        dataView: {show: true, readOnly: false},
                        restore: {show: true},
                        saveAsImage: {show: true}
                    }
                },
                calculable: true,
                grid: {
                    y: 80,
                    y2: 40,
                    x2: 40
                },
                xAxis: [
                    {
                        type: 'category',
                        data: nameType
                    }
                ],
                yAxis: [
                    {
                        type: 'value',
                        name : '销售额($)',
                    }
                ],
                series: [
                    {
                        name: '1个月新品',
                        type: 'bar',
                        itemStyle: itemStyle,
                        data: OneMonth
                    },
                    {
                        name: '3个月新品',
                        type: 'bar',
                        itemStyle: itemStyle,
                        data: ThreeMonth
                    },
                    {
                        name: '6个月新品',
                        type: 'bar',
                        itemStyle: itemStyle,
                        data: SixMonth
                    },

                ]
            };
            myChart.setOption(option);
        }
    </script>
    </body>
</div>





