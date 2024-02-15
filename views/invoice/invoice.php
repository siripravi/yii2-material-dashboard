<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Venue;

/**
 * @var yii\web\View $this
 * @var app\models\Invoice $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<div class="card">
  <div class="card-header bg-black"></div>
  <div class="card-body">

    <div class="container">
      <div class="row">
        <div class="col-xl-12">
          <i class="far fa-building text-danger fa-6x float-start"></i>
        </div>
      </div>


      <div class="row">
        <div class="col-xl-12">
          <div id="hcard-<?php echo $statement->customer->first_name . '-' . $statement->customer->last_name; ?>"
            class="vcard">

            <div class="org">
              <?php echo $statement->customer->first_name . ' ' . $statement->customer->last_name; ?>
            </div>
            <a class="email" href="mailto:<?php echo $statement->customer->email1; ?>">
              <?php echo $statement->customer->email1; ?>
            </a>

            <div class="adr">
              <div class="street-address">
                <?php echo $statement->customer->address1; ?>
              </div>
              <span class="locality">
                <?php echo $statement->customer->address2; ?>
              </span>

            </div>

            <div class="tel">
              <?php echo $statement->customer->phone1; ?>
            </div>
          </div><!-- e: vcard -->
          <ul class="list-unstyled float-end">
            <li style="font-size: 30px; color: red;">Company</li>
            <li>123, Elm Street</li>
            <li>123-456-789</li>
            <li>mail@mail.com</li>
          </ul>
        </div>
      </div>

      <div class="row text-center">
        <h3 class="text-uppercase text-center mt-3" style="font-size: 40px;">
          <?php echo ($id === 'quote') ? 'Quotation' : 'Invoice'; ?>

        </h3>
        <p>
          <?php echo $invoice->invoice_id; ?>
        </p>
      </div>

      <div class="row mx-3">
        <table class="table">
          <thead>
            <tr>
              <th style="width: 10%">Sr#</th>
              <th style="width: 50%">Item description</th>
              <th style="width: 10%">quantity</th>
              <th style="width: 10%">price Each</th>
              <th style="width: 10%">Amount</th>
            </tr>
          </thead>
          <?php
          //for ($k=0; $k<50; $k++) {
          foreach ($items as $i => $item) { ?>
            <tr>
              <td>
                <?php echo $start; ?>
              </td>
              <td>
                <?php echo $item->description; ?>
              </td>
              <td class="col1">
                <?php echo $item->quantity; ?>
              </td>

              <td class="amount">
                <?php echo Yii::$app->formatter->asCurrency($item->price, 'USD'); ?>
              </td>
              <td class="amount">
                <?php echo Yii::$app->formatter->asCurrency($item->price * $item->quantity, 'USD'); ?>
              </td>

            </tr>

            <?php
            $start += 1;
          }
          ?>
          <tfoot>

            <?php if ($gtot): ?>
              <tr>
                <td rowspan="3" colspan="3"></td>
                <th>Total</th>
                <td class="amount">
                  <?php echo Yii::$app->formatter->asCurrency($grandtotal, 'USD'); ?>
                </td>
              </tr>
              <tr>
                <th>Payments/Credits</th>
                <td class="amount">
                  <?php echo Yii::$app->formatter->asCurrency($invoice->paymentsTotal, 'USD'); ?>
                </td>
              </tr>
              <tr>
                <th>Balance Due</th>
                <td class="amount">
                  <?php echo Yii::$app->formatter->asCurrency($grandtotal - $invoice->paymentsTotal, 'USD'); ?>
                </td>
              </tr>
            <?php else: ?>
              <tr>
                <td rowspan="3" colspan="3"></td>
                <th>Total</th>
                <td class="amount">
                  <?php echo Yii::$app->formatter->asCurrency($subtotal, 'USD'); ?>
                </td>
              </tr>
            <?php endif; ?>
            <tr>

            </tr>
          </tfoot>
        </table>

      </div>
      <!--<div class="row">
        <div class="col-xl-8">
          <ul class="list-unstyled float-end me-0">
            <li><span class="me-3 float-start">Total Amount:</span><i class="fas fa-dollar-sign"></i> 6850,00
            </li>
            <li> <span class="me-5">Discount:</span><i class="fas fa-dollar-sign"></i> 500,00</li>
            <li><span class="float-start" style="margin-right: 35px;">Shippment: </span><i
                class="fas fa-dollar-sign"></i> 500,00</li>
          </ul>
        </div>
      </div>  -->
      <div class="invoice-ship-to">
        <h2>Event/Delivery Place:</h2>
        <div class="vcard">
          <div class="org">
            <?php echo $statement->venue->ship_name; ?>
          </div>

          <div class="adr">
            <div class="street-address">
              <?php echo $statement->venue->ship_add1; ?>
            </div>
            <span class="locality">
              <?php echo $statement->venue->ship_add2; ?>
            </span>
            <span class="locality">
              <?php echo $statement->venue->ship_city; ?>
            </span>
            <span class="state-name">
              <?php echo $statement->venue->ship_state; ?>-
              <?php echo $statement->venue->ship_zip; ?>
            </span>

          </div>

          <div class="tel">
            <span class="skype_c2c_print_container notranslate">Phone:
              <?php echo $statement->venue->ship_phone1; ?>
            </span>
          </div>
        </div><!-- e: vcard -->
      </div><!-- e invoice-to -->
      <div class="invoice-status">
        <?php if ($id === 'invoice'): ?>
          <h3>Invoice Status</h3>
          <strong>Invoice is <em>Unpaid</em></strong>
        <?php endif; ?>
      </div><!-- e: invoice-status -->
      <hr>
      <div class="row">
        <div class="col-xl-8" style="margin-left:60px">
          <p class="float-end"
            style="font-size: 30px; color: red; font-weight: 400;font-family: Arial, Helvetica, sans-serif;">
            Total:
            <span><i class="fas fa-dollar-sign"></i> 6350,00</span>
          </p>
        </div>

      </div>

      <div class="row mt-2 mb-5">
        <p class="fw-bold">Date: <span class="text-muted">23 June 20221</span></p>
        <p class="fw-bold mt-3">Signature:</p>
      </div>

    </div>



  </div>
  <div class="card-footer bg-black"></div>
</div>