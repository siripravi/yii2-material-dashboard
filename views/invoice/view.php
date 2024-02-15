<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var app\models\Invoice $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-view">

    <h1>
        <?= Html::encode($this->title) ?>
    </h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->st_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->st_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'st_id',
            'invoice_id',
           // 'CUSTOMER_NO',
           // 'INVOICE_DATE',
            /*'SHIP_DATE',
            'SHIP_NAME',
            'SHIP_ADD1',
            'SHIP_ADD2',
            'SHIP_CITY',
            'SHIP_STATE',
            'SHIP_ZIP',
            'SHIP_PHONE1',
            'SHIP_PHONE2',
            'SHIP_EMAIL1:email',
            'SHIP_DETAILS',*/
            'CLOSED',
            'NOTES',
        ],
    ]) ?>

</div>