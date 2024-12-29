<?php

use kartik\widgets\DatePicker;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Plan $plan */
/** @var yii\bootstrap4\ActiveForm $form */
?>
<div class="plan-form">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($plan, 'month')->widget(DatePicker::class, [
                        'options' => [
                            'placeholder' => 'Введите месяц ...',
                        ],
                        'removeButton' => false,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm',
                            'minViewMode' => 1,     // Set to 1 to show months only
                            'maxViewMode' => 2,     // Optional: set the maximum view to year
                        ]
                    ]); ?>
                    <?= $form->field($plan, 'factory_id')->hiddenInput()->label(false) ?>

                    <?= $form->field($plan, 'amount')->textInput() ?>

                    <?= $form->field($plan, 'profit')->textInput() ?>

                    <?= $form->field($plan, 'sht_amount')->textInput() ?>

                    <?= $form->field($plan, 'kg_amount')->textInput() ?>

                    <div class="form-group">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
