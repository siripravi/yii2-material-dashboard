<?php
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use bootui\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Venue;
use app\models\Customer;
use yii\helpers\Html;

?>
<!--?= $this->render('_modal', ['model' => $model, 'stmt' => $stmt]) ?-->


<div class="container view-animate-container">
    <!-- ngView:  -->
    <div ng-view="" class="am-fade-and-slide-top ng-scope">

        <div ng-controller="ModalInvCtrl" class="ng-scope">
            <script type="text/ng-template" id="myModalContent.html">
    <div class="modal-header">
        <h3>Create Invoice</h3>
    </div>

    <form ng-submit="create()" class="form-horizontal" role="form" >
        <div class="modal-body">

            <div class="form-group">
                <label for="invoiceId" class="col-sm-2 control-label">Invoice#</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="invoiceId" ng-model="invoice.INVOICE_NO" />
                </div>
            </div>

            <div class="form-group">
                <label for="invoiceVenue" class="col-sm-2 control-label">Venue</label>
                    <div class="col-sm-10">
                        <input id="invoiceVenue" type="text"  typeahead-on-select="setVenueId($item)" ng-model="venue.SHIP_NAME" typeahead="venue.SHIP_NAME for venue in venues | filter:$viewValue" />
                        <input ng-hide="true" ng-model="invoice.VENUE_ID" />   <p>{{selVenueId}}{{selAddress1}}</p>
                    </div>
            </div>
            <div class="form-group">
                <label for="invoiceVenue" class="col-sm-2 control-label">Ship Date</label>
                <div class="col-sm-10">
                    <input id="dp" type="text" ng-model="invoice.SHIP_DATE" name="mDate" my-datepicker/>
                </div>
                    <!--  <pre>{{invoice.SHIP_DATE}}</pre>  -->
            </div>
            <div class="form-group">
                <label for="invoiceVenue" class="col-sm-2 control-label">Customer</label>
                <div class="col-sm-10">
                    <input id="invoiceCust" type="text"  typeahead-on-select="setCustId($item)" ng-model="invoice.FIRST_NAME" typeahead="customer.FIRST_NAME for customer in customers | filter:$viewValue" />
                    <input ng-hide="true" ng-model="invoice.CUSTOMER_NO" /><p>{{selCustId}}{{selCustAddress1}}</p>
                </div>
            </div>
        </div>
           <!-- <label>User name</label>
            <input type="text" ng-model="user.user" />
            <label>Password</label>
            <input type="password" ng-model="user.password" />  -->

        <div class="modal-footer">
            <button class="btn btn-warning" ng-click="cancel()">Cancel</button>
            <input type="submit" class="btn primary-btn" value="Submit" />
        </div>
   </form>
</script>

            <button class="btn" ng-click="open()">New Invoice</button>
            <div ng-show="selected" class="ng-binding ng-hide">Selection from a modal: </div>

        </div>
    </div>
</div>
<div id="toast-container" ng-class="config.position" toaster-options="{'position-class': 'toast-top-right'}"
    class="ng-scope toast-top-right"><!-- ngRepeat: toaster in toasters --></div>