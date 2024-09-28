<?php

use kartik\editable\Editable;
use yii\helpers\Url;

use yii\helpers\Html;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="card">
	<div class="card-header">
		<h5 class="card-title">Invoice</h5>
	</div>
	<div class="card-body">

		<ul class="nav nav-tabs card-header-tabs" data-bs-tabs="tabs">
			<li class="nav-item">
				<a class="nav-link active" href="#home" data-bs-toggle="tab">
					<i class="material-icons">bug_report</i> Home
					<div class="ripple-container"></div>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#customer" data-bs-toggle="tab">
					<i class="material-icons">code</i> Billing
					<div class="ripple-container"></div>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#delivery" data-bs-toggle="tab">
					<i class="material-icons">cloud</i> Delivery
					<div class="ripple-container"></div>
				</a>
			</li>
		</ul>
		<div class="tab-content" style="margin-top:36px;">
			<div class="tab-pane active" id="home">
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
				</div>
				<?php app\components\AngularHelper::end(); ?>
			</div>
			<div class="tab-pane" id="customer">
				<div class="object-form">
					<div id="custContent">
						<?php
						//\yii\widgets\Pjax::begin(['id' => 'pjax-container', 'enablePushState' => false]); 
						?>
						<?= $this->render('_editcust', ['customer' => $customer, 'stmt' => $stmt]);
						//\yii\widgets\Pjax::end();
						?>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="delivery">
				<div class="object-form">
					<div id="delvContent">
						<?php
						//\yii\widgets\Pjax::begin(['id' => 'pjax-container', 'enablePushState' => false]); 
						?>
						<?= $this->render('_editdelv', ['delivery' => $delivery, 'stmt' => $stmt]);
						//\yii\widgets\Pjax::end();
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>