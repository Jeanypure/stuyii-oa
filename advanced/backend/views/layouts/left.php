<?php
    use mdm\admin\components\MenuHelper;
    $user = yii::$app->user->identity->username;
    $sql = "oaP_statusCount '{$user}'";
    $status_result = yii::$app->db->createCommand($sql)->queryAll();
    $status_map = [];
    foreach ($status_result as $res){
        $status_map[$res['moduletype']] = $res['num'];
    }
//    var_dump($status_map);die;
    $callback = function($menu){
    $data = json_decode($menu['data'], true);
    $items = $menu['children'];
    $return = [
        'label' => $menu['name'],
        'url' => [$menu['route']],
    ];
    //处理我们的配置
    if ($data) {
        //visible
        isset($data['visible']) && $return['visible'] = $data['visible'];
        //icon
        isset($data['icon']) && $data['icon'] && $return['icon'] = $data['icon'];
        //other attribute e.g. class...
        $return['options'] = $data;
    }
    //没配置图标的显示默认图标
    (!isset($return['icon']) || !$return['icon']) && $return['icon'] = 'circle-o';
    $items && $return['items'] = $items;
    return $return;
};

//注册JS 为每个模块加数量
$JS = <<< JS
 //找到产品推荐模块并追加<span>
    $("a span:contains('产品推荐')").after('<sup class="label label-info">{$status_map["产品推荐"]}</sup>');
    $("a span:contains('正向开发')").after('<sup class="label label-warning">{$status_map["正向开发"]}</sup>');
    $("a span:contains('逆向开发')").after('<sup class="label label-success">{$status_map["逆向开发"]}</sup>');
    $("a span:contains('待审批')").after('<sup class="label label-info">{$status_map["待审批"]}</sup>');
    $("a span:contains('已审批')").after('<sup class="label label-warning">{$status_map["已审批"]}</sup>');
    $("a span:contains('未通过')").after('<sup class="label label-success">{$status_map["未通过"]}</sup>');
    $("a span:contains('属性信息')").after('<sup class="label label-info">{$status_map["属性信息"]}</sup>');
    $("a span:contains('图片信息')").after('<sup class="label label-warning">{$status_map["图片信息"]}</sup>');
    $("a span:contains('平台信息')").after('<sup class="label label-success">{$status_map["平台信息"]}</sup>');
    $("a span:contains('产品模板')").after('<sup class="label label-info">{$status_map["产品模板"]}</sup>');

JS;
$this->registerJs($JS);
?>
<aside class="main-sidebar">

    <section class="sidebar">


        <?= dmstr\widgets\Menu::widget(
            [

                'options' => ['class' => 'sidebar-menu'],
                'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id,null,$callback),
            ]
        ) ?>

    </section>

</aside>
