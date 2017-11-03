<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\OaGoods */

$this->title = '更新产品:' . $model->devNum;
$this->params['breadcrumbs'][] = ['label' => '产品推荐', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->devNum, 'url' => ['view', 'id' => $model->nid]];
$this->params['breadcrumbs'][] = '更新';

$catNid = $model->catNid;
$subCate = $model->subCate;
$updateCheckUrl = Url::toRoute('backward-update-check');

$JS = <<<JS

//选中默认主类目
$("option[value={$catNid}]").attr("selected",true);

//选中默认子类目

$("option:contains({$subCate})").attr("selected",true);

//更新并提交审核
$("#update-check-btn").on('click',function() {
    // alert('{$updateCheckUrl}');
    var form = $("#update-form");
    form.attr('action','{$updateCheckUrl}?id={$model->nid}');
    form.submit();
});
JS;

$this->registerJs($JS);
?>

<div>
    <?= Html::img($model->img,['width'=>100,'height'=>100])?>
</div>
<div class="oa-goods-update">
    <div class="oa-goods-form">

        <?php $form = ActiveForm::begin([
            'id' => 'update-form',
            'method' => 'post',
            'fieldConfig'=>[
                'template'=> "{label}\n<div >{input}</div>\n{error}",
            ]
        ]); ?>

        <?= $form->field($model, 'img')->textInput() ?>

        <?php
        echo $form->field($model,'cate')->dropDownList($model->getCatList(0),
            [
                'prompt'=>'--父类--',
                'onchange'=>'           
            $.get("'.yii::$app->urlManager->createUrl('oa-goods/category').
                    '?typeid=1&pid="+$(this).val(),function(data){
                var str="";
              $("select#oaforwardgoods-subcate").children("option").remove();
              $.each(data,function(k,v){
                    str+="<option value="+v+">"+v+"</option>";
                    });
                $("select#oaforwardgoods-subcate").html(str);
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
        <?php echo  $form->field($model, 'hopeRate')->textInput(['placeholder' => '--选填--']) ?>
        <?php echo  $form->field($model, 'hopeWeight')->textInput(['placeholder' => '--选填--']) ?>
        <?php echo  $form->field($model, 'hopeMonthProfit')->textInput(['readonly'=>'true','placeholder' => '--选填--']) ?>


        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
            <?= Html::button('更新并提交审核', ['id'=>'update-check-btn','class' => 'btn btn-info']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
