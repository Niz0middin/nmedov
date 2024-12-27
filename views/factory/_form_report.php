<?php

use kartik\widgets\DatePicker;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $factory app\models\Factory */
/* @var $report app\models\Report */
/* @var $products app\models\Product[] */
/* @var $reportProducts app\models\ReportProduct[] */

?>
<div class="report-form">
    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($report, 'date')->widget(DatePicker::class, [
                        'options' => [
                            'placeholder' => 'Введите дату отчета ...',
                        ],
                        'removeButton' => false,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd',
                            'daysOfWeekDisabled' => [0]]
                    ]); ?>
                    <?= $form->field($report, 'factory_id')->hiddenInput()->label(false) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($report, 'expense')->textInput(['type' => 'number', 'step' => 0.01, 'min' => 0]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($report, 'expense_description')->textInput(['max' => 255]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($report, 'cash_amount')->textInput(['type' => 'number', 'step' => 0.01, 'min' => 0]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($report, 'transfer_amount')->textInput(['type' => 'number', 'step' => 0.01, 'min' => 0]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Продукт</th>
                            <th>Количество</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= Html::encode($product->name) ?></td>
                                <td>
                                    <div class="input-group">
                                        <?= Html::activeInput('number', $report, "reportProductsData[$product->id][amount]", [
                                            'value' => $reportProducts[$product->id]['amount'] ?? 0,
                                            'class' => 'form-control',
                                            'step' => 1,
                                            'min' => 0,
                                        ]) ?>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><?= $product->unit ?></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
