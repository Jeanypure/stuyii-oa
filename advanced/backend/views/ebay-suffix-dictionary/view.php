<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\WishSuffixDictionary */

//$this->title = $model->nid;
//$this->params['breadcrumbs'][] = ['label' => 'Ebay账号字典', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wish-suffix-dictionary-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ebayName',
            'ebaySuffix',
            'nameCode',
        ],
    ]) ?>
    <table>
        <thead>
        <tr>
            <th>1</th>
            <th>2</th>
            <th>3</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>111</td>
            <td>222</td>
            <td>333</td>
        </tr>
        </tbody>
    </table>