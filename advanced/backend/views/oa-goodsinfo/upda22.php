<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-09-18
 * Time: 11:56
 */
use yii\bootstrap\Tabs;
$this->title = '更新产品: ' . $info->pid;
$this->params['breadcrumbs'][] = ['label' => '更新产品id', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $info->pid, 'url' => ['view', 'id' => $info->pid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?php
$items[] = [
    'label' => '更新产品',
    'content' => 122,
    'active' => true,
];

$items[] = [
    'label' => '更新SKU',
    'content' => 666

];
echo Tabs::widget([
    'items' => $items,
]);
?>
<?php echo $skuinfo->sid ?>
<?= $this->render('_form', [
    'model' => $info,
]) ?>

