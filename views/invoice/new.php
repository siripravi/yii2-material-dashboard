<?php
use yii\bootstrap5\Accordion;
use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Customer;
use app\models\Payments;
use app\models\Venue;
use kartik\date\DatePicker;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Modal;
use kartik\select2\Select2;
use kartik\typeahead\Typeahead;
//use kartik\select2\Select2;
use yii\jui\Dialog;
use yii\web\JsExpression;

/**
 * @var yii\web\View $this
 * @var app\models\Invoice $model
 */

//$this->title = ' Invoice: ' . ' #' . $model->INVOICE_NO;
//$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';

//$this->context->layout = '@app/views/views/layouts/column2';

//$pk = $model->primaryKey;
?>
<div class="card text-bg-dark mb-3" style="max-width: 18rem;">
  <div class="card-header">Header</div>
  <div class="card-body">
    <h5 class="card-title">Dark card title</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
  </div>
</div>
<section class="section">
    <div class="card border-info mb-3">
        <div class="card-header">
            <h4 class="card-title">Create New Invoice</h4>
        </div>

        <div class="card-body border-info">
            <?php $form = ActiveForm::begin([
                'layout' => 'horizontal',
                'fieldConfig' => [
                    //'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                    'template' => "{label}\n{input}\n{hint}\n{error}\n",
                    'horizontalCssClasses' => [
                        // 'label' => 'col-sm-3',
                        // 'offset' => 'col-sm-offset-1',
                        // 'wrapper' => 'form-elements-wrapper',
                        'error' => '',
                        'hint' => '',
                    ],
                ],
            ]); ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="<?= Html::getInputId($model, 'invoice_id'); ?>">
                            <?= Html::activeLabel($model, 'invoice_id'); ?>
                        </label>
                        <?= $form->field($model, 'invoice_id')->textInput(['maxlength' => true, 'style' => 'width:270px'])->label(false); ?>
                        <span class="bmd-help">
                            <?= Html::activeHint($model, 'invoice_id'); ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="<?= Html::getInputId($model, 'customer_no'); ?>" class="form-label">
                            <?= Html::activeLabel($stmt, 'customer_no'); ?>
                        </label>
                        <!--= $form->field($stmt, 'customer_no')->dropDownList(ArrayHelper::map(Customer::find()->all(), 'customer_no', function ($cust) {
                                    return $cust->first_name . ' ' . $cust->last_name;
                                }))->label(false); ?-->

                        <?php
                        echo Typeahead::widget([
                            'model' => $customer,
                            'attribute' => 'fullName',
                            // 'displayValue' => $model->fullName,
                            // 'options' => ['placeholder' => 'Filter as you type ...'],
                            'dataset' => [
                                [
                                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                    'display' => 'value',
                                    //'prefetch' => \yii\helpers\Json::encode([['value' => $customer->fullName]]),
                                    'initialize' => false,
                                    'remote' => [
                                        'url' => Url::to(['customer/typehead']) . '?q=%QUERY',
                                        'wildcard' => '%QUERY'
                                    ]
                                ]
                            ],
                            'options' => [
                                'id' => 'cust-id',
                                //'class' => 'card bg-success text-white',
                        
                            ],
                            'pluginOptions' => [
                                //'dropdownParent' => '#hello-popover', // set this to "#<EDITABLE_ID>-popover" to ensure select2 renders properly within the popover
                                'allowClear' => true,
                            ],
                            'pluginEvents' => [
                                "typeahead:select" => 'function(event, response) {					
                                                $("#' . Html::getInputId($stmt, 'customer_no') . '").val(response.id);
                                                }',
                            ],
                            // 'contentOptions' => ['style' => 'width:350px'],
                        
                        ]); ?>
                        <span class="bmd-help">
                            <?= Html::activeHint($stmt, 'customer_no'); ?>
                        </span>
                    </div>

                    <div class="form-group">
                        
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="<?= Html::getInputId($stmt, 'ship_date'); ?>">
                            <?= Html::activeLabel($stmt, 'ship_date'); ?>
                        </label>
                        <?php
                       
                        echo DatePicker::widget([
                            'model' => $stmt,
                            'attribute' => 'ship_date',
                            'options' => ['placeholder' => 'Enter Delivery date ...'],
                            'size' => 'lg',
                            'type' => DatePicker::TYPE_COMPONENT_APPEND,
                            'pickerIcon' => '<b class="material-icons"><span class="material-icons">calendar_month</span></b>',
                            'pluginOptions' => [
                                'autoclose' => true
                            ]
                        ]);
                     
                        ?>
                        <!--= $form->field($stmt, 'ship_date')->textInput(['maxlength' => true, 'class' => 'form-control datetimepicker'])->label(false); ?-->
                        <span class="bmd-help">
                            <?= Html::activeHint($stmt, 'ship_date'); ?>
                        </span>
                    </div>
                    <div class="form-group">
                    <label for="<?= Html::getInputId($stmt, 'venue_id'); ?>" class="">
                            <?= Html::activeLabel($stmt, 'venue_id'); ?>
                        </label>
                        
                            <?php
                            echo Select2::widget([
                                    'data' => ArrayHelper::map(Venue::find()->all(), 'venue_id', function ($place) {
                                        return $place->ship_name . ',' .
                                            $place->ship_add1 . ',' .
                                            $place->ship_add2 . ',' .
                                            $place->ship_city . ',' .
                                            $place->ship_state . '-' .
                                            $place->ship_phone1 . ',' .
                                            $place->ship_phone2;

                                    }),
                                    'model' => $stmt,
                                    'attribute' => 'venue_id',
                                    'size' => Select2::MEDIUM,
                                    'class' => 'form-control',
                                  //  'placeholder' => 'type venue name...'
                                    // 'addon' => ['prepend' => 'Select']   
                              
                           ] );
                            ?>
                            <span class="bmd-help">
                                <?= Html::activeHint($stmt, 'venue_id'); ?>
                            </span>
                        
                    </div>                   
                </div>
            </div>
            <div class="col-12">
                <div class="button-group d-flex justify-content-center flex-wrap">
                    <?php
                    echo $form->field($stmt, 'customer_no')->hiddenInput()->label(false);
                    ?>
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary m-2' : 'btn btn-primary']) ?>

                   <!-- <button class="main-btn danger-btn-outline m-2">
                        Cancel
                    </button>
                                --> 
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>