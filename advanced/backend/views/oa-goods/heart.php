<?php

use yii\bootstrap\Dropdown;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="dropdown-toggle">认领到 <b class="caret"></b></a>
    <?php
    echo Dropdown::widget([
        'items' => [
            ['label' => '正向开发', 'url' => 'forward/?id='.$model->nid],
            ['label' => '逆向开发', 'url' => 'backward/?id='.$model->nid],
        ],
    ]);
    ?>
</div>

