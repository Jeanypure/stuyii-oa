<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DataCenter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-center-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'GoodsCategoryID')->textInput() ?>

    <?= $form->field($model, 'CategoryCode')->textInput() ?>

    <?= $form->field($model, 'GoodsCode')->textInput() ?>

    <?= $form->field($model, 'GoodsName')->textInput() ?>

    <?= $form->field($model, 'ShopTitle')->textInput() ?>

    <?= $form->field($model, 'SKU')->textInput() ?>

    <?= $form->field($model, 'BarCode')->textInput() ?>

    <?= $form->field($model, 'FitCode')->textInput() ?>

    <?= $form->field($model, 'MultiStyle')->textInput() ?>

    <?= $form->field($model, 'Material')->textInput() ?>

    <?= $form->field($model, 'Class')->textInput() ?>

    <?= $form->field($model, 'Model')->textInput() ?>

    <?= $form->field($model, 'Unit')->textInput() ?>

    <?= $form->field($model, 'Style')->textInput() ?>

    <?= $form->field($model, 'Brand')->textInput() ?>

    <?= $form->field($model, 'LocationID')->textInput() ?>

    <?= $form->field($model, 'Quantity')->textInput() ?>

    <?= $form->field($model, 'SalePrice')->textInput() ?>

    <?= $form->field($model, 'CostPrice')->textInput() ?>

    <?= $form->field($model, 'AliasCnName')->textInput() ?>

    <?= $form->field($model, 'AliasEnName')->textInput() ?>

    <?= $form->field($model, 'Weight')->textInput() ?>

    <?= $form->field($model, 'DeclaredValue')->textInput() ?>

    <?= $form->field($model, 'OriginCountry')->textInput() ?>

    <?= $form->field($model, 'OriginCountryCode')->textInput() ?>

    <?= $form->field($model, 'ExpressID')->textInput() ?>

    <?= $form->field($model, 'Used')->textInput() ?>

    <?= $form->field($model, 'BmpFileName')->textInput() ?>

    <?= $form->field($model, 'BmpUrl')->textInput() ?>

    <?= $form->field($model, 'MaxNum')->textInput() ?>

    <?= $form->field($model, 'MinNum')->textInput() ?>

    <?= $form->field($model, 'GoodsCount')->textInput() ?>

    <?= $form->field($model, 'SupplierID')->textInput() ?>

    <?= $form->field($model, 'Notes')->textInput() ?>

    <?= $form->field($model, 'SampleFlag')->textInput() ?>

    <?= $form->field($model, 'SampleCount')->textInput() ?>

    <?= $form->field($model, 'SampleMemo')->textInput() ?>

    <?= $form->field($model, 'CreateDate')->textInput() ?>

    <?= $form->field($model, 'GroupFlag')->textInput() ?>

    <?= $form->field($model, 'SalerName')->textInput() ?>

    <?= $form->field($model, 'SellCount')->textInput() ?>

    <?= $form->field($model, 'SellDays')->textInput() ?>

    <?= $form->field($model, 'PackFee')->textInput() ?>

    <?= $form->field($model, 'PackName')->textInput() ?>

    <?= $form->field($model, 'GoodsStatus')->textInput() ?>

    <?= $form->field($model, 'DevDate')->textInput() ?>

    <?= $form->field($model, 'SalerName2')->textInput() ?>

    <?= $form->field($model, 'BatchPrice')->textInput() ?>

    <?= $form->field($model, 'MaxSalePrice')->textInput() ?>

    <?= $form->field($model, 'RetailPrice')->textInput() ?>

    <?= $form->field($model, 'MarketPrice')->textInput() ?>

    <?= $form->field($model, 'PackageCount')->textInput() ?>

    <?= $form->field($model, 'ChangeStatusTime')->textInput() ?>

    <?= $form->field($model, 'StockDays')->textInput() ?>

    <?= $form->field($model, 'StoreID')->textInput() ?>

    <?= $form->field($model, 'Purchaser')->textInput() ?>

    <?= $form->field($model, 'LinkUrl')->textInput() ?>

    <?= $form->field($model, 'LinkUrl2')->textInput() ?>

    <?= $form->field($model, 'LinkUrl3')->textInput() ?>

    <?= $form->field($model, 'StockMinAmount')->textInput() ?>

    <?= $form->field($model, 'MinPrice')->textInput() ?>

    <?= $form->field($model, 'HSCODE')->textInput() ?>

    <?= $form->field($model, 'ViewUser')->textInput() ?>

    <?= $form->field($model, 'InLong')->textInput() ?>

    <?= $form->field($model, 'InWide')->textInput() ?>

    <?= $form->field($model, 'InHigh')->textInput() ?>

    <?= $form->field($model, 'InGrossweight')->textInput() ?>

    <?= $form->field($model, 'InNetweight')->textInput() ?>

    <?= $form->field($model, 'OutLong')->textInput() ?>

    <?= $form->field($model, 'OutWide')->textInput() ?>

    <?= $form->field($model, 'OutHigh')->textInput() ?>

    <?= $form->field($model, 'OutGrossweight')->textInput() ?>

    <?= $form->field($model, 'OutNetweight')->textInput() ?>

    <?= $form->field($model, 'ShopCarryCost')->textInput() ?>

    <?= $form->field($model, 'ExchangeRate')->textInput() ?>

    <?= $form->field($model, 'WebCost')->textInput() ?>

    <?= $form->field($model, 'PackWeight')->textInput() ?>

    <?= $form->field($model, 'LogisticsCost')->textInput() ?>

    <?= $form->field($model, 'GrossRate')->textInput() ?>

    <?= $form->field($model, 'CalSalePrice')->textInput() ?>

    <?= $form->field($model, 'CalYunFei')->textInput() ?>

    <?= $form->field($model, 'CalSaleAllPrice')->textInput() ?>

    <?= $form->field($model, 'PackMsg')->textInput() ?>

    <?= $form->field($model, 'ItemUrl')->textInput() ?>

    <?= $form->field($model, 'IsCharged')->textInput() ?>

    <?= $form->field($model, 'DelInFile')->textInput() ?>

    <?= $form->field($model, 'Season')->textInput() ?>

    <?= $form->field($model, 'IsPowder')->textInput() ?>

    <?= $form->field($model, 'IsLiquid')->textInput() ?>

    <?= $form->field($model, 'possessMan1')->textInput() ?>

    <?= $form->field($model, 'possessMan2')->textInput() ?>

    <?= $form->field($model, 'LinkUrl4')->textInput() ?>

    <?= $form->field($model, 'LinkUrl5')->textInput() ?>

    <?= $form->field($model, 'LinkUrl6')->textInput() ?>

    <?= $form->field($model, 'isMagnetism')->textInput() ?>

    <?= $form->field($model, 'NoSalesDate')->textInput() ?>

    <?= $form->field($model, 'NotUsedReason')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
