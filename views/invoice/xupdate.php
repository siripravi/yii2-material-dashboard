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
<div class="invoice-wrapper">
    <div class="row">
          <div class="col-12">
        <?php if (!empty($model->invoice_id)): ?>

                <!--<form method=class="form-horizontal" ng2-submit="saveItems(<= $model->invoice_id; ?>)" ng2:controller="InvoiceController"> -->
                <?= $this->render('_invheader', ['model' => $model, 'stmt' => $stmt, 'customer' => $stmt->customer, 'delivery'=>$stmt->venue]); ?>
            <?php
            app\components\AngularHelper::begin(
                [
                    'appName' => 'invApp',
                    'appFolder' => dirname(__FILE__) . '/../../' . 'libs/js/app4',
                    'appScripts' => ['accounting.min.js', 'inv.js'],
                    'commonAppScripts' => [
                        dirname(__FILE__) . '/../../' . 'libs/js/common/config_httpProvider.js',
                        dirname(__FILE__) . '/../../' . 'libs/js/common/config_locationProvider.js',
                    ],
                    'requiredModulesScriptNames' => array('route', 'sanitize'),
                    'concatenateAppScripts' => false,
                    'debug' => false,
                ]
            );
            ?>
            <div ng-app="invApp" ng-controller="InvCtrl">
             
                    <?= $this->render('_lineitems', ['model' => $model, 'stmt' => $stmt, 'items' => $model->lineItems, 'angular' => $angular]); ?>
                    <!--?= $this->render('_payitems', ['model' => $model, 'items' => $model->payments, 'pay' => new Payments]);?-->

              
            </div>
            <?php app\components\AngularHelper::end(); ?>
        </div>
<?php else: ?>
    <p>
        <?= Html::a('Create Invoice', ['create'], ['data-toggle' => 'modal', 'data-target' => '#invModal', 'class' => 'btn btn-success']) ?>
    </p>
    <!--?php
    Modal::begin([
        'title' => '<h2>Create Invoice</h2>',
        // 'toggleButton' => ['label' => 'Create New'],
        'id' => 'invModal',
        'clientOptions' => [
            'title' => 'Create  Invoice',
            'modal' => true,
            // 'autoOpen' => false,
            'width' => 500
        ],
    ]);
    ?-->

    <?php
    //Modal::end();
    ?>

<?php endif; ?>
</div>
</div> <!--container fluid-->
<?php
Modal::begin([
    'title' => '<h2>Email Invoice</h2>',
    // 'toggleButton' => ['label' => 'Create New'],
    'id' => 'sendModal',
    'clientOptions' => [
        'title' => 'Send Invoice',
        'modal' => true,
        // 'autoOpen' => false,
        'width' => 500
    ],
]);
?>

<?php

use yii\captcha\Captcha;
use app\models\ContactForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var app\models\ContactForm $model
 */

$contact = new ContactForm();
?>

<?php
Modal::end();
?>

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