<?php

use kartik\widgets\DatePicker;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Task $task */
/** @var yii\bootstrap4\ActiveForm $form */
$task->status = 0;
?>
<div class="task-form">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($task, 'month')->widget(DatePicker::class, [
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
                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($task, 'start_date')->widget(DatePicker::class, [
                                'removeButton' => false,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]); ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($task, 'end_date')->widget(DatePicker::class, [
                                'removeButton' => false,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]); ?>
                        </div>
                    </div>
                    <?= $form->field($task, 'factory_id')->hiddenInput()->label(false) ?>
                    <?= $form->field($task, 'status')->hiddenInput()->label(false) ?>

                    <?= $form->field($task, 'description')->textarea(['rows' => 10]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
