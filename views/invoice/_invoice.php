<?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Customer;
use yii\jui\DatePicker;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
    'fieldConfig' => [
        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
        'horizontalCssClasses' => [
            'label' => 'col-sm-4',
            'offset' => 'col-sm-offset-1',
            'wrapper' => 'col-sm-8',
            'error' => '',
            'hint' => '',
        ],
    ],
]); ?>
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
    <?php //$form->field($model, 'SHIP_DATE') ?>
    <?= $form->field($model, 'SHIP_NAME') ?>
    <?= $form->field($model, 'SHIP_ADD1') ?>
    <?= $form->field($model, 'SHIP_ADD2') ?>
    <?= $form->field($model, 'SHIP_CITY') ?>
    <?= $form->field($model, 'SHIP_STATE') ?>
    <?= $form->field($model, 'SHIP_ZIP') ?>
    <?= $form->field($model, 'SHIP_PHONE1') ?>
    <?= $form->field($model, 'SHIP_PHONE2') ?>
    <?= $form->field($model, 'SHIP_EMAIL1') ?>
    <?= $form->field($model, 'SHIP_DETAILS') ?>
    <?= $form->field($model, 'NOTES') ?>







</div>
<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>


<?php $form = ActiveForm::begin([
    'layout' => 'inline',
    'fieldConfig' => [
        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
        'horizontalCssClasses' => [
            'label' => 'col-sm-4',
            'offset' => 'col-sm-offset-1',
            'wrapper' => 'col-sm-8',
            'error' => '',
            'hint' => '',
        ],
    ],
]); ?>

<div id="inv-itm-detail" class="table-responsive">
    
    <table id="tabl-inv-items" class="table table-light mb-0">
        <thead>    <tr>

                <td colspan="5">
                    <p style="float:left;">
                        <?= Html::a('[+]New Item', Url::to('#'), array('onClick' => 'addItem($(this))', 'class' => 'btn btn-success' /* 'submit'=>'', 'params'=>array('Student[command]'=>'add', 'noValidate'=>true)/**/)); ?>
                    </p>
                </td>
                <td>
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

                </td>
            </tr>
            <tr>

                <td>Description</td>
                <td>Qty</td>
                <td>Price</td>
                <td>Amt.</td>
                <td></td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php $model->itemCount = count($model->invoiceItems);
            $allTotal = 0;
            foreach ($model->invoiceItems as $id => $item): ?>
                <?php
                $item->curRow = $id + 1;
                $item->rowTotal = $item->QUANTITY * $item->PRICE;
                $allTotal += $item->rowTotal;
                ?>
                <?= $this->render('form/itemRow', ['model' => $model, 'id' => $id, 'item' => $item, 'form' => $form]); ?>

            <?php endforeach; ?>

        </tbody>
    </table>
    <table class="table table-striped table-bordered">
        <tbody>
            <tr>
                <td>Grand Total</td>
                <td id="total" style="float:right;width:30%">
                    <?php echo $allTotal; ?>
                </td>
            </tr>
        </tbody>
    </table>
    <?= $this->render('form/_itemJs', ['form' => $form, 'model' => $model, 'allTotal' => $allTotal]); ?>

</div>
<?php ActiveForm::end(); ?>