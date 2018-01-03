<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\dialog\Dialog;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OaGoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '产品推荐';
$this->params['breadcrumbs'][] = $this->title;
//创建模态框
use yii\bootstrap\Modal;
Modal::begin([
    'id' => 'index-modal',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
    'size' => "modal-lg"
]);
//echo
Modal::end();


//绑定模态框事件

$requestUrl = Url::toRoute('heart');
$viewUrl = Url::toRoute('view');
$updateUrl = Url::toRoute('update');
$createUrl = Url::toRoute('create');
$js = <<<JS
//删除按钮
    $('.index-delete').on('click',  function () {
     self = this;
     krajeeDialog.confirm("确定删除此条记录?", function (result) {
        
        if (result) {
            id = $(self).closest('tr').data('key');
            $.post('delete',{id:id,type:'index'},function() {
            });
            }
            });
        });
    // 批量作废
    $('.delete-lots').on('click',function() {
    var ids = $("#oa-goods").yiiGridView("getSelectedRows");
    var self = $(this);
    if(ids.length == 0) return false;
     $.ajax({
           url:"<?= Url::to(['oa-goods/delete-lots'])?>",
           type:"post",
           data:{id:ids},
           success:function(res){
                console.log("yeah lots failed!");
           }
        });
    });
    
    //认领对话
    $('.data-heart').on('click',  function () {
       $('.modal-body').children('div').remove();
        $.get('{$requestUrl}',  { id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }
        );
    });
    
    //图标剧中
        $('.glyphicon-eye-open').addClass('icon-cell');
        $('.wrapper').addClass('body-color');

    
// 查看框
$('.index-view').on('click',  function () {
        $('.modal-body').children('div').remove();
        $.get('{$viewUrl}',  { id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }
        );
    });

//更新框
$('.index-update').on('click',  function () {
       $('.modal-body').children('div').remove();
        $.get('{$updateUrl}',  { id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }
        );
    });   
    
//创建框
$('.index-create').on('click',  function () {
        $('.modal-body').children('div').remove();
        $.get('{$createUrl}',
            function (data) {
                $('.modal-body').html(data);
            }
        );
    }); 
    
// todo 未通过审核的产品单独创建模态框，并增加提交审核和作废的按钮

JS;
$this->registerJs($js);

    //单元格居中类
    class CenterFormatter {
        public function __construct($name) {
            $this->name = $name;
        }
        public  function format() {
            // 超链接显示为超链接
            if ($this->name === 'origin'||$this->name === 'origin1'||$this->name === 'origin1'
                ||$this->name === 'origin2'||$this->name === 'origin3'||$this->name === 'vendor1'||$this->name === 'vendor2'
                ||$this->name === 'vendor3') {
                return  [
                    'attribute' => $this->name,
                    'value' => function($data) {
                        if(!empty($data[$this->name]))
                        {
                            try {
                                $hostName = parse_url($data[$this->name])['host'];
                            }
                            catch (Exception $e){
                                $hostName = "www.unknown.com";
                            }
                            return "<a class='cell' href='{$data[$this->name]}' target='_blank'>{$hostName}</a>";
                        }
                        else
                        {
                            return '';
                        }

                    },
                    'format' => 'raw',

                ];
                // 图片显示为图片
            }
            if ($this->name === 'img') {
                return [
                    'attribute' => 'img',
                    'value' => function($data) {
                        return "<img src='".$data[$this->name]."' width='100' height='100'>";

                    },
                    'format' => 'raw',

                ];
            }
            if (strpos(strtolower($this->name), 'date') || strpos(strtolower($this->name), 'time')) {
                return [
                    'attribute' => $this->name,
                    'value' => function($data) {
                        return "<span class='cell'>".substr($data[$this->name],0,10)."</span>";

                    },
                    'format' => 'raw',

                ];

            }
            return  [
                'attribute' => $this->name,
                'value' => function($data) {
                    return "<span class='cell'>".$data[$this->name]."</span>";
                },
                'format' => 'raw',


            ];
        }
    };
    //封装到格式化函数中
    function centerFormat($name) {
        return (new CenterFormatter($name))->format();
    };

    function subDateTime($Date){
        date('Y-m-d', strtotime($Date));
//        输出是：2009-03-30
    }

?>
<style>
    .cell {
        Word-break: break-all;
        display: table-cell;
        vertical-align: middle;
        text-align: center;
        width: 100px;
        height: 100px;
        /*border:1px solid #666;*/
    }

    .icon-cell {
        Word-break: break-all;
        display: table-cell;
        vertical-align: middle;
        text-align: center;
        width: 10px;
        height: 100px;
    }
    .body-color {
        background-color: whitesmoke;
    }
