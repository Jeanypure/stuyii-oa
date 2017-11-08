<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-11-07
 * Time: 11:09
 */
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
/* @var $this yii\web\View */
/* @var $model backend\models\Channel */
$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Channel',
    ]) . $model->pid;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Channels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pid, 'url' => ['view', 'id' => $model->pid]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="channel-update">

    <?php
        $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL, 'formConfig'=>['labelSpan'=>4]]);
        echo Form::widget([
            'model'=>$model,
            'form'=>$form,
            'columns'=>1,
            'attributes'=>[
                'address_detail' => [   // complex nesting of attributes along with labelSpan and colspan
                    'label'=>'SKU',
                    'labelSpan'=>2,
                    'columns'=>6,
                    'attributes'=>[
                        'GoodsCode'=>[
                            'type'=>Form::INPUT_TEXT,
                            'options'=>['placeholder'=>'Enter address...'],
                            'columnOptions'=>['colspan'=>3],
                        ],

                    ]
                ]
            ]
        ]);
        echo Form::widget([ // fields with labels
            'model'=>$model,
            'form'=>$form,
            'columns'=>2,
            'attributes'=>[
                'GoodsName'=>['label'=>'GoodsName', 'options'=>['placeholder'=>'Province 1...']],
                'PackName'=>['label'=>'PackName', 'options'=>['placeholder'=>'Province 2...']],
            ]
        ]);?>



</div>

