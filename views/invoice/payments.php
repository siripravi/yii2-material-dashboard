<h3></h3>Payment History</h3>
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\PaymentsSearch;
use yii\data\ArrayDataProvider;

//use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Customer;
use app\models\Invoice;
use yii\jui\DatePicker;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use bootui\select2\Select2;

/**
 * @var yii\web\View $this
 * @var app\models\PaymentsSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

//$this->title = 'Payments';
//$this->params['breadcrumbs'][] = $this->title;
$searchModel = new PaymentsSearch();
// $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$provider = new ArrayDataProvider(
    [
        'allModels' => $items,
        //'sort' => [ 'attributes' => ['id', 'username', 'email'], ], 
        'pagination' => ['pageSize' => 20,
        ],
    ]
);


?>
<div class="payments-index">

    <h1>
        <?= Html::encode($this->title) ?>
    </h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Payments', ['create'], ['data-toggle' => 'modal', 'data-target' => '#payModal', 'class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $provider,
        //  'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'PAY_DATE',
            //'ID',
            // 'INVOICE_ID',
            'MODE_ID',
            'AMOUNT',

            'DETAILS',
            'DEPOSITED_BY',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

<?php
Modal::begin([
    'header' => '<h2>Create Payment</h2>',
    'id' => 'payModal'
    //'toggleButton' => ['label' => 'Post Payment'],
]);

$pay->INVOICE_ID = $model->INVOICE_ID;
?>
<div class="invoice-form">
    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-4',
                'offset' => 'col-sm-offset-1',
                'wrapper' => 'col-sm-8',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]); ?>

    <?php
    echo $form->field($pay, 'INVOICE_ID')->widget(Select2::className(), [
        'items' => ArrayHelper::map(
            Invoice::find()->all(),
            'INVOICE_ID',
            function ($inv) {
                return $inv->INVOICE_ID;
            }
        ),
        'size' => Select2::SMALL,
        'class' => 'form-control'
        // 'addon' => ['prepend' => 'Select']   
    ]);
    ?>
    <?= $form->field($pay, 'MODE_ID')->dropDownList(['1' => 'Cash', '2' => 'Cheque', '3' => 'Debit Card', '4' => 'Direct Deposit']) ?>

    <?= $form->field($pay, 'PAY_DATE')->widget(Datepicker::className(), [
        'language' => 'en',
        'model' => $model,
        'attribute' => 'PAY_DATE',
        'clientOptions' => [
            'dateFormat' => 'yy-mm-dd',
        ],
    ]); ?>

    <!--= $form->field($model, 'PAY_DATE')->textInput() ?-->
    <?= $form->field($pay, 'AMOUNT')->textInput(['maxlength' => 10]) ?>
    <?= $form->field($pay, 'DETAILS')->textInput(['maxlength' => 100]) ?>
    <?= $form->field($pay, 'DEPOSITED_BY')->textInput(['maxlength' => 25]) ?>

    <div class="form-group pull-right">
        <?= Html::submitButton($pay->isNewRecord ? 'Create' : 'Update', ['class' => $pay->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php
Modal::end();
?>