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

$JS = <<<JS

//选中默认主类目
$("option[value={$catNid}]").attr("selected",true);

//选中默认子类目

$("option:contains({$subCate})").attr("selected",true);

JS;

$this->registerJs($JS);
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


        <?= $form->field($model, 'img',[
            'template' => "<span style='color:red' >*{label}\n</span><div >{input}</div>\n<div >{error}</div>",])
            ->textInput() ?>

        <?php //echo  $form->field($model, 'cate')->textInput() ?>

        <?php //echo $form->field($model, 'subCate')->textInput() ?>

        <?php
        echo $form->field($model,'cate',[
            'template' => "<span style='color:red' >*{label}\n</span><div >{input}</div>\n<div >{error}</div>",])
            ->dropDownList($model->getCatList(0),
            [
                'prompt'=>'--请选择父类--',
                'onchange'=>'           
            $.get("'.Url::to(['oa-goods/category', 'typeid' => 1]).
                    '&typeid=1&pid="+$(this).val(),function(data){
                var str="";
              $("select#oagoods-subcate").children("option").remove();
              $.each(data,function(k,v){
                    str+="<option value="+k+">"+v+"</option>";
                    });
                $("select#oagoods-subcate").html(str);
            });',
            ]);?>

        <?php echo $form->field($model,'subCate',[
            'template' => "<span style='color:red' >*{label}\n</span><div >{input}</div>\n<div >{error}</div>",])
            ->dropDownList($model->getCatList($model->catNid),
            [
                'prompt'=>'--请选择子类--',

            ]);
        ?>

        <?= $form->field($model, 'vendor1')->textInput() ?>

        <?= $form->field($model, 'origin1')->textInput() ?>
        <?php echo  $form->field($model, 'introReason')->textInput(['placeholder' => '--选填--']) ?>



        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
