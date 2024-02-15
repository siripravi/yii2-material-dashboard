<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\InvoiceSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="invoice-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'INVOICE_ID') ?>

    <?= $form->field($model, 'INVOICE_NO') ?>

    <?= $form->field($model, 'CUSTOMER_NO') ?>

    <?= $form->field($model, 'INVOICE_DATE') ?>

    <?= $form->field($model, 'SHIP_DATE') ?>

    <?php // echo $form->field($model, 'SHIP_NAME') ?>

    <?php // echo $form->field($model, 'SHIP_ADD1') ?>

    <?php // echo $form->field($model, 'SHIP_ADD2') ?>

    <?php // echo $form->field($model, 'SHIP_CITY') ?>

    <?php // echo $form->field($model, 'SHIP_STATE') ?>

    <?php // echo $form->field($model, 'SHIP_ZIP') ?>

    <?php // echo $form->field($model, 'SHIP_PHONE1') ?>

    <?php // echo $form->field($model, 'SHIP_PHONE2') ?>

    <?php // echo $form->field($model, 'SHIP_EMAIL1') ?>

    <?php // echo $form->field($model, 'SHIP_DETAILS') ?>

    <?php // echo $form->field($model, 'CLOSED') ?>

    <?php // echo $form->field($model, 'NOTES') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>