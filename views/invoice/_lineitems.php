<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Collapse;
use app\models\InvoiceItems;
use app\models\Statement;
use app\models\Payments;

/**
 * @var yii\web\View $this
 * @var app\models\InvoiceSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Invoice Items';
$this->params['breadcrumbs'][] = $this->title;

?>

<section class="invoice">
    <?php if ($stmt->primaryKey !== null): ?> 
                    <div class="col-md-2 float-right">
                    <ng-form>
                        <fieldset ng-disabled="isSaving" ng-show="invForm.$dirty">
                            <?php $event = null; ?>
                            <a class="btn btn-primary btn-warning" style="margin-left: 1em" id="submit_item_button" ng-click="load($event)"
                                name="myButton" role="button" aria-disabled="true"><i class="pe-7s-diskette"></i>
                                SAVE</a>

                        </fieldset>
                    </ng-form>
                    
                    </div>               

                <form name="invForm">
                    <table class="table table-hover" id="table-sever-list">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Sr#</th>
                                <th>Item </th>
                                <th>Qty</th>
                                <th>price</th>
                                <th>Amount</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in invoice.items" ng-hide="item.status == 3">
                            <tr class="grid-row ng-scope" ng-repeat="item in invoice.items" ng-hide="item.status == 3">
                                <td>

                                    <a class="rowOption btn btn-sm" href="javascript:void(0)" title="Insert new row"
                                        ng-click="insertRow($index)">
                                        <span class="material-icons">
                                            add
                                        </span>
                                    </a>
                                </td>
                                <td><b>{{$index + 1}}</b>
                                    <input style="width:38px;display:none"
                                        id="<?php echo 'StatementItems_'; ?>{{$index}}<?php echo 'sequence'; ?>"
                                        name="<?php echo 'StatementItems['; ?>{{$index}}<?php echo ']sequence'; ?>"
                                        placeholder="1" type="text" value="{{$index + 1}}">
                                </td>
                                <td>
                                    <div ng-hide="editingData[$index + 1]"> {{item.description}} </div>
                                    <div ng-show="editingData[$index + 1] || (item.id == 0)"><textarea style="width:423px"
                                            ng-model="item.description"
                                            name="<?php echo 'StatementItems['; ?>{{$index}}<?php echo ']description'; ?>"
                                            id="<?php echo 'statemetItems_'; ?>{{$index}}<?php echo '_description'; ?>"></textarea>
                                    </div>
                                </td>
                                <td>
                                    <div ng-hide="editingData[$index + 1]"> {{item.quantity}} </div>
                                    <textarea ng-show="editingData[$index + 1] || (item.id == 0)" style="width:80px"
                                        ng-change="rowTotal($index)"
                                        class="invoiceColThreeDetails text-center ng-valid ng-dirty" id="cel3-row1"
                                        name="<?php echo 'StatementItems['; ?>{{$index}}<?php echo ']quantity'; ?>"
                                        ng-model="item.quantity" placeholder="0" type="text" value=""
                                        ng-focus="item.quantity = null" ng-click="item.quantity = null"></textarea>
                                </td>
                                <td>
                                    <div ng-hide="editingData[$index + 1]"> {{item.price}} </div>
                                    <textarea ng-show="editingData[$index + 1] || (item.id == 0)" style="width:80px"
                                        ng-change="rowTotal($index)"
                                        class="invoiceColFourDetails text-center ng-valid ng-dirty" id="cel4-row1"
                                        name="<?php echo 'StatementItems['; ?>{{$index}}<?php echo ']price'; ?>"
                                        ng-model="item.price" placeholder="0" ng-click="item.price = null"
                                        ng-focus="item.price = null" type="text" real-time-currency></textarea>
                                </td>
                                <td style="font-weight:bolder">
                                    <b>{{rowTotal(item)}}</b>
                                </td>
                                <td>
                                    <div class="mailbox-controls" style="padding:5px;">
                                        <a class="rowOption  btn btn-sm" href="javascript:void(0)"
                                            ng-click="modify($index + 1)">
                                            <span class="material-icons">
                                                edit </span>
                                        </a>
                                        &nbsp;&nbsp;
                                        <a class="rowOption" title="Delete row (Ctrl+Delete)"
                                            ng-hide="editingData[$index + 1]" ng-click="deleteRow($index)"> <span
                                                class="material-icons">
                                                delete_outline </span>

                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <!-- end ngRepeat: item in invoice.items -->
                    </table>

                </form>
                <div class="footer">
                    <a href="javascript:void(0)" class="add-item " title="Add new row (Ctrl+Enter)" ng-click="addRow()">
                        <i class="pe-7s-plus"></i> <b>Add Row</b>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th style="width:50%">Total:</th>
                                <td>{{subTotal()}}</td>
                            </tr>
                            <?php if ($stmt->st_type == Statement::TYPE_INVOICE): ?>
                                <tr>
                                    <th>Paid</th>
                                    <td>
                                        <?php if ($stmt->st_type == Statement::TYPE_INVOICE)
                                            echo Payments::makeMoney($model->paymentsTotal); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Balance:</th>
                                    <td>
                                        <?php echo Payments::makeMoney($model->getBalance()); ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
        
    <?php endif; ?>
</section>