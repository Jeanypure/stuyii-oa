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
$reCheckUrl = Url::toRoute('backward-recheck');
$trashUrl = Url::toRoute('backward-trash');
$JS = <<<JS

//选中默认主类目
$("option[value={$catNid}]").attr("selected",true);

//选中默认子类目

$("option:contains({$subCate})").attr("selected",true);

//重新提交审核事件
$('#recheck-btn').on('click',function() {
    // $.get('{$reCheckUrl}', {id: '{$model->nid}','type':'backward-products'});
    var form = $("#update-form");
    form.attr('action','{$reCheckUrl}?id={$model->nid}');
    form.submit();
})

//作废事件
$('#trash-btn').on('click', function() {
    $.get('{$trashUrl}',{id:'{$model->nid}'});
})
JS;

$this->registerJs($JS);
?>

<div>
    <?= Html::img($model->img,['width'=>100,'height'=>100])?>
</div>
<div class="oa-goods-update">
    <div class="oa-goods-form">

        <?php $form = ActiveForm::begin([
            'id'=> 'update-form',
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

        <?= $form->field($model, 'origin1')->textInput() ?>

        <?php echo  $form->field($model, 'vendor2')->textInput() ?>
        <?php echo  $form->field($model, 'vendor3')->textInput() ?>

        <?php echo  $form->field($model, 'origin1')->textInput(['placeholder' => '--选填--']) ?>
        <?php echo  $form->field($model, 'origin2')->textInput(['placeholder' => '--选填--']) ?>
        <?php echo  $form->field($model, 'origin3')->textInput(['placeholder' => '--选填--']) ?>

        <?php echo  $form->field($model, 'salePrice')->textInput(['placeholder' => '--选填--']) ?>
        <?php echo  $form->field($model, 'hopeSale')->textInput(['placeholder' => '--选填--']) ?>
        <?php echo  $form->field($model, 'hopeRate')->textInput(['placeholder' => '--选填--']) ?>
        <?php echo  $form->field($model, 'hopeWeight')->textInput(['placeholder' => '--选填--']) ?>
        <?php echo  $form->field($model, 'hopeMonthProfit')->textInput(['readonly'=>true,'placeholder' => '--选填--']) ?>


        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
            <?= Html::button('重新提交审核', ['id'=>'recheck-btn','class' => 'btn btn-info']) ?>
            <?= Html::button('作废', ['id'=>'trash-btn','class' => 'btn btn-danger']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
