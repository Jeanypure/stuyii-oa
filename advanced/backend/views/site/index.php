<?php

/* @var $this yii\web\View */

$this->title = '主页';
$js = <<< JS
//设置背景色
$('body').css('background','#FFF');

//删除H1
$('h1').remove();
JS;
$this->registerJs($js);
?>
<div class="site-index">

   <P>这是一个集成应用</P>
</div>
