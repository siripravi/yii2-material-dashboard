<div class="invoice-form">
    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-3',
                // 'offset' => 'col-sm-offset-1',
                'wrapper' => 'col-sm-9',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]); ?>
    <?= $form->field($model, 'invoice_id')->textInput(['maxlength' => 10]) ?>
    <?php
    echo $form->field($stmt, 'venue_id')->widget(
        Select2::className(),
        [
            'items' => ArrayHelper::map(Venue::find()->all(), 'venue_id', function ($place) {
                return $place->ship_name . ',' .
                    $place->ship_add1 . ',' .
                    $place->ship_add2 . ',' .
                    $place->ship_city . ',' .
                    $place->ship_state . '-' .
                    $place->ship_phone1 . ',' .
                    $place->ship_phone2;
            }),
            'size' => Select2::SMALL,
            'class' => 'form-control'

            // 'addon' => ['prepend' => 'Select']   
        ]
    );
    ?>

    <?= $form->field($stmt, 'customer_no')->dropDownList(ArrayHelper::map(Customer::find()->all(), 'customer_no', function ($cust) {
        return $cust->first_name . ' ' . $cust->last_name;
    })) ?>

    <?= $form->field($stmt, 'ship_date')->widget(
        DatePicker::className(),
        [
            'language' => 'en',
            'clientOptions' => [
                'dateFormat' => 'd-m-yy',
                'language' => 'US',
                'country' => 'IN',
                'showAnim' => 'fold',
                'yearRange' => 'c-25:c+0',
                'changeMonth' => true,
                'changeYear' => true,
                'autoSize' => true,
                'showOn' => "button",
                //'buttonImage'=> "images/calendar.gif",
                'htmlOptions' => [
                    'style' => 'width:80px;',
                    'font-weight' => 'x-small',
                ],
            ]
        ]
    ) ?>
    <?= $form->field($stmt, 'closed')->checkBox(['maxlength' => 1]) ?>
    <div class="col-lg-offset-5 col-lg-11">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>