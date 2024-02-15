<?php
use kartik\editable\Editable;
use yii\helpers\Url;

use yii\helpers\Html;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="card text-center">
	<div class="card-header">
		<div class="row">
			<div class="col-md-10">
				<ul class="nav nav-tabs card-header-tabs">
					<li class="nav-item">
						<a href="#home" class="nav-link active" data-bs-toggle="tab">Home</a>
					</li>
					<li class="nav-item">
						<a href="#customer" class="nav-link" data-bs-toggle="tab">Billing</a>
					</li>
					<li class="nav-item">
						<a href="#delivery" class="nav-link" data-bs-toggle="tab">Delivery</a>
					</li>
				</ul>
			</div>

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
	<div class="card-body">
		<div class="tab-content">
			<div class="tab-pane fade show active" id="home">
				<h5 class="card-title">Home tab content</h5>
				<p class="card-text">Here is some example text to make up the tab's content. Replace it with your
					own text anytime.</p>
				<a href="#" class="btn btn-primary">Go somewhere</a>
			</div>
			<div class="tab-pane fade" id="customer">				
				<div class="object-form">
					<div id="custContent">
						<?php
						//\yii\widgets\Pjax::begin(['id' => 'pjax-container', 'enablePushState' => false]); ?>
						<?= $this->render('_editcust', ['customer' => $customer,'stmt'=>$stmt]);
						//\yii\widgets\Pjax::end();
						?>
					</div>
				</div>				
			</div>
			<div class="tab-pane fade" id="delivery">
			<div class="object-form">
					<div id="delvContent">
						<?php
						//\yii\widgets\Pjax::begin(['id' => 'pjax-container', 'enablePushState' => false]); ?>
						<?= $this->render('_editdelv', ['delivery' => $delivery,'stmt'=>$stmt]);
						//\yii\widgets\Pjax::end();
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row card-group">
	<div class="col-4">
		<div class="card h-100" style="width: 14rem;">
			<div class="card-body">

				<a href="#" class="btn btn-primary">Go somewhere</a>
			</div>
		</div>
	</div>
	<div class="col-4">
		<div class="card h-100" style="width: 14rem;">
			<div class="card-body">
				<h5 class="card-title">Card title</h5>
				<p class="card-text">Some quick example text to build on the card title and make up the bulk of the
					card's content.</p>
				<button type="button" class="btn btn-primary">Button</button>
			</div>
		</div>
	</div>
	<div class="col-4">
		<div class="card h-100" style="width: 14rem;">
			<div class="card-body">
				<h5 class="card-title">Card title</h5>
				<p class="card-text">Some quick example text to build on the card title and make up the bulk of the
					card's content.</p>
				<button type="button" class="btn btn-primary">Button</button>
			</div>
		</div>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="row invoice-info">

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
				<span class="pull-left"><b>Status</b></span><span class="pull-right"><select id="invoice_status_id"
						class="form-control input-sm" name="invoice_status_id">
						<option value="1" selected="selected">Draft</option>
						<option value="2">Sent</option>
						<option value="3">Paid</option>
						<option value="4">Canceled</option>
					</select></span>
				<div class="clearfix"></div>
			</div>
		</div>

	</div>
	<div class="panel-footer">

		
	</div>
</div>