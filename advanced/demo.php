<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-11-16
 * Time: 9:13
*/
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
/* @var $this yii\web\View */
/* @var $model backend\models\Channel */

$this->title =  '更新平台信息';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '平台信息'), 'url' => ['index']];
$shipping_templates = [
    "template"=>"<div > {label} </div><div class='col-lg-6'>{input}</div>{hint}{error}",
    'labelOptions' => ['class' => 'col-lg-2 control-label']
]
?>

<div class="channel-update">

    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">平台信息</a></li>
        <li role="presentation" ><a href="#">eBay</a></li>
        <li role="presentation"><a href="#">Wish</a></li>
    </ul>
</div>
</br>
<div class="st">
    <p>
        <?= Html::button('保存当前数据', ['id' => 'save-only','class' =>'btn btn-success']) ?>
        <?= Html::button('保存并完善', ['id' => 'save-complete','class' =>'btn btn-info']) ?>
        <?= Html::button('导出刊登模板', ['id' => 'import-templates','class' =>'btn btn-primary']) ?>
    </p>
</div>
<?php $form = ActiveForm::begin([
    'id' => 'msg-form',
    'options' => ['class'=>'form-horizontal'],
    'enableAjaxValidation'=>false,
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-1 control-label'],
    ]
]);
?>

<div class="blockTitle">
    <p >基本信息</p>
</div>
</br>
<?= $form->field($info,'sku')->textInput()?>
<?php
echo '<div class="form-group field-oatemplates-mainpage">
    <label class="col-lg-1 control-label">主图</label>
    <div class="col-lg-3"><input type="text" class="form-control" value="https://www.tupianku.com/view/full/10023/'.$info->sku.'-_0_.jpg"></div>
    <div class="col-lg=1"> 
    <a target="_blank" href="https://www.tupianku.com/view/full/10023/'.$info->sku.'-_0_.jpg">
    <img src="https://www.tupianku.com/view/full/10023/'.$info->sku.'-_0_.jpg" width="50" height="50">
    </a>
    </div>
</div>'
;?>
<?= $form->field($info,'extraPage')->textarea(['style'=>'display:none']); ?>
<?php
for($i=1;$i<=12;$i++){
    echo '<div class="form-group">
    <label class="col-lg-1"></label>
    <div class="col-lg-3"><input  type="text" class="form-control extra-images" value="https://www.tupianku.com/view/full/10023/'.$info->sku.'-_'.$i.'_.jpg"></div>
    <div class="col-lg=1">
    <button  class="btn btn-error remove-image">删除</button>
    <button class="btn btn-error">移动</button>
    <a target="_blank" href="https://www.tupianku.com/view/full/10023/'.$info->sku.'-_'.$i.'_.jpg">
    <img src="https://www.tupianku.com/view/full/10023/'.$info->sku.'-_'.$i.'_.jpg" width="50" height="50">
    </a>
    </div>
</div>';
}
?>
</br>
<?= $form->field($info,'location')->textInput(['value'=>'ShangHai']); ?>
<?= $form->field($info,'country')->textInput(['value' => 'CN' ]); ?>
<?= $form->field($info,'postCode')->textInput(); ?>
<?= $form->field($info,'prepareDay')->textInput(['value' => '3' ]); ?>

<div class="blockTitle">
    <p > 站点组</p>
</div>
</br>
<?= $form->field($info,'site')->textInput(['value' => '美国站' ]); ?>
<div class="blockTitle">
    <p > 多属性</p>
</div>
</br>


<div class="blockTitle">
    <p > 主信息</p>
</div>
</br>
<div>
    <?= $form->field($info,'listedCate')->textInput(); ?>
    <?= $form->field($info,'listedSubcate')->textInput(); ?>
    <?= $form->field($info,'listedSubcate')->textInput(); ?>
    <?= $form->field($info,'title')->textInput(); ?>
    <?= $form->field($info,'subTitle')->textInput(); ?>
    <?= $form->field($info,'description')->textarea(['rows'=>6]); ?>
    <?= $form->field($info,'quantity')->textInput(); ?>
    <?= $form->field($info,'nowPrice')->textInput(); ?>
    <?= $form->field($info,'UPC')->textInput(['value' => 'Does not apply']); ?>
    <?= $form->field($info,'EAN')->textInput(['value' => 'Does not apply']); ?>
</div>

<div class="blockTitle">
    <p >物品属性</p>
</div>
</br>
<?= $form->field($info,'Brand')->textInput(['value' => 'Unbranded']); ?>
<?= $form->field($info,'MPN')->textInput(['value' => 'Does not apply']); ?>
<?= $form->field($info,'Color')->textInput(); ?>
<?= $form->field($info,'Type')->textInput(); ?>
<?= $form->field($info,'Material')->textInput(); ?>
<?= $form->field($info,'IntendedUse')->textInput(); ?>
<?= $form->field($info,'unit')->textInput(); ?>
<?= $form->field($info,'bundleListing')->textInput(); ?>
<?= $form->field($info,'shape')->textInput(); ?>
<?= $form->field($info,'features')->textInput(); ?>
<?= $form->field($info,'regionManufacture')->textInput(['value' => 'China']); ?>

<div class="blockTitle">
    <p >物流设置</p>

</div>
</br
<div>
    <div class="row" >
        <div class="col-lg-6">
            <span>境内运输方式</span>
            <?= $form->field($info,'InshippingMethod1',$shipping_templates)->textInput(['class' => 'col-lg-6']); ?>
            <?= $form->field($info,'InFirstCost1',$shipping_templates)->textInput(); ?>
            <?= $form->field($info,'InSuccessorCost1',$shipping_templates)->textInput(); ?>
            <?= $form->field($info,'InshippingMethod2',$shipping_templates)->textInput(); ?>
            <?= $form->field($info,'InFirstCost2',$shipping_templates)->textInput(); ?>
            <?= $form->field($info,'InSuccessorCost2',$shipping_templates)->textInput(); ?>
        </div>
        <div class="col-lg-6">
            <span>境外运输方式</span>
            <?= $form->field($info,'OutshippingMethod1',$shipping_templates)->textInput(); ?>
            <?= $form->field($info,'OutFirstCost1',$shipping_templates)->textInput(); ?>
            <?= $form->field($info,'OutSuccessorCost1',$shipping_templates)->textInput(); ?>
            <?= $form->field($info,'OutshippingMethod2',$shipping_templates)->textInput(); ?>
            <?= $form->field($info,'OutFirstCost2',$shipping_templates)->textInput(); ?>
            <?= $form->field($info,'OutSuccessorCost2',$shipping_templates)->textInput(); ?>
        </div>
    </div>
</div>


<?php ActiveForm::end() ?>

<style>
    .blockTitle {
        font-size: 16px;
        background-color: #f7f7f7;
        border-top: 0.5px solid #eee;
        border-bottom: 0.5px solid #eee;
        padding: 2px 12px;
        margin-left: -5px;
    }
</style>

<?php
$js  = <<< JS
//删除附加图
$('.remove-image').on('click',function() {
    $(this).closest('div .form-group').remove();
});

//实时刷新图片

$('.extra-images').change(function() {
    
    new_image = $(this).val();
    $(this).parents('div .form-group').find('a').attr('href',new_image);
    $(this).parents('div .form-group').find('img').attr('src',new_image);
}
);




JS;
$this->registerJs($js);


?>
