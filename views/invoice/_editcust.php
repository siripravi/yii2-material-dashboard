<?php
use kartik\editable\Editable;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<h5 class="card-title">Billing</h5>
<?php Pjax::begin() ?>

<?php $editable = Editable::begin([
    'model' => $customer,
    'attribute' => 'fullName',
    // 'name' => 'fullName',
    'displayValue' => $customer->fullAddress,
    // 'pjaxContainerId'=>'full-address',
    'asPopover' => false,
    'closeOnBlur' => true,
    'format' => Editable::FORMAT_BUTTON,
    'inputType' => Editable::INPUT_TYPEAHEAD,
    'inlineSettings' => [
       // 'templateBefore' => Editable::INLINE_BEFORE_2,
      //  'templateAfter' => Editable::INLINE_AFTER_2,
      'class' => 'card bg-success text-white'
    ],
    'formOptions' => [
        'method' => 'post',
        'id' => 'form_name',
        'action' => ['/statement/edit-cust', 'id' => $stmt->id]
    ],

    'options' => [
        'id' => 'cust-address',
        'class' => 'card bg-success text-white',
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
    ],
    'pluginOptions' => [
        //'dropdownParent' => '#hello-popover', // set this to "#<EDITABLE_ID>-popover" to ensure select2 renders properly within the popover
        'allowClear' => true,
    ],
    'pluginEvents' => [
        "typeahead:select" => 'function(event, response) {					
                        $("#' . Html::getInputId($customer, 'customer_no') . '").val(response.id);
                        }',
        "editableSuccess" => "function(event, val, form, data) { 
                        //alert(val);
                      //  document.getElementById('bill-adrs').innerHtml = val;
                      //  console.log(val); console.log(data.url); if(data.status){ window.location.href = data.url;}
						$.pjax.reload({container: '#cust-address-cont'});
                        }"
                    ], 'contentOptions' => ['style' => 'width:350px'],
]);
$form = $editable->getForm();
echo $form->field($customer, 'customer_no')->hiddenInput()->label(false);

Editable::end();
?>
<?php Pjax::end() ?>