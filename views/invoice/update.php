<?php
use yii\bootstrap5\Accordion;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Customer;
use app\models\Payments;
use app\models\Venue;
use yii\jui\DatePicker;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Modal;
use bootui\select2\Select2;

use yii\jui\Dialog;

/**
 * @var yii\web\View $this
 * @var app\models\Invoice $model
 */

//$this->title = ' Invoice: ' . ' #' . $model->INVOICE_NO;
//$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';

//$this->context->layout = '@app/views/views/layouts/column2';

$pk = $model->primaryKey;
?>
<div class="title-wrapper pt-30">
  <div class="row align-items-center">
    <div class="col-md-6">
      <div class="title d-flex align-items-center flex-wrap">
        <h2 class="mr-40">Invoice</h2>
        <a href="#0" class="main-btn primary-btn btn-hover btn-sm">
          <i class="lni lni-plus mr-5"></i> New Invoice</a>
      </div>
    </div>
    <!-- end col -->
    <div class="col-md-6">
      <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#0">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Invoice
            </li>
          </ol>
        </nav>
      </div>
    </div>
    <!-- end col -->
  </div>
  <!-- end row -->
</div>
<?php if (!empty($model->invoice_id)): ?>
  <div class="invoice-wrapper">
    <div class="row">
      <div class="col-12">
        <div class="invoice-card card-style mb-30">
          <?= $this->render('_invheader', ['model' => $model, 'stmt' => $stmt, 'customer' => $stmt->customer, 'delivery' => $stmt->venue,'angular'=>$angular]); ?>
          
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<script>
  // Passing parameters to the script / controller without using placeholders:
  function setYiiParams(params) {
    // (setting them by reference)
    params.id = "<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>";
    params.kf = "<?php echo $pk; ?>";
    params.todoDone = <?php echo (rand(0, 1) > 0 ? 'true' : 'false'); ?>;
    params.assetsFolder = '<?php echo "/assets"; ?>';
  }
</script>