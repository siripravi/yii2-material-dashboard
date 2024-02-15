<?php
use yii\bootstrap\Collapse;

/**
 * @var yii\web\View $this
 * @var app\models\Invoice $model
 */

$this->title = ' Invoice: ' . ' #' . $model->INVOICE_NO;
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->INVOICE_ID, 'url' => ['view', 'id' => $model->INVOICE_ID]];
$this->params['breadcrumbs'][] = 'Update';

$this->context->layout = '@app/views/views/layouts/column2';
echo 'Helloo world';
?>
<?= $this->render('_modal', ['model' => $model]) ?>
<section class="content-header">
	<h1 class="pull-left">
		<?= $this->title ?>
	</h1>
	<span style="margin-left: 10px;" class="label label-default">Not Viewed</span>
	<div class="pull-right">
		<a href="/web/index.php?r=invoice/pdf&id=<?= $model->INVOICE_ID ?>&preview" target="_blank" id="btn-pdf-invoice"
			class="btn btn-default"><i class="fa fa-print"></i> PDF</a>
		<div class="btn-group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				Other <span class="caret"></span>
			</button>
			<ul class="dropdown-menu" role="menu">
				<li><a href="javascript:void(0)" id="btn-enter-payment" class="enter-payment" data-invoice-id="3"
						data-invoice-balance="0.00" data-redirect-to="http://demo.fusioninvoice.com/invoices/3/edit"><i
							class="fa fa-credit-card"></i> Enter Payment</a></li>
				<li><a href="javascript:void(0)" id="btn-copy-invoice"><i class="fa fa-copy"></i> Copy Invoice</a></li>
				<li><a href="#" target="_blank"><i class="fa fa-globe"></i> Public</a></li>
			</ul>
		</div>
		<div class="btn-group">
			<a href="http://demo.fusioninvoice.com/invoices" class="btn btn-default"><i class="fa fa-backward"></i>
				Back</a>
			<button type="submit" id="btn-save-invoice" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i>
				Save</a>
		</div>
	</div>
	<div class="clearfix"></div>
</section>



<?php echo Collapse::widget([
	'items' => [
		// equivalent to the above
		'Header Details' => [
			'content' => $this->render('_invheader', ['model' => $model]),
			// open its content by default

		],
		// another group item
		'Invoice Line Items' => [
			'content' => $this->render('_invitems', ['model' => $model, 'items' => $model->invoiceItems, 'angular' => $angular]),
			'contentOptions' => ['class' => 'in']
			//  'options' => [...],
		],

		// another group item
		'Payment History' => [
			'content' => $this->render('_payitems', ['model' => $model, 'items' => $model->payments, 'pay' => new Payments]),
			//  'contentOptions' => [...],
			//  'options' => [...],
		],
	]
]); ?>