</style>
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<div class="oa-goods-index">
   <!-- 页面标题-->
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增产品',"javascript:void(0);",  ['title'=>'create','data-toggle' => 'modal','data-target' => '#index-modal','class' => 'index-create btn btn-primary']) ?>
        <?= Html::a('批量导入', "javascript:void(0);", ['title' => 'upload', 'class' => 'upload btn btn-info']) ?>
        <?= Html::a('批量删除',"javascript:void(0);",  ['title'=>'deleteLots','class' => 'delete-lots btn btn-danger']) ?>
        <?= Html::a('下载模板', ['template'], ['class' => 'btn btn-success']) ?>
        <input type="file" id="import" name="import" style="display: none" >
    </p>

    <?= GridView::widget([
        'bootstrap' => true,
        'responsive'=>true,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'oa-goods',
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn',],
            ['class' => 'kartik\grid\SerialColumn'],
            // action
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' =>'{view} {update} {delete} {heart}',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        $options = [
                            'title' => '删除',
                            'aria-label' => '删除',
                            'data-id' => $key,
                            'class' => 'index-delete',
                        ];
                        return Html::a('<span  class="glyphicon glyphicon-trash"></span>', '#', $options);
                    },
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
                    'update' => function ($url, $model, $key) {
                        $options = [
                            'title' => '更新',
                            'aria-label' => '更新',
                            'data-toggle' => 'modal',
                            'data-target' => '#index-modal',
                            'data-id' => $key,
                            'class' => 'index-update',
                        ];
                        return Html::a('<span  class="glyphicon glyphicon-pencil"></span>', '#', $options);
                    },
                    'heart' => function ($url, $model, $key) {
                        $options = [
                            'title' => '认领',
                            'aria-label' => '认领',
                            'data-toggle' => 'modal',
                            'data-target' => '#index-modal',
                            'data-id' => $key,
                            'class' => 'data-heart',
                        ];
                        return Html::a('<span  class="glyphicon glyphicon-heart"></span>', '#', $options);
                    }
                ],
            ],

             centerFormat('img'),
             centerFormat('cate'),
             centerFormat('subCate'),
             centerFormat('vendor1'),
             centerFormat('origin1'),
             centerFormat('introducer'),
             centerFormat('introReason'),
             centerFormat('checkStatus'),
             centerFormat('approvalNote'),
             centerFormat('createDate'),
             centerFormat('updateDate'),
        ],
    ]); ?>

