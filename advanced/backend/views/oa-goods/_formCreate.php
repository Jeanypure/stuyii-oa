<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\OaGoods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oa-goods-form">
        <?php $form = ActiveForm::begin([
            'fieldConfig'=>[
                'template'=> "{label}\n<div >{input}</div>\n{error}",
            ]
        ]); ?>

    <?php echo  $form->field($model, 'img',['template' => "<span style='color:red' >*{label}\n</span><div >{input}</div>\n<div >{error}</div>",])->textInput(['placeholder' => '--必填--']) ?>


        <?php //echo $form->field($model, 'subCate')->textInput() ?>


    <?= $form->field($model,'cate',['template' => "<span style='color:red' >*{label}\n</span><div >{input}</div>\n<div >{error}</div>",])->dropDownList($model->getCatList(0),
        [
            'prompt'=>'--请选择父类--',
            'onchange'=>'           
            $.get("'.Url::to(['oa-goods/category', 'typeid' => 1]).
                '&pid="+$(this).val(),function(data){

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

        <?= $form->field($model, 'origin1')->textInput() ?>
        <?php echo  $form->field($model, 'introReason')->textInput(['placeholder' => '--选填--']) ?>



        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>
