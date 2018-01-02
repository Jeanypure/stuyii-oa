//window.onload=function (ev) {
//加载分页数量选择框
var params = GetQueryString('pageSize');//获取pageSize初始值
var html = '<li>' +
    '<div class="col-xs-2">' +
    '<div class="input-group">' +
    '<select class="form-control" id="page-size-select" data-style="btn-default" >';
if (params == 0 || params == null) {
    html += '<option value="0" selected>请选择分页数量</option>';
} else {
    html += '<option value="0">请选择分页数量</option>';
}
if (params == 20) {
    html += '<option value="20" selected>20</option>';
} else {
    html += '<option value="20">20</option>';
}
if (params == 50) {
    html += '<option value="50" selected>50</option>';
} else {
    html += '<option value="50">50</option>';
}
if (params == 100) {
    html += '<option value="100" selected>100</option>';
} else {
    html += '<option value="100">100</option>';
}
if (params == 500) {
    html += '<option value="500" selected>500</option>';
} else {
    html += '<option value="500">500</option>';
}
if (params == 1000) {
    html += '<option value="1000" selected>1000</option>';
} else {
    html += '<option value="1000">1000</option>';
}
html += '</select>' +
    '<span class="input-group-addon btn btn-default">' +
    '<span class="glyphicon glyphicon-search"></span>' +
    '</span></div></div></li>';

$('.pagination').append(html);

//分页数量提交
$('body').on('click', '.glyphicon-search', function () {
    var pageSize = $('#page-size-select option:selected').val();
    var search = window.location.search;
    if (pageSize == 0) {
        layer.msg('内容不能为空', {time: 2000, icon: 5});
        return false;
    }
    if (search) {
        //判断当前URL已经含有pageSize参数
        if(params){
            replaceParamVal('pageSize', pageSize);
        }else{
            window.location.href = search + '&pageSize=' + pageSize;
        }
    } else {
        window.location.href = search + '?pageSize=' + pageSize;
    }
});
//翻页刷新页面
$('.pagination a').on('click', function () {
    window.location.href = $(this).attr('href');
});

//获取URL中固定参数值
function GetQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]);
    return null;
}

//替换指定传入参数的值,paramName为参数,replaceWith为新值
function replaceParamVal(paramName, replaceWith) {
    var oUrl = this.location.href.toString();
    var re = eval('/(' + paramName + '=)([^&]*)/gi');
    var nUrl = oUrl.replace(re, paramName + '=' + replaceWith);
    this.location = nUrl;
}

//}

