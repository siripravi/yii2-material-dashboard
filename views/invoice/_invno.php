<div class="card-header">
		<div class="row">
			<div class="col-md-2 text-right">
				<h4>INVOICE</h4>
				<span class="float-end text-muted"> 48 </span>
				<?php echo Editable::widget([
					'name' => 'invoice_id',
					'asPopover' => false,
					'value' => $model->invoice_id,
					'header' => 'Name',
					'size' => 'md',
					'options' => ['class' => 'form-control', 'placeholder' => 'Enter person name...']
				]); ?>
			</div>
		</div>
	</div>

	<div class="tab-pane" id="delivery">
					<div class="col-sm-4 invoice-col">
						Ship To <address>
							<strong>
								<?= $stmt->venue->ship_name ?>
							</strong><br>
							<br>
							Phone: <br>
							Email:
						</address>
					</div>
					<div class="col-sm-4 invoice-col">
						<span class="pull-left"><b>Invoice #</b></span><span class="pull-right">
							<?php echo $model->invoice_id; ?>
							<!--<input id="number" class="form-control input-sm" name="number" type="text" value="INV3">-->
						</span>
						<div class="clearfix"></div>
						<span class="pull-left"><b>Date</b></span><span class="pull-right">
							<?= $stmt->created_at; ?></b>
						</span><br>
						<div class="clearfix"></div>
						<span class="pull-left"><b>Due Date</b></span><span class="pull-right"><input id="due_at"
								class="form-control input-sm" name="due_at" type="text" value="07/11/2014"></span><br>
						<div class="clearfix"></div>
						<span class="pull-left"><b>Status</b></span><span class="pull-right"><select
								id="invoice_status_id" class="form-control input-sm" name="invoice_status_id">
								<option value="1" selected="selected">Draft</option>
								<option value="2">Sent</option>
								<option value="3">Paid</option>
								<option value="4">Canceled</option>
							</select></span>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>			