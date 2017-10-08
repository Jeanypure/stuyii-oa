<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DataCenterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-center-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'NID') ?>

    <?= $form->field($model, 'GoodsCategoryID') ?>

    <?= $form->field($model, 'CategoryCode') ?>

    <?= $form->field($model, 'GoodsCode') ?>

    <?= $form->field($model, 'GoodsName') ?>

    <?php // echo $form->field($model, 'ShopTitle') ?>

    <?php // echo $form->field($model, 'SKU') ?>

    <?php // echo $form->field($model, 'BarCode') ?>

    <?php // echo $form->field($model, 'FitCode') ?>

    <?php // echo $form->field($model, 'MultiStyle') ?>

    <?php // echo $form->field($model, 'Material') ?>

    <?php // echo $form->field($model, 'Class') ?>

    <?php // echo $form->field($model, 'Model') ?>

    <?php // echo $form->field($model, 'Unit') ?>

    <?php // echo $form->field($model, 'Style') ?>

    <?php // echo $form->field($model, 'Brand') ?>

    <?php // echo $form->field($model, 'LocationID') ?>

    <?php // echo $form->field($model, 'Quantity') ?>

    <?php // echo $form->field($model, 'SalePrice') ?>

    <?php // echo $form->field($model, 'CostPrice') ?>

    <?php // echo $form->field($model, 'AliasCnName') ?>

    <?php // echo $form->field($model, 'AliasEnName') ?>

    <?php // echo $form->field($model, 'Weight') ?>

    <?php // echo $form->field($model, 'DeclaredValue') ?>

    <?php // echo $form->field($model, 'OriginCountry') ?>

    <?php // echo $form->field($model, 'OriginCountryCode') ?>

    <?php // echo $form->field($model, 'ExpressID') ?>

    <?php // echo $form->field($model, 'Used') ?>

    <?php // echo $form->field($model, 'BmpFileName') ?>

    <?php // echo $form->field($model, 'BmpUrl') ?>

    <?php // echo $form->field($model, 'MaxNum') ?>

    <?php // echo $form->field($model, 'MinNum') ?>

    <?php // echo $form->field($model, 'GoodsCount') ?>

    <?php // echo $form->field($model, 'SupplierID') ?>

    <?php // echo $form->field($model, 'Notes') ?>

    <?php // echo $form->field($model, 'SampleFlag') ?>

    <?php // echo $form->field($model, 'SampleCount') ?>

    <?php // echo $form->field($model, 'SampleMemo') ?>

    <?php // echo $form->field($model, 'CreateDate') ?>

    <?php // echo $form->field($model, 'GroupFlag') ?>

    <?php // echo $form->field($model, 'SalerName') ?>

    <?php // echo $form->field($model, 'SellCount') ?>

    <?php // echo $form->field($model, 'SellDays') ?>

    <?php // echo $form->field($model, 'PackFee') ?>

    <?php // echo $form->field($model, 'PackName') ?>

    <?php // echo $form->field($model, 'GoodsStatus') ?>

    <?php // echo $form->field($model, 'DevDate') ?>

    <?php // echo $form->field($model, 'SalerName2') ?>

    <?php // echo $form->field($model, 'BatchPrice') ?>

    <?php // echo $form->field($model, 'MaxSalePrice') ?>

    <?php // echo $form->field($model, 'RetailPrice') ?>

    <?php // echo $form->field($model, 'MarketPrice') ?>

    <?php // echo $form->field($model, 'PackageCount') ?>

    <?php // echo $form->field($model, 'ChangeStatusTime') ?>

    <?php // echo $form->field($model, 'StockDays') ?>

    <?php // echo $form->field($model, 'StoreID') ?>

    <?php // echo $form->field($model, 'Purchaser') ?>

    <?php // echo $form->field($model, 'LinkUrl') ?>

    <?php // echo $form->field($model, 'LinkUrl2') ?>

    <?php // echo $form->field($model, 'LinkUrl3') ?>

    <?php // echo $form->field($model, 'StockMinAmount') ?>

    <?php // echo $form->field($model, 'MinPrice') ?>

    <?php // echo $form->field($model, 'HSCODE') ?>

    <?php // echo $form->field($model, 'ViewUser') ?>

    <?php // echo $form->field($model, 'InLong') ?>

    <?php // echo $form->field($model, 'InWide') ?>

    <?php // echo $form->field($model, 'InHigh') ?>

    <?php // echo $form->field($model, 'InGrossweight') ?>

    <?php // echo $form->field($model, 'InNetweight') ?>

    <?php // echo $form->field($model, 'OutLong') ?>

    <?php // echo $form->field($model, 'OutWide') ?>

    <?php // echo $form->field($model, 'OutHigh') ?>

    <?php // echo $form->field($model, 'OutGrossweight') ?>

    <?php // echo $form->field($model, 'OutNetweight') ?>

    <?php // echo $form->field($model, 'ShopCarryCost') ?>

    <?php // echo $form->field($model, 'ExchangeRate') ?>

    <?php // echo $form->field($model, 'WebCost') ?>

    <?php // echo $form->field($model, 'PackWeight') ?>

    <?php // echo $form->field($model, 'LogisticsCost') ?>

    <?php // echo $form->field($model, 'GrossRate') ?>

    <?php // echo $form->field($model, 'CalSalePrice') ?>

    <?php // echo $form->field($model, 'CalYunFei') ?>

    <?php // echo $form->field($model, 'CalSaleAllPrice') ?>

    <?php // echo $form->field($model, 'PackMsg') ?>

    <?php // echo $form->field($model, 'ItemUrl') ?>

    <?php // echo $form->field($model, 'IsCharged') ?>

    <?php // echo $form->field($model, 'DelInFile') ?>

    <?php // echo $form->field($model, 'Season') ?>

    <?php // echo $form->field($model, 'IsPowder') ?>

    <?php // echo $form->field($model, 'IsLiquid') ?>

    <?php // echo $form->field($model, 'possessMan1') ?>

    <?php // echo $form->field($model, 'possessMan2') ?>

    <?php // echo $form->field($model, 'LinkUrl4') ?>

    <?php // echo $form->field($model, 'LinkUrl5') ?>

    <?php // echo $form->field($model, 'LinkUrl6') ?>

    <?php // echo $form->field($model, 'isMagnetism') ?>

    <?php // echo $form->field($model, 'NoSalesDate') ?>

    <?php // echo $form->field($model, 'NotUsedReason') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
