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
                      init_chart('salername',data);
                      init_chart('num-salername',data);
                      init_chart('introducer',data);
                      init_chart('num-introducer',data);
                      char_line('per-day-num',data);
                    }
                });
            }); 
		$(document).on('ajaxStart', function(){
			$('.loading').show();
			return false;
		});
		$(document).on('ajaxComplete',function(e,x,o){
			$('.loading').hide();
			return false;
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
            //柱形图圆角，鼠标移上去效果，如果只是一个数字则说明四个参数全部设置为那么多
            emphasis: {
                barBorderRadius: [8,8,8,8]
            },
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
                barBorderRadius:[8,8,8,8]
            },
        };
    </script>
    <body>
    <!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->
    <div class="row">
        <div class="col-md-12">
            <div class="loading" style="display: none;"><center><img src="/img/loading.gif"></center></div>
        </div>
    </div>
    <div class="row">
        <div id="salername"  style="width: 800px;height:480px;" class="col-lg-6" ></div>
        <div id="introducer" style="width: 800px;height:480px;" class="col-lg-6"></div>

    </div>
    <div class="row">
        <div id="num-salername"  style="width: 800px;height:480px;" class="col-lg-6" ></div>
        <div id="num-introducer" style="width: 800px;height:480px;" class="col-lg-6"></div>
    </div>
    <div class="row">
        <div id="per-day-num"  style="width: 1600px;height:580px;" class="col-lg-12" ></div>
        <input id="selectall" type="button" value="全不选" flag="1"/>
    </div>
    <script type="text/javascript">
        function init_chart(id,row_data) {
            // 基于准备好的dom，初始化echarts实例
            var myChart = echarts.init(document.getElementById(id));
            var data = eval("("+row_data+")");
            var role,itemType,nameType,OneMonth,ThreeMonth,SixMonth;
            if(id == 'salername'){
                 role = '开发员-';
                 itemType = '销售额($)';
                 nameType  = data.salername.salername;
                 OneMonth = data.salername.OneMonth;
                 ThreeMonth = data.salername.ThreeMonth;
                 SixMonth = data.salername.SixMonth;
            } else if(id == 'num-salername'){
                 role = '开发员-';
                 itemType =  '新品款数(个)';
                 nameType  = data.codenum.salername;
                 OneMonth = data.codenum.OneMonth;
                 ThreeMonth = data.codenum.ThreeMonth;
                 SixMonth = data.codenum.SixMonth;
            }else if(id == 'introducer') {
                 role = '推荐人-';
                itemType =  '销售额($)';
                 nameType  = data.introducer.introducer;
                 OneMonth = data.introducer.OneMonth;
                 ThreeMonth = data.introducer.ThreeMonth;
                 SixMonth = data.introducer.SixMonth;
            }else if(id == 'num-introducer') {
                 role = '推荐人-';
                 itemType =  '推荐成功款数(个)';
                 nameType  = data.introCodeNum.introducer;
                 OneMonth = data.introCodeNum.OneMonth;
                 ThreeMonth = data.introCodeNum.ThreeMonth;
                 SixMonth = data.introCodeNum.SixMonth;
            }
            // 使用刚指定的配置项和数据显示图表。
            option = {
                title: {
                    x: 'center',
                    text: role +itemType,
                    subtext: '数据来源企划部',
                    sublink: 'http://data.stats.gov.cn/search/keywordlist2?keyword=%E5%9F%8E%E9%95%87%E5%B1%85%E6%B0%91%E6%B6%88%E8%B4%B9'
                },
                tooltip: {
//                    borderRadius:5,
                    trigger: 'axis',
                    backgroundColor: 'rgba(255,255,255,0.7)',
                    axisPointer: {
                        type: 'shadow'
                    },
                    formatter: function(params) {
                        // for text color
                        var color = colorList[params[0].dataIndex];
                        var res = '<div style="color:' + color + '">';
                        res += '<strong>' + params[0].name +'</strong>'
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
                        name : itemType,

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
    <script>
        function  char_line(id,row_data) {
            var myChart = echarts.init(document.getElementById(id));
            var data = eval("("+row_data+")");
            var salername = data.dev;
            var CreateDate = data.CreateDate;
            var value = data.value;
            var line = new Array();
            for(var index in value){
                var single_line=  {
                    name:salername[index],
                    type:'line',
                    stack: '产品款数',
                    data:value[index],
                    itemStyle: {normal: {areaStyle: {type: 'default'}}},
//                    markPoint : {
//                        data : [
//                            {type : 'max', name: '最大值'},
//                            {type : 'min', name: '最小值'}
//                        ]
//                    },
                };
                line.push(single_line);
            }
            option = {
                title : {
                    text: '近30天每天开款数',
                    subtext: '企划部'
                },
                tooltip : {
                    trigger: 'axis'
                },
                legend: {
                    data:salername,
                    selectedMode : 'single'
                },
                toolbox: {
                    show : true,
                    orient: 'vertical',
                    y: 'center',
                    feature : {
                        mark : {show: true},
                        dataView : {show: true, readOnly: false},
                        magicType : {show: true, type: ['line', 'bar']},
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                calculable : true,
                xAxis : [
                    {
                        type : 'category',
                        data : CreateDate
                    }
                ],
                yAxis : [
                    {
                        type : 'value',
                        axisLabel : {
                            formatter: '{value}款'
                        }
                    }
                ],
                series : line
            };
            myChart.setOption(option);
            var selectArr = myChart.getOption().legend.data;

            $('#selectall').click(function(){
                var flag = $(this).attr('flag');
                var val =false;
                if(flag == 1){
                    val = false;
                    $(this).attr('flag',0);
                    $(this).val('全选中');
                }else{
                    val = true;
                    $(this).attr('flag',1);
                    $(this).val('全不选');
                }
                var obj = {};
                for(var key in selectArr){
                    obj[selectArr[key]] = val;
                }
                option.legend.selected = obj;
                myChart.clear();
                myChart.setOption(option);
            });
        }
    </script>
    </body>
</div>






