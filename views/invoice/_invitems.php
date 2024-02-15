<?php
use yii\bootstrap\Tabs;
use app\models\Payments;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="invoice-update">
    <?= $this->render('edit', ['model' => $model, 'stmt' => $stmt, 'items' => $model->lineItems, 'angular' => $angular]); ?>

</div>