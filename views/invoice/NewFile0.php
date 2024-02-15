=================
<div ng-controller="InvCtrl">
	<section class="invoice">

		<?php
		if ($model->primaryKey !== null)
		: ?>

			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="title">Item Details</h4>
					<p class="category">Here is a subtitle for this table</p>
					<div class="row">
						<div class="pull-right">
							<ng-form>
								<fieldset ng-disabled="isSaving" ng-show="invForm.$dirty">

									<?php
									$event = null;

									?>
									<a class="btn btn-lg btn-warning" id="submit_item_button" ng-click="load($event)"
										name="myButton" role="button" aria-disabled="true">
										<i class="fa fa-save"></i> SAVE</a>

								</fieldset>

							</ng-form>
						</div>
					</div>
				</div>

				<div class="panel-body">

					<form name="invForm">
						<table class="table table-hover" id="table-sever-list">
							<thead>
								<tr>
									<th></th>
									<th>Sr#</th>
									<th>Item </th>
									<th>Qty</th>
									<th>Price</th>
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
											<i class=" icon-circle-arrow-down icon-2x"></i>
										</a>
									</td>
									<td>
										<b>{{$index + 1}}</b>
										<input style="width:38px;display:none"
											id="<?php echo 'StatementItems_'; ?>{{$index}}<?php echo 'sequence'; ?>"
											name="<?php echo 'StatementItems['; ?>{{$index}}<?php echo ']sequence'; ?>"
											placeholder="1" type="text" value="{{$index + 1}}">
									</td>
									<td>
										<div ng-hide="editingData[$index + 1]"> {{item.DESCRIPTION}} </div>
										<div ng-show="editingData[$index + 1] || (item.ID == 0)">
											<textarea style="width:423px" ng-model="item.DESCRIPTION"
												name="<?php echo 'StatementItems['; ?>{{$index}}<?php echo ']DESCRIPTION'; ?>"
												id="<?php echo 'StatemetItems_'; ?>{{$index}}<?php echo '_DESCRIPTION'; ?>"></textarea>
										</div>
									</td>
									<td>
										<div ng-hide="editingData[$index + 1]"> {{item.QUANTITY}} </div>
										<textarea ng-show="editingData[$index + 1] || (item.ID == 0)" style="width:80px"
											ng-change="rowTotal($index)"
											class="invoiceColThreeDetails text-center ng-valid ng-dirty" id="cel3-row1"
											name="<?php echo 'StatementItems['; ?>{{$index}}<?php echo ']QUANTITY'; ?>"
											ng-model="item.QUANTITY" placeholder="0" type="text" value=""></textarea>
									</td>
									<td>
										<div ng-hide="editingData[$index + 1]"> {{item.PRICE}} </div>
										<textarea ng-show="editingData[$index + 1] || (item.ID == 0)" style="width:80px"
											ng-change="rowTotal($index)"
											class="invoiceColFourDetails text-center ng-valid ng-dirty" id="cel4-row1"
											name="<?php echo 'StatementItems['; ?>{{$index}}<?php echo ']PRICE'; ?>"
											ng-model="item.PRICE" placeholder="0" type="text" real-time-currency></textarea>
									</td>
									<td style="font-weight:bolder">
										<b>{{rowTotal(item)}}</b>
									</td>

									<td>
										<div class="mailbox-controls" style="padding:5px;">
											<a class="rowOption  btn btn-sm" href="javascript:void(0)"
												title="Delete row (Ctrl+Delete)" ng-click="deleteRow($index)">
												<i class="icon-remove"></i>
											</a>
											&nbsp;&nbsp;
											<a class="rowOption  btn btn-sm" ng-hide="editingData[$index + 1]"
												ng-click="modify($index + 1)">
												<i class="icon-pencil"></i></a>
										</div>
									</td>
								</tr>
							</tbody>
							<!-- end ngRepeat: item in invoice.items -->
						</table>
						<a href="javascript:void(0)" class=" btn btn-success add-item" title="Add new row (Ctrl+Enter)"
							ng-click="addRow()">
							<i class="fa fa-plus"></i> Add Row
						</a>

					</form>
				</div>
			</div>


			<div class="table-responsive">
				<table class="table">
					<tbody>
						<tr>
							<th style="width:50%">Total:</th>
							<td>{{subTotal()}}</td>
						</tr>
						<?php
						if (TRUE)
						: ?>
							<tr>
								<th>Paid</th>
								<td>
									<?php
									if (TRUE)
										echo $model->makeMoney($model->paymentsTotal); ?>
								</td>
							</tr>

							<tr>
								<th>Balance:</th>
								<td>
									<?php echo $model->makeMoney($model->getBalance()); ?>
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>

		<?php endif; ?>
	</section>

</div>