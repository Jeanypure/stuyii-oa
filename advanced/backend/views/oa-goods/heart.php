<?php

use yii\bootstrap\Dropdown;
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dropdown">
    <a href="#" data-toggle="dropdown" class="dropdown-toggle">认领到 <b class="caret"></b></a>
    <?php
    echo Dropdown::widget([
        'items' => [
            ['label' => '正向开发', 'url' => Url::to(['forward', 'id' => $model->nid])],
            ['label' => '逆向开发', 'url' => Url::to(['backward', 'id' => $model->nid])],
        ],
    ]);
    ?>
</div>

