<?php

use kartik\editable\Editable;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use yii\widgets\Pjax;
use app\models\Venue;
use yii\web\JsExpression;

?>

<h5 class="card-title">Delivery</h5>
<?php
$dataList = Venue::find()->all();
$data = ArrayHelper::map($dataList, 'venue_id', 'ship_name', 'full_address');
//print_r($data);die;
$url = Url::to(['venue/venue-list']);
?>

<?php Pjax::begin() ?>

<?php $editable = Editable::begin([
    'model' => $delivery,
    'attribute' => 'ship_name',
    'displayValue' => $delivery->fullAddress,
    'asPopover' => false,
    // 'closeOnBlur' => true,
    'format' => Editable::FORMAT_BUTTON,
    'inputType' => Editable::INPUT_SELECT2,
    'inlineSettings' => [
         'templateBefore' => Editable::INLINE_BEFORE_2,
         'templateAfter' => Editable::INLINE_AFTER_2,
        'class' => 'card card-success'
    ],
    'editableButtonOptions' => [
             'label'  => '<i class="bi bi-pencil"></i>'
    ],
    'preHeader' => '',
    'footer' => '',
    'formOptions' => [
        'method' => 'post',
        'id' => 'form_name2',
        'action' => ['/statement/edit-delv', 'id' => $stmt->id]
    ],

    'options' => [
        'id' => 'delv-address',
        'data' => $data,
        'options' => ['placeholder' => 'Search for venue ...'],

    ],
    'pluginOptions' => [
        'allowClear' => true,
        'minimumInputLength' => 3,
        //'dropdownParent' => '#delv-address-popover',
        'language' => [
            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
        ],
        'ajax' => [
            'url' => $url,
            'dataType' => 'json',
            'delay' => 250,
            'cache' => true
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        'templateResult' => new JsExpression('formatRepo'),
        'templateSelection' => new JsExpression('formatRepoSelection'),
    ],
    'pluginEvents' => [
        "select2:select" => 'function(event) {
            $("#' . Html::getInputId($delivery, 'venue_id') . '").val(event.params.data.id);
            }',
        "editableSuccess" => "function(event, val, form, data) { 
              	$.pjax.reload({container: '#delv-address-cont'});
                        }"

    ],
    'contentOptions' => ['style' => 'width:350px'],

]);
$form = $editable->getForm();
//$editable->afterInput = $form->field($delivery,'full_address');
echo $form->field($delivery, 'venue_id')->hiddenInput()->label(false);
Editable::end();
?>
<?php Pjax::end() ?>