<!--    <script src="/jquery.csv.js"></script>-->
        <script>
            RegExp.escape= function(s) {
                return s.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
            };

            $(function () {
                'use strict';



                /**
                 * jQuery.csv.defaults
                 * Encapsulates the method paramater defaults for the CSV plugin module.
                 */

                $.csv = {
                    defaults: {
                        separator:',',
                        delimiter:'"',
                        headers:true
                    },

                    hooks: {
                        castToScalar: function(value, state) {
                            var hasDot = /\./;
                            if (isNaN(value)) {
                                return value;
                            } else {
                                if (hasDot.test(value)) {
                                    return parseFloat(value);
                                } else {
                                    var integer = parseInt(value);
                                    if(isNaN(integer)) {
                                        return null;
                                    } else {
                                        return integer;
                                    }
                                }
                            }
                        }
                    },

                    parsers: {
                        parse: function(csv, options) {
                            // cache settings
                            var separator = options.separator;
                            var delimiter = options.delimiter;

                            // set initial state if it's missing
                            if(!options.state.rowNum) {
                                options.state.rowNum = 1;
                            }
                            if(!options.state.colNum) {
                                options.state.colNum = 1;
                            }

                            // clear initial state
                            var data = [];
                            var entry = [];
                            var state = 0;
                            var value = '';
                            var exit = false;

                            function endOfEntry() {
                                // reset the state
                                state = 0;
                                value = '';

                                // if 'start' hasn't been met, don't output
                                if(options.start && options.state.rowNum < options.start) {
                                    // update global state
                                    entry = [];
                                    options.state.rowNum++;
                                    options.state.colNum = 1;
                                    return;
                                }

                                if(options.onParseEntry === undefined) {
                                    // onParseEntry hook not set
                                    data.push(entry);
                                } else {
                                    var hookVal = options.onParseEntry(entry, options.state); // onParseEntry Hook
                                    // false skips the row, configurable through a hook
                                    if(hookVal !== false) {
                                        data.push(hookVal);
                                    }
                                }
                                //console.log('entry:' + entry);

                                // cleanup
                                entry = [];

                                // if 'end' is met, stop parsing
                                if(options.end && options.state.rowNum >= options.end) {
                                    exit = true;
                                }

                                // update global state
                                options.state.rowNum++;
                                options.state.colNum = 1;
                            }

                            function endOfValue() {
                                if(options.onParseValue === undefined) {
                                    // onParseValue hook not set
                                    entry.push(value);
                                } else {
                                    var hook = options.onParseValue(value, options.state); // onParseValue Hook
                                    // false skips the row, configurable through a hook
                                    if(hook !== false) {
                                        entry.push(hook);
                                    }
                                }
                                //console.log('value:' + value);
                                // reset the state
                                value = '';
                                state = 0;
                                // update global state
                                options.state.colNum++;
                            }

                            // escape regex-specific control chars
                            var escSeparator = RegExp.escape(separator);
                            var escDelimiter = RegExp.escape(delimiter);

                            // compile the regEx str using the custom delimiter/separator
                            var match = /(D|S|\r\n|\n|\r|[^DS\r\n]+)/;
                            var matchSrc = match.source;
                            matchSrc = matchSrc.replace(/S/g, escSeparator);
                            matchSrc = matchSrc.replace(/D/g, escDelimiter);
                            match = new RegExp(matchSrc, 'gm');

                            // put on your fancy pants...
                            // process control chars individually, use look-ahead on non-control chars
                            csv.replace(match, function (m0) {
                                if(exit) {
                                    return;
                                }
                                switch (state) {
                                    // the start of a value
                                    case 0:
                                        // null last value
                                        if (m0 === separator) {
                                            value += '';
                                            endOfValue();
                                            break;
                                        }
                                        // opening delimiter
                                        if (m0 === delimiter) {
                                            state = 1;
                                            break;
                                        }
                                        // null last value
                                        if (/^(\r\n|\n|\r)$/.test(m0)) {
                                            endOfValue();
                                            endOfEntry();
                                            break;
                                        }
                                        // un-delimited value
                                        value += m0;
                                        state = 3;
                                        break;

                                    // delimited input
                                    case 1:
                                        // second delimiter? check further
                                        if (m0 === delimiter) {
                                            state = 2;
                                            break;
                                        }
                                        // delimited data
                                        value += m0;
                                        state = 1;
                                        break;

                                    // delimiter found in delimited input
                                    case 2:
                                        // escaped delimiter?
                                        if (m0 === delimiter) {
                                            value += m0;
                                            state = 1;
                                            break;
                                        }
                                        // null value
                                        if (m0 === separator) {
                                            endOfValue();
                                            break;
                                        }
                                        // end of entry
                                        if (/^(\r\n|\n|\r)$/.test(m0)) {
                                            endOfValue();
                                            endOfEntry();
                                            break;
                                        }
                                        // broken paser?
                                        throw new Error('CSVDataError: Illegal State [Row:' + options.state.rowNum + '][Col:' + options.state.colNum + ']');

                                    // un-delimited input
                                    case 3:
                                        // null last value
                                        if (m0 === separator) {
                                            endOfValue();
                                            break;
                                        }
                                        // end of entry
                                        if (/^(\r\n|\n|\r)$/.test(m0)) {
                                            endOfValue();
                                            endOfEntry();
                                            break;
                                        }
                                        if (m0 === delimiter) {
                                            // non-compliant data
                                            throw new Error('CSVDataError: Illegal Quote [Row:' + options.state.rowNum + '][Col:' + options.state.colNum + ']');
                                        }
                                        // broken parser?
                                        throw new Error('CSVDataError: Illegal Data [Row:' + options.state.rowNum + '][Col:' + options.state.colNum + ']');
                                    default:
                                        // shenanigans
                                        throw new Error('CSVDataError: Unknown State [Row:' + options.state.rowNum + '][Col:' + options.state.colNum + ']');
                                }
                                //console.log('val:' + m0 + ' state:' + state);
                            });

                            // submit the last entry
                            // ignore null last line
                            if(entry.length !== 0) {
                                endOfValue();
                                endOfEntry();
                            }

                            return data;
                        },

                        // a csv-specific line splitter
                        splitLines: function(csv, options) {
                            // cache settings
                            var separator = options.separator;
                            var delimiter = options.delimiter;

                            // set initial state if it's missing
                            if(!options.state.rowNum) {
                                options.state.rowNum = 1;
                            }

                            // clear initial state
                            var entries = [];
                            var state = 0;
                            var entry = '';
                            var exit = false;

                            function endOfLine() {
                                // reset the state
                                state = 0;

                                // if 'start' hasn't been met, don't output
                                if(options.start && options.state.rowNum < options.start) {
                                    // update global state
                                    entry = '';
                                    options.state.rowNum++;
                                    return;
                                }

                                if(options.onParseEntry === undefined) {
                                    // onParseEntry hook not set
                                    entries.push(entry);
                                } else {
                                    var hookVal = options.onParseEntry(entry, options.state); // onParseEntry Hook
                                    // false skips the row, configurable through a hook
                                    if(hookVal !== false) {
                                        entries.push(hookVal);
                                    }
                                }

                                // cleanup
                                entry = '';

                                // if 'end' is met, stop parsing
                                if(options.end && options.state.rowNum >= options.end) {
                                    exit = true;
                                }

                                // update global state
                                options.state.rowNum++;
                            }

                            // escape regex-specific control chars
                            var escSeparator = RegExp.escape(separator);
                            var escDelimiter = RegExp.escape(delimiter);

                            // compile the regEx str using the custom delimiter/separator
                            var match = /(D|S|\n|\r|[^DS\r\n]+)/;
                            var matchSrc = match.source;
                            matchSrc = matchSrc.replace(/S/g, escSeparator);
                            matchSrc = matchSrc.replace(/D/g, escDelimiter);
                            match = new RegExp(matchSrc, 'gm');

                            // put on your fancy pants...
                            // process control chars individually, use look-ahead on non-control chars
                            csv.replace(match, function (m0) {
                                if(exit) {
                                    return;
                                }
                                switch (state) {
                                    // the start of a value/entry
                                    case 0:
                                        // null value
                                        if (m0 === separator) {
                                            entry += m0;
                                            state = 0;
                                            break;
                                        }
                                        // opening delimiter
                                        if (m0 === delimiter) {
                                            entry += m0;
                                            state = 1;
                                            break;
                                        }
                                        // end of line
                                        if (m0 === '\n') {
                                            endOfLine();
                                            break;
                                        }
                                        // phantom carriage return
                                        if (/^\r$/.test(m0)) {
                                            break;
                                        }
                                        // un-delimit value
                                        entry += m0;
                                        state = 3;
                                        break;

                                    // delimited input
                                    case 1:
                                        // second delimiter? check further
                                        if (m0 === delimiter) {
                                            entry += m0;
                                            state = 2;
                                            break;
                                        }
                                        // delimited data
                                        entry += m0;
                                        state = 1;
                                        break;

                                    // delimiter found in delimited input
                                    case 2:
                                        // escaped delimiter?
                                        var prevChar = entry.substr(entry.length - 1);
                                        if (m0 === delimiter && prevChar === delimiter) {
                                            entry += m0;
                                            state = 1;
                                            break;
                                        }
                                        // end of value
                                        if (m0 === separator) {
                                            entry += m0;
                                            state = 0;
                                            break;
                                        }
                                        // end of line
                                        if (m0 === '\n') {
                                            endOfLine();
                                            break;
                                        }
                                        // phantom carriage return
                                        if (m0 === '\r') {
                                            break;
                                        }
                                        // broken paser?
                                        throw new Error('CSVDataError: Illegal state [Row:' + options.state.rowNum + ']');

                                    // un-delimited input
                                    case 3:
                                        // null value
                                        if (m0 === separator) {
                                            entry += m0;
                                            state = 0;
                                            break;
                                        }
                                        // end of line
                                        if (m0 === '\n') {
                                            endOfLine();
                                            break;
                                        }
                                        // phantom carriage return
                                        if (m0 === '\r') {
                                            break;
                                        }
                                        // non-compliant data
                                        if (m0 === delimiter) {
                                            throw new Error('CSVDataError: Illegal quote [Row:' + options.state.rowNum + ']');
                                        }
                                        // broken parser?
                                        throw new Error('CSVDataError: Illegal state [Row:' + options.state.rowNum + ']');
                                    default:
                                        // shenanigans
                                        throw new Error('CSVDataError: Unknown state [Row:' + options.state.rowNum + ']');
                                }
                                //console.log('val:' + m0 + ' state:' + state);
                            });

                            // submit the last entry
                            // ignore null last line
                            if(entry !== '') {
                                endOfLine();
                            }

                            return entries;
                        },

                        // a csv entry parser
                        parseEntry: function(csv, options) {
                            // cache settings
                            var separator = options.separator;
                            var delimiter = options.delimiter;

                            // set initial state if it's missing
                            if(!options.state.rowNum) {
                                options.state.rowNum = 1;
                            }
                            if(!options.state.colNum) {
                                options.state.colNum = 1;
                            }

                            // clear initial state
                            var entry = [];
                            var state = 0;
                            var value = '';

                            function endOfValue() {
                                if(options.onParseValue === undefined) {
                                    // onParseValue hook not set
                                    entry.push(value);
                                } else {
                                    var hook = options.onParseValue(value, options.state); // onParseValue Hook
                                    // false skips the value, configurable through a hook
                                    if(hook !== false) {
                                        entry.push(hook);
                                    }
                                }
                                // reset the state
                                value = '';
                                state = 0;
                                // update global state
                                options.state.colNum++;
                            }

                            // checked for a cached regEx first
                            if(!options.match) {
                                // escape regex-specific control chars
                                var escSeparator = RegExp.escape(separator);
                                var escDelimiter = RegExp.escape(delimiter);

                                // compile the regEx str using the custom delimiter/separator
                                var match = /(D|S|\n|\r|[^DS\r\n]+)/;
                                var matchSrc = match.source;
                                matchSrc = matchSrc.replace(/S/g, escSeparator);
                                matchSrc = matchSrc.replace(/D/g, escDelimiter);
                                options.match = new RegExp(matchSrc, 'gm');
                            }

                            // put on your fancy pants...
                            // process control chars individually, use look-ahead on non-control chars
                            csv.replace(options.match, function (m0) {
                                switch (state) {
                                    // the start of a value
                                    case 0:
                                        // null last value
                                        if (m0 === separator) {
                                            value += '';
                                            endOfValue();
                                            break;
                                        }
                                        // opening delimiter
                                        if (m0 === delimiter) {
                                            state = 1;
                                            break;
                                        }
                                        // skip un-delimited new-lines
                                        if (m0 === '\n' || m0 === '\r') {
                                            break;
                                        }
                                        // un-delimited value
                                        value += m0;
                                        state = 3;
                                        break;

                                    // delimited input
                                    case 1:
                                        // second delimiter? check further
                                        if (m0 === delimiter) {
                                            state = 2;
                                            break;
                                        }
                                        // delimited data
                                        value += m0;
                                        state = 1;
                                        break;

                                    // delimiter found in delimited input
                                    case 2:
                                        // escaped delimiter?
                                        if (m0 === delimiter) {
                                            value += m0;
                                            state = 1;
                                            break;
                                        }
                                        // null value
                                        if (m0 === separator) {
                                            endOfValue();
                                            break;
                                        }
                                        // skip un-delimited new-lines
                                        if (m0 === '\n' || m0 === '\r') {
                                            break;
                                        }
                                        // broken paser?
                                        throw new Error('CSVDataError: Illegal State [Row:' + options.state.rowNum + '][Col:' + options.state.colNum + ']');

                                    // un-delimited input
                                    case 3:
                                        // null last value
                                        if (m0 === separator) {
                                            endOfValue();
                                            break;
                                        }
                                        // skip un-delimited new-lines
                                        if (m0 === '\n' || m0 === '\r') {
                                            break;
                                        }
                                        // non-compliant data
                                        if (m0 === delimiter) {
                                            throw new Error('CSVDataError: Illegal Quote [Row:' + options.state.rowNum + '][Col:' + options.state.colNum + ']');
                                        }
                                        // broken parser?
                                        throw new Error('CSVDataError: Illegal Data [Row:' + options.state.rowNum + '][Col:' + options.state.colNum + ']');
                                    default:
                                        // shenanigans
                                        throw new Error('CSVDataError: Unknown State [Row:' + options.state.rowNum + '][Col:' + options.state.colNum + ']');
                                }
                                //console.log('val:' + m0 + ' state:' + state);
                            });

                            // submit the last value
                            endOfValue();

                            return entry;
                        }
                    },

                    helpers: {

                        /**
                         * $.csv.helpers.collectPropertyNames(objectsArray)
                         * Collects all unique property names from all passed objects.
                         *
                         * @param {Array} objects Objects to collect properties from.
                         *
                         * Returns an array of property names (array will be empty,
                         * if objects have no own properties).
                         */
                        collectPropertyNames: function (objects) {

                            var o, propName, props = [];
                            for (o in objects) {
                                for (propName in objects[o]) {
                                    if ((objects[o].hasOwnProperty(propName)) &&
                                        (props.indexOf(propName) < 0) &&
                                        (typeof objects[o][propName] !== 'function')) {

                                        props.push(propName);
                                    }
                                }
                            }
                            return props;
                        }
                    },

                    /**
                     * $.csv.toArray(csv)
                     * Converts a CSV entry string to a javascript array.
                     *
                     * @param {Array} csv The string containing the CSV data.
                     * @param {Object} [options] An object containing user-defined options.
                     * @param {Character} [separator] An override for the separator character. Defaults to a comma(,).
                     * @param {Character} [delimiter] An override for the delimiter character. Defaults to a double-quote(").
                     *
                     * This method deals with simple CSV strings only. It's useful if you only
                     * need to parse a single entry. If you need to parse more than one line,
                     * use $.csv2Array instead.
                     */
                    toArray: function(csv, options, callback) {
                        options = (options !== undefined ? options : {});
                        var config = {};
                        config.callback = ((callback !== undefined && typeof(callback) === 'function') ? callback : false);
                        config.separator = 'separator' in options ? options.separator : $.csv.defaults.separator;
                        config.delimiter = 'delimiter' in options ? options.delimiter : $.csv.defaults.delimiter;
                        var state = (options.state !== undefined ? options.state : {});

                        // setup
                        options = {
                            delimiter: config.delimiter,
                            separator: config.separator,
                            onParseEntry: options.onParseEntry,
                            onParseValue: options.onParseValue,
                            state: state
                        };

                        var entry = $.csv.parsers.parseEntry(csv, options);

                        // push the value to a callback if one is defined
                        if(!config.callback) {
                            return entry;
                        } else {
                            config.callback('', entry);
                        }
                    },

                    /**
                     * $.csv.toArrays(csv)
                     * Converts a CSV string to a javascript array.
                     *
                     * @param {String} csv The string containing the raw CSV data.
                     * @param {Object} [options] An object containing user-defined options.
                     * @param {Character} [separator] An override for the separator character. Defaults to a comma(,).
                     * @param {Character} [delimiter] An override for the delimiter character. Defaults to a double-quote(").
                     *
                     * This method deals with multi-line CSV. The breakdown is simple. The first
                     * dimension of the array represents the line (or entry/row) while the second
                     * dimension contains the values (or values/columns).
                     */
                    toArrays: function(csv, options, callback) {
                        options = (options !== undefined ? options : {});
                        var config = {};
                        config.callback = ((callback !== undefined && typeof(callback) === 'function') ? callback : false);
                        config.separator = 'separator' in options ? options.separator : $.csv.defaults.separator;
                        config.delimiter = 'delimiter' in options ? options.delimiter : $.csv.defaults.delimiter;

                        // setup
                        var data = [];
                        options = {
                            delimiter: config.delimiter,
                            separator: config.separator,
                            onPreParse: options.onPreParse,
                            onParseEntry: options.onParseEntry,
                            onParseValue: options.onParseValue,
                            onPostParse: options.onPostParse,
                            start: options.start,
                            end: options.end,
                            state: {
                                rowNum: 1,
                                colNum: 1
                            }
                        };

                        // onPreParse hook
                        if(options.onPreParse !== undefined) {
                            options.onPreParse(csv, options.state);
                        }

                        // parse the data
                        data = $.csv.parsers.parse(csv, options);

                        // onPostParse hook
                        if(options.onPostParse !== undefined) {
                            options.onPostParse(data, options.state);
                        }

                        // push the value to a callback if one is defined
                        if(!config.callback) {
                            return data;
                        } else {
                            config.callback('', data);
                        }
                    },

                    /**
                     * $.csv.toObjects(csv)
                     * Converts a CSV string to a javascript object.
                     * @param {String} csv The string containing the raw CSV data.
                     * @param {Object} [options] An object containing user-defined options.
                     * @param {Character} [separator] An override for the separator character. Defaults to a comma(,).
                     * @param {Character} [delimiter] An override for the delimiter character. Defaults to a double-quote(").
                     * @param {Boolean} [headers] Indicates whether the data contains a header line. Defaults to true.
                     *
                     * This method deals with multi-line CSV strings. Where the headers line is
                     * used as the key for each value per entry.
                     */
                    toObjects: function(csv, options, callback) {
                        options = (options !== undefined ? options : {});
                        var config = {};
                        config.callback = ((callback !== undefined && typeof(callback) === 'function') ? callback : false);
                        config.separator = 'separator' in options ? options.separator : $.csv.defaults.separator;
                        config.delimiter = 'delimiter' in options ? options.delimiter : $.csv.defaults.delimiter;
                        config.headers = 'headers' in options ? options.headers : $.csv.defaults.headers;
                        options.start = 'start' in options ? options.start : 1;

                        // account for headers
                        if(config.headers) {
                            options.start++;
                        }
                        if(options.end && config.headers) {
                            options.end++;
                        }

                        // setup
                        var lines = [];
                        var data = [];

                        options = {
                            delimiter: config.delimiter,
                            separator: config.separator,
                            onPreParse: options.onPreParse,
                            onParseEntry: options.onParseEntry,
                            onParseValue: options.onParseValue,
                            onPostParse: options.onPostParse,
                            start: options.start,
                            end: options.end,
                            state: {
                                rowNum: 1,
                               colNum: 1
                            },
                            match: false,
                            transform: options.transform
                        };

                        // fetch the headers
                        var headerOptions = {
                            delimiter: config.delimiter,
                            separator: config.separator,
                            start: 1,
                            end: 1,
                            state: {
                                rowNum:1,
                                colNum:1
                            }
                        };

                        // onPreParse hook
                        if(options.onPreParse !== undefined) {
                            options.onPreParse(csv, options.state);
                        }

                        // parse the csv
                        var headerLine = $.csv.parsers.splitLines(csv, headerOptions);
                        var headers = $.csv.toArray(headerLine[0], options);

                        // fetch the data
                        lines = $.csv.parsers.splitLines(csv, options);

                        // reset the state for re-use
                        options.state.colNum = 1;
                        if(headers){
                            options.state.rowNum = 2;
                        } else {
                            options.state.rowNum = 1;
                        }

                        // convert data to objects
                        for(var i=0, len=lines.length; i<len; i++) {
                            var entry = $.csv.toArray(lines[i], options);
                            var object = {};
                            for(var j=0; j <headers.length; j++) {
                                object[headers[j]] = entry[j];
                            }
                            if (options.transform !== undefined) {
                                data.push(options.transform.call(undefined, object));
                            } else {
                                data.push(object);
                            }

                            // update row state
                            options.state.rowNum++;
                        }

                        // onPostParse hook
                        if(options.onPostParse !== undefined) {
                            options.onPostParse(data, options.state);
                        }

                        // push the value to a callback if one is defined
                        if(!config.callback) {
                            return data;
                        } else {
                            config.callback('', data);
                        }
                    },

                    /**
                     * $.csv.fromArrays(arrays)
                     * Converts a javascript array to a CSV String.
                     *
                     * @param {Array} arrays An array containing an array of CSV entries.
                     * @param {Object} [options] An object containing user-defined options.
                     * @param {Character} [separator] An override for the separator character. Defaults to a comma(,).
                     * @param {Character} [delimiter] An override for the delimiter character. Defaults to a double-quote(").
                     *
                     * This method generates a CSV file from an array of arrays (representing entries).
                     */
                    fromArrays: function(arrays, options, callback) {
                        options = (options !== undefined ? options : {});
                        var config = {};
                        config.callback = ((callback !== undefined && typeof(callback) === 'function') ? callback : false);
                        config.separator = 'separator' in options ? options.separator : $.csv.defaults.separator;
                        config.delimiter = 'delimiter' in options ? options.delimiter : $.csv.defaults.delimiter;

                        var output = '',
                            line,
                            lineValues,
                            i, j;

                        for (i = 0; i < arrays.length; i++) {
                            line = arrays[i];
                            lineValues = [];
                            for (j = 0; j < line.length; j++) {
                                var strValue = (line[j] === undefined || line[j] === null) ? '' : line[j].toString();
                                if (strValue.indexOf(config.delimiter) > -1) {
                                    strValue = strValue.replace(new RegExp(config.delimiter, 'g'), config.delimiter + config.delimiter);
                                }

                                var escMatcher = '\n|\r|S|D';
                                escMatcher = escMatcher.replace('S', config.separator);
                                escMatcher = escMatcher.replace('D', config.delimiter);

                                if (strValue.search(escMatcher) > -1) {
                                    strValue = config.delimiter + strValue + config.delimiter;
                                }
                                lineValues.push(strValue);
                            }
                            output += lineValues.join(config.separator) + '\r\n';
                        }

                        // push the value to a callback if one is defined
                        if(!config.callback) {
                            return output;
                        } else {
                            config.callback('', output);
                        }
                    },

                    /**
                     * $.csv.fromObjects(objects)
                     * Converts a javascript dictionary to a CSV string.
                     *
                     * @param {Object} objects An array of objects containing the data.
                     * @param {Object} [options] An object containing user-defined options.
                     * @param {Character} [separator] An override for the separator character. Defaults to a comma(,).
                     * @param {Character} [delimiter] An override for the delimiter character. Defaults to a double-quote(").
                     * @param {Character} [sortOrder] Sort order of columns (named after
                     *   object properties). Use 'alpha' for alphabetic. Default is 'declare',
                     *   which means, that properties will _probably_ appear in order they were
                     *   declared for the object. But without any guarantee.
                     * @param {Character or Array} [manualOrder] Manually order columns. May be
                     * a strin in a same csv format as an output or an array of header names
                     * (array items won't be parsed). All the properties, not present in
                     * `manualOrder` will be appended to the end in accordance with `sortOrder`
                     * option. So the `manualOrder` always takes preference, if present.
                     *
                     * This method generates a CSV file from an array of objects (name:value pairs).
                     * It starts by detecting the headers and adding them as the first line of
                     * the CSV file, followed by a structured dump of the data.
                     */
                    fromObjects: function(objects, options, callback) {
                        options = (options !== undefined ? options : {});
                        var config = {};
                        config.callback = ((callback !== undefined && typeof(callback) === 'function') ? callback : false);
                        config.separator = 'separator' in options ? options.separator : $.csv.defaults.separator;
                        config.delimiter = 'delimiter' in options ? options.delimiter : $.csv.defaults.delimiter;
                        config.headers = 'headers' in options ? options.headers : $.csv.defaults.headers;
                        config.sortOrder = 'sortOrder' in options ? options.sortOrder : 'declare';
                        config.manualOrder = 'manualOrder' in options ? options.manualOrder : [];
                        config.transform = options.transform;

                        if (typeof config.manualOrder === 'string') {
                            config.manualOrder = $.csv.toArray(config.manualOrder, config);
                        }

                        if (config.transform !== undefined) {
                            var origObjects = objects;
                            objects = [];

                            var i;
                            for (i = 0; i < origObjects.length; i++) {
                                objects.push(config.transform.call(undefined, origObjects[i]));
                            }
                        }

                        var props = $.csv.helpers.collectPropertyNames(objects);

                        if (config.sortOrder === 'alpha') {
                            props.sort();
                        } // else {} - nothing to do for 'declare' order

                        if (config.manualOrder.length > 0) {

                            var propsManual = [].concat(config.manualOrder);
                            var p;
                            for (p = 0; p < props.length; p++) {
                                if (propsManual.indexOf( props[p] ) < 0) {
                                    propsManual.push( props[p] );
                                }
                            }
                            props = propsManual;
                        }

                        var o, p, line, output = [], propName;
                        if (config.headers) {
                            output.push(props);
                        }

                        for (o = 0; o < objects.length; o++) {
                            line = [];
                            for (p = 0; p < props.length; p++) {
                                propName = props[p];
                                if (propName in objects[o] && typeof objects[o][propName] !== 'function') {
                                    line.push(objects[o][propName]);
                                } else {
                                    line.push('');
                                }
                            }
                            output.push(line);
                        }

                        // push the value to a callback if one is defined
                        return $.csv.fromArrays(output, options, config.callback);
                    }
                };

                // Maintenance code to maintain backward-compatibility
                // Will be removed in release 1.0
                $.csvEntry2Array = $.csv.toArray;
                $.csv2Array = $.csv.toArrays;
                $.csv2Dictionary = $.csv.toObjects;

                // CommonJS module is defined
                if (typeof module !== 'undefined' && module.exports) {
                    module.exports = $.csv;
                }

            });
        </script>
        <script>

        //文件导入事件
        $(".upload").on('click', function() {
            var fileInput = document.getElementById('import');
//            fileInput.outerHTML = fileInput.outerHTML; //清空文件选择
            fileInput.click();
            fileInput.addEventListener('change', function() {
                if(!fileInput.value){
                     console.log("no file chosed");
                    return;
                }
                var file = fileInput.files[0];
                console.log(file);
                var reader = new FileReader();
                reader.onload = function(event) {
                    var csvdata = event.target.result;
                    var data = $.csv.toObjects(csvdata);
                    console.log(csvdata);
                    $.ajax({
                        url: "<?= Url::to(['oa-goods/import'])?>",
                        type: 'post',
                        data: {
                            data:JSON.stringify({'data': data})
                        },
                        success: function(result){
                            if (result.code){
                                alert('上传出错，请检查上传文件！');
                            }
                            else {
                                $("[name='refresh']").click();
                                alert('上传成功！');
                            }
                        }

                    });
                    console.log(data);

                };
                reader.readAsText(file,'GB2312');

            });
//            fileInput.outerHTML = fileInput.outerHTML; //清空选择的文件
        })
    </script>

</div>

