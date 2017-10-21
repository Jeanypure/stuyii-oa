<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoods */

$this->title = '更新产品:' . $model->devNum;
$this->params['breadcrumbs'][] = ['label' => '产品推荐', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->devNum, 'url' => ['view', 'id' => $model->nid]];
$this->params['breadcrumbs'][] = '更新';
?>
<div>
    <?= Html::img($model->img,['width'=>100,'height'=>100])?>
</div>
<div class="oa-goods-update">
    <div class="oa-goods-form">

        <?php $form = ActiveForm::begin([
            'fieldConfig'=>[
                'template'=> "{label}\n<div >{input}</div>\n{error}",
            ]
        ]); ?>


        <?= $form->field($model, 'img')->textInput() ?>

        <?php //echo  $form->field($model, 'cate')->textInput() ?>

        <?php //echo $form->field($model, 'subCate')->textInput() ?>

        <?php
        echo $form->field($model,'cate')->dropDownList($model->getCatList(0),
            [
                'prompt'=>'--父类--',
                'onchange'=>'           
            $.get("'.yii::$app->urlManager->createUrl('oa-goods/update').
                    '?id=1&typeid=1&pid="+$(this).val(),function(data){
                var str="";
              $("select#oagoods-subcate").children("option").remove();
              $.each(data,function(k,v){
                    str+="<option value="+v+">"+v+"</option>";
                    });
                $("select#oagoods-subcate").html(str);
            });',
            ]);?>

        <?php echo $form->field($model,'subCate')->dropDownList($model->getCatList($model->catNid),
            [
                'prompt'=>'--请选择子类--',

            ]);
        ?>




        <?= $form->field($model, 'vendor1')->textInput() ?>
        <?php echo  $form->field($model, 'vendor2')->textInput() ?>
        <?php echo  $form->field($model, 'vendor3')->textInput() ?>
        <?= $form->field($model, 'origin1')->textInput() ?>

        <?php echo  $form->field($model, 'origin2')->textInput(['placeholder' => '--选填--']) ?>
        <?php echo  $form->field($model, 'origin3')->textInput(['placeholder' => '--选填--']) ?>

        <?php echo  $form->field($model, 'salePrice')->textInput(['placeholder' => '--选填--']) ?>
        <?php echo  $form->field($model, 'hopeSale')->textInput(['placeholder' => '--选填--']) ?>
        <?php echo  $form->field($model, 'hopeMonthProfit')->textInput(['placeholder' => '--选填--']) ?>
        <?php echo  $form->field($model, 'hopeRate')->textInput(['placeholder' => '--选填--']) ?>
        <?php echo  $form->field($model, 'hopeWeight')->textInput(['placeholder' => '--选填--']) ?>


        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
