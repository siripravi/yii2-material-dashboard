<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row">
    <div class="col-lg-2 form-group">
        <label class="control-label required" for="invoice-invoice_no">Invoice# <span class="required">*</span></label>
        <div class="col-lg-12">
            <?= $form->field($model, 'INVOICE_NO')->textInput(['maxlength' => 10]) ?>
        </div>
    </div>
    <div class="col-lg-3 form-group">
        <label class="control-label required" for="invoice-customer_no">Customer <span class="required">*</span></label>
        <div class="col-lg-12">
            <?= $form->field($model, 'CUSTOMER_NO')->dropDownList(ArrayHelper::map(Customer::find()->all(), 'CUSTOMER_NO', function ($cust) {
                return $cust->FIRST_NAME . ' ' . $cust->LAST_NAME;
            })) ?>
        </div>
    </div>

    <div class="col-lg-2 form-group">
        <label class="control-label required" for="invoice-ship_date">Ship Date <span class="required">*</span></label>
        <div class="col-lg-12">
            <?= $form->field($model, 'SHIP_DATE')->textInput() ?>
        </div>
    </div>
    <div class="col-lg-3 form-group">
        <label class="control-label required" for="invoice-status">Status <span class="required">*</span></label>
        <div class="col-lg-12">
            <?= $form->field($model, 'CLOSED')->checkBox(['maxlength' => 1]) ?>
        </div>
    </div>
</div>
<div class="row">


</div>
<div class="form-inline">







</div>