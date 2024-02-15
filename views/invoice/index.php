<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var app\models\InvoiceSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Invoices Admin';
$this->params['breadcrumbs'][] = $this->title;
//$this->context->layout = '@app/views/views/layouts/column2';
//echo 'List of invoices';
?>


<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Authors table</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="material-datatables">
                    <?php Pjax::begin([
                        'enablePushState' => true,
                    ]); ?>
                    <!--?= $this->render('_modal', [
                                    'model' => new app\models\Invoice,
                                    'stmt' => new app\models\Statement,
                                    'title' => "Create Invoice",
                                    'label' => 'New'
                                ]) ?-->

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <p>

                        <!--= Html::a('Create Invoice', ['create'], ['class' => 'btn btn-success']) ?-->
                    </p>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'tableOptions' => [
                            'class' => 'table table-striped table-no-bordered table-hover',
                        ],
                        'options' => ['class' => 'table-responsive grid-view'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'st_id',
                            'invoice_id',
                            //  ['CUSTOMER_NO',['class' => 'yii\grid\DropdownColumn']],
                            //  'INVOICE_DATE',
                            // 'statement.ship_date',
                            [
                                'label' => 'Ship Date',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return Html::a($data->statement ? $data->statement->ship_date : '', ['#', 'id' => $data->st_id]);
                                },
                            ],
                            // 'SHIP_NAME',
                            // 'SHIP_ADD1',
                            // 'SHIP_ADD2',
                            // 'SHIP_CITY',
                            // 'SHIP_STATE',
                            // 'SHIP_ZIP',
                            // 'SHIP_PHONE1',
                            // 'SHIP_PHONE2',
                            // 'SHIP_EMAIL1:email',
                            // 'SHIP_DETAILS',
                            // 'CLOSED',
                            // 'NOTES',
                    
                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>

                